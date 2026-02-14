<?php

namespace App\Http\Controllers;

use App\Models\ResumeAnalysis;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;

class ResumeAnalysisController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Show resume analysis dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $analyses = $user->resumeAnalyses()
            ->latest()
            ->paginate(10);

        $stats = [
            'total_analyses' => $user->resumeAnalyses()->count(),
            'average_score' => $user->resumeAnalyses()->avg('ats_score') ?? 0,
        ];

        return view('resume-analysis.index', compact('analyses', 'stats'));
    }

    /**
     * Upload and analyze resume
     */
    public function upload(Request $request)
    {
        $request->validate([
            'resume_file' => [
                'required',
                'file',
                'max:5120', // 5MB max
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
                    
                    if (!in_array($extension, $allowedExtensions)) {
                        $fail('The resume file must be a PDF, DOC, DOCX, or TXT file.');
                    }
                },
            ],
            'job_description' => 'nullable|string|max:5000',
        ]);

        $user = Auth::user();
        $file = $request->file('resume_file');

        // Store file
        $path = $file->store('resume-analyses', 'private');

        // Extract text from file
        $extractionResult = $this->extractText($file);

        if (!$extractionResult['success']) {
            Storage::disk('private')->delete($path);
            return back()->with('error', $extractionResult['message']);
        }
        
        $resumeText = $extractionResult['text'];

        // Get AI analysis
        $analysis = $this->gemini->reviewResume(
            $resumeText,
            $request->job_description,
            $this->getUserProfile()
        );

        // Check if the AI analysis failed
        $failureMessages = [
            'Unable to analyze resume at this time',
            'I apologize, but I\'m having trouble connecting',
        ];
        
        $analysisIsFailed = false;
        foreach ($failureMessages as $failureMsg) {
            if (str_contains($analysis, $failureMsg)) {
                $analysisIsFailed = true;
                break;
            }
        }

        if ($analysisIsFailed) {
            \Log::error('Resume analysis: AI returned failure response', [
                'file' => $file->getClientOriginalName(),
                'response_preview' => substr($analysis, 0, 200),
            ]);
            Storage::disk('private')->delete($path);
            return back()->with('error', 'AI analysis failed. Please check your internet connection and try again. If the issue persists, the AI service may be temporarily unavailable.');
        }

        // Log successful analysis for debugging
        \Log::info('Resume analysis successful', [
            'file' => $file->getClientOriginalName(),
            'analysis_length' => strlen($analysis),
        ]);

        // Parse analysis to extract score
        $atsScore = $this->extractAtsScore($analysis);

        // Save analysis
        $resumeAnalysis = $user->resumeAnalyses()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'resume_text' => $resumeText,
            'job_description' => $request->job_description,
            'ai_analysis' => $analysis,
            'ats_score' => $atsScore,
            'analyzed_at' => now(),
        ]);

        return redirect()->route('resume-analysis.show', $resumeAnalysis)
            ->with('success', 'Resume analyzed successfully!');
    }

    /**
     * Show analysis results
     */
    public function show(ResumeAnalysis $analysis)
    {
        $this->authorize('view', $analysis);

        // Convert the AI's markdown response to HTML for display
        $formattedAnalysis = \Illuminate\Support\Str::markdown($analysis->ai_analysis ?? '');

        return view('resume-analysis.show', compact('analysis', 'formattedAnalysis'));
    }

    /**
     * Delete analysis
     */
    public function destroy(ResumeAnalysis $analysis)
    {
        $this->authorize('delete', $analysis);

        // Delete file
        if ($analysis->file_path) {
            Storage::disk('private')->delete($analysis->file_path);
        }

        $analysis->delete();

        return redirect()->route('resume-analysis.index')
            ->with('success', 'Analysis deleted successfully');
    }

    /**
     * Extract text from uploaded file
     */
    protected function extractText($file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        try {
            if ($extension === 'pdf') {
                // Check if PDF parser is available
                if (!class_exists('Smalot\PdfParser\Parser')) {
                    \Log::error('PDF Parser not installed. Run: composer require smalot/pdfparser');
                    return [
                        'success' => false,
                        'message' => 'PDF processing library is not installed. Please contact support.',
                    ];
                }
                
                $parser = new PdfParser();
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText();
                
                // Clean up the text
                $text = trim($text);
                
                if (empty($text)) {
                    \Log::warning('PDF parsed but no text extracted', [
                        'file' => $fileName,
                    ]);
                    return [
                        'success' => false,
                        'message' => 'Your PDF appears to be a scanned image or contains no text. Please use a PDF with selectable text, or try uploading a DOCX or TXT file instead.',
                    ];
                }
                
                return [
                    'success' => true,
                    'text' => $text,
                ];
                
            } elseif ($extension === 'txt') {
                $text = file_get_contents($filePath);
                $text = trim($text);
                
                if (empty($text)) {
                    return [
                        'success' => false,
                        'message' => 'The text file appears to be empty.',
                    ];
                }
                
                return [
                    'success' => true,
                    'text' => $text,
                ];
                
            } elseif ($extension === 'docx') {
                // For DOCX files using ZipArchive
                if (!class_exists('ZipArchive')) {
                    \Log::error('ZipArchive not available');
                    return [
                        'success' => false,
                        'message' => 'DOCX processing is not available. Please try PDF or TXT format.',
                    ];
                }
                
                $zip = new \ZipArchive();
                if ($zip->open($filePath) === true) {
                    $content = $zip->getFromName('word/document.xml');
                    $zip->close();
                    
                    if ($content === false) {
                        \Log::error('Could not extract document.xml from DOCX', ['file' => $fileName]);
                        return [
                            'success' => false,
                            'message' => 'Could not read DOCX file. The file may be corrupted. Please try re-saving it or use PDF/TXT format.',
                        ];
                    }
                    
                    // Strip XML tags and clean up
                    $text = strip_tags($content);
                    $text = preg_replace('/\s+/', ' ', $text); // Normalize whitespace
                    $text = trim($text);
                    
                    if (empty($text)) {
                        \Log::warning('DOCX parsed but no text extracted', ['file' => $fileName]);
                        return [
                            'success' => false,
                            'message' => 'The DOCX file appears to be empty or contains no readable text.',
                        ];
                    }
                    
                    return [
                        'success' => true,
                        'text' => $text,
                    ];
                }
                
                \Log::error('Could not open DOCX file with ZipArchive', ['file' => $fileName]);
                return [
                    'success' => false,
                    'message' => 'Could not open DOCX file. Please try re-saving it or use PDF/TXT format.',
                ];
                
            } elseif ($extension === 'doc') {
                // For old DOC files, just try to read as text
                // This is a fallback and may not work well
                $text = file_get_contents($filePath);
                
                // Try to extract readable text (very basic)
                $text = preg_replace('/[^\x20-\x7E\n\r\t]/', '', $text);
                $text = trim($text);
                
                if (strlen($text) < 50) {
                    \Log::warning('DOC file extraction resulted in very little text', ['file' => $fileName]);
                    return [
                        'success' => false,
                        'message' => 'Old DOC format is not fully supported. Please save your resume as DOCX, PDF, or TXT format.',
                    ];
                }
                
                return [
                    'success' => true,
                    'text' => $text,
                ];
            }
            
            \Log::error('Unsupported file extension', [
                'extension' => $extension,
                'file' => $fileName,
            ]);
            
            return [
                'success' => false,
                'message' => 'Unsupported file format. Please use PDF, DOCX, or TXT.',
            ];
            
        } catch (\Exception $e) {
            \Log::error('Text extraction failed', [
                'file' => $fileName,
                'extension' => $extension,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return [
                'success' => false,
                'message' => 'An error occurred while processing your file: ' . $e->getMessage() . '. Please try a different format or contact support.',
            ];
        }
    }

    /**
     * Extract ATS score from AI analysis
     */
    protected function extractAtsScore(string $analysis): int
    {
        // Try to find score in the exact format we requested: "ATS COMPATIBILITY SCORE: X/100"
        if (preg_match('/ATS\s+COMPATIBILITY\s+SCORE[:\s]+(\d+)\/100/i', $analysis, $matches)) {
            return min(100, max(0, (int)$matches[1]));
        }
        
        // Try format: "ATS COMPATIBILITY SCORE: X"
        if (preg_match('/ATS\s+COMPATIBILITY\s+SCORE[:\s]+(\d+)/i', $analysis, $matches)) {
            return min(100, max(0, (int)$matches[1]));
        }
        
        // Try format: "Score: X/100" or "Score: X"
        if (preg_match('/(?:score|rating)[:\s]+(\d+)(?:\/100)?/i', $analysis, $matches)) {
            return min(100, max(0, (int)$matches[1]));
        }
        
        // Try format: "X/100"
        if (preg_match('/(\d+)\/100/', $analysis, $matches)) {
            return min(100, max(0, (int)$matches[1]));
        }
        
        // Try format: "X%" 
        if (preg_match('/(\d+)%/', $analysis, $matches)) {
            return min(100, max(0, (int)$matches[1]));
        }

        // If no score found, return a reasonable default based on analysis length
        // Longer, detailed analysis suggests better resume
        $wordCount = str_word_count($analysis);
        if ($wordCount > 500) return 75;
        if ($wordCount > 300) return 65;
        return 55;
    }

    /**
     * Get user profile for AI context
     */
    protected function getUserProfile(): array
    {
        $user = Auth::user();

        return [
            'name' => $user->name,
            'university' => $user->university,
            'field_of_study' => $user->field_of_study,
            'graduation_year' => $user->graduation_year,
            'experience_level' => $user->experience_level,
        ];
    }
}
