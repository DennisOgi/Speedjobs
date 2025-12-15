<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    /**
     * Display list of user's resumes
     */
    public function index()
    {
        $resumes = auth()->user()->resumes ?? collect();
        return view('resume.index', compact('resumes'));
    }

    /**
     * Show the resume builder
     */
    public function create()
    {
        $templates = Resume::getAvailableTemplates();
        $colorSchemes = Resume::getColorSchemes();
        $user = auth()->user();
        
        // Pre-fill with user data
        $defaultData = [
            'full_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'location' => $user->location,
        ];

        return view('resume.create', compact('templates', 'colorSchemes', 'defaultData'));
    }

    /**
     * Store a new resume
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template' => 'required|string',
            'color_scheme' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'full_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'experience' => 'nullable|array',
            'education' => 'nullable|array',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'certifications' => 'nullable|array',
            'projects' => 'nullable|array',
            'awards' => 'nullable|array',
            'references' => 'nullable|array',
            'section_order' => 'nullable|array',
            'visible_sections' => 'nullable|array',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('resume-photos', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['last_edited_at'] = now();

        $resume = Resume::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Resume saved successfully!',
                'resume' => $resume,
            ]);
        }

        return redirect()->route('resume.edit', $resume)->with('success', 'Resume created successfully!');
    }

    /**
     * Edit an existing resume
     */
    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume);

        $templates = Resume::getAvailableTemplates();
        $colorSchemes = Resume::getColorSchemes();

        return view('resume.edit', compact('resume', 'templates', 'colorSchemes'));
    }

    /**
     * Update a resume
     */
    public function update(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'template' => 'sometimes|string',
            'color_scheme' => 'sometimes|string',
            'photo' => 'nullable|image|max:2048',
            'full_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'experience' => 'nullable|array',
            'education' => 'nullable|array',
            'skills' => 'nullable|array',
            'languages' => 'nullable|array',
            'certifications' => 'nullable|array',
            'projects' => 'nullable|array',
            'awards' => 'nullable|array',
            'references' => 'nullable|array',
            'section_order' => 'nullable|array',
            'visible_sections' => 'nullable|array',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($resume->photo) {
                Storage::disk('public')->delete($resume->photo);
            }
            $validated['photo'] = $request->file('photo')->store('resume-photos', 'public');
        }

        $validated['last_edited_at'] = now();

        $resume->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Resume updated successfully!',
                'resume' => $resume->fresh(),
            ]);
        }

        return redirect()->route('resume.edit', $resume)->with('success', 'Resume updated successfully!');
    }

    /**
     * Auto-save resume data (AJAX)
     */
    public function autosave(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $resume->update([
            ...$request->only([
                'template', 'color_scheme', 'full_name', 'job_title', 'email', 'phone',
                'location', 'website', 'linkedin', 'github', 'summary', 'experience',
                'education', 'skills', 'languages', 'certifications', 'projects',
                'awards', 'references', 'section_order', 'visible_sections'
            ]),
            'last_edited_at' => now(),
        ]);

        return response()->json(['success' => true, 'saved_at' => now()->format('H:i:s')]);
    }

    /**
     * Upload photo (AJAX)
     */
    public function uploadPhoto(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        // Delete old photo
        if ($resume->photo) {
            Storage::disk('public')->delete($resume->photo);
        }

        $path = $request->file('photo')->store('resume-photos', 'public');
        $resume->update(['photo' => $path]);

        return response()->json([
            'success' => true,
            'photo_url' => asset('storage/' . $path),
        ]);
    }

    /**
     * Remove photo
     */
    public function removePhoto(Resume $resume)
    {
        $this->authorize('update', $resume);

        if ($resume->photo) {
            Storage::disk('public')->delete($resume->photo);
            $resume->update(['photo' => null]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Delete a resume
     */
    public function destroy(Resume $resume)
    {
        $this->authorize('delete', $resume);

        if ($resume->photo) {
            Storage::disk('public')->delete($resume->photo);
        }

        $resume->delete();

        return redirect()->route('resume.index')->with('success', 'Resume deleted successfully!');
    }

    /**
     * Duplicate a resume
     */
    public function duplicate(Resume $resume)
    {
        $this->authorize('view', $resume);

        $newResume = $resume->replicate();
        $newResume->name = $resume->name . ' (Copy)';
        $newResume->is_primary = false;
        $newResume->created_at = now();
        $newResume->last_edited_at = now();
        
        // Copy photo if exists
        if ($resume->photo) {
            $newPath = 'resume-photos/' . uniqid() . '_' . basename($resume->photo);
            Storage::disk('public')->copy($resume->photo, $newPath);
            $newResume->photo = $newPath;
        }
        
        $newResume->save();

        return redirect()->route('resume.edit', $newResume)->with('success', 'Resume duplicated successfully!');
    }

    /**
     * Preview resume (for PDF generation)
     */
    public function preview(Resume $resume)
    {
        $this->authorize('view', $resume);
        
        return view('resume.preview', compact('resume'));
    }

    /**
     * Download resume as PDF
     */
    public function download(Resume $resume)
    {
        $this->authorize('view', $resume);

        // Return the preview page with print-optimized styles
        return view('resume.download', compact('resume'));
    }
}
