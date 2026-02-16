<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiService
{
    protected ?string $apiKey;
    protected string $model;
    protected int $maxTokens;
    protected float $temperature;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-2.5-flash');
        $this->maxTokens = config('services.gemini.max_tokens', 2048);
        $this->temperature = config('services.gemini.temperature', 0.7);
        
        // Debug which model is being used
        // echo "DEBUG: GeminiService initialized with model: {$this->model}\n";

        if (empty($this->apiKey)) {
            Log::warning('Gemini API key is not configured. Please set GEMINI_API_KEY in your .env file.');
        }
    }

    /**
     * Send a message to Gemini and get a response (Blocking)
     */
    public function sendMessage(string $prompt, array $context = [], array $conversationHistory = []): array
    {
        if (empty($this->apiKey)) {
            return $this->getMockResponse();
        }

        try {
            $systemPrompt = $this->buildSystemPrompt($context);
            $contents = $this->buildContents($systemPrompt, $conversationHistory, $prompt);

            $response = Http::withoutVerifying()->timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}", [
                    'contents' => $contents,
                    'generationConfig' => $this->getGenerationConfig(),
                    'safetySettings' => $this->getSafetySettings(),
                ]);

            if (!$response->successful()) {
                throw new \Exception('Gemini API Error: ' . $response->body());
            }

            $data = $response->json();
            $responseText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            return [
                'content' => $responseText,
                'metadata' => [
                    'model' => $this->model,
                    'finish_reason' => $data['candidates'][0]['finishReason'] ?? 'UNKNOWN',
                ],
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Service Error', ['message' => $e->getMessage()]);
            return [
                'content' => "I apologize, but I'm having trouble connecting right now. Please try again.",
                'metadata' => ['error' => true],
            ];
        }
    }

    /**
     * Stream a message to Gemini (Generator)
     * Yields chunks of text as they arrive.
     */
    public function streamMessage(string $prompt, array $context = [], array $conversationHistory = []): \Generator
    {
        if (empty($this->apiKey)) {
            yield "⚠️ API Key missing.";
            return;
        }

        $systemPrompt = $this->buildSystemPrompt($context);
        $contents = $this->buildContents($systemPrompt, $conversationHistory, $prompt);

        $response = Http::withoutVerifying()->timeout(120)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->withOptions(['stream' => true]) // Guzzle stream option
            ->post("{$this->baseUrl}/models/{$this->model}:streamGenerateContent?key={$this->apiKey}", [
                'contents' => $contents,
                'generationConfig' => $this->getGenerationConfig(),
                'safetySettings' => $this->getSafetySettings(),
            ]);

        $body = $response->toPsrResponse()->getBody();

        // Buffer to handle partial JSON chunks
        $buffer = '';

        while (!$body->eof()) {
            $chunk = $body->read(1024);
            $buffer .= $chunk;

            // Simple parser to extract JSON objects from the stream
            // The stream returns multiple JSON objects like { ... }\n{ ... } or in an array structure depending on endpoint
            // streamGenerateContent returns a list of GenerateContentResponse objects
            
            // We'll process valid JSON objects from the buffer
            while (($start = strpos($buffer, '{')) !== false && ($end = strpos($buffer, '}', $start)) !== false) {
                // This naive parsing works for simple cases but sophisticated streams might need a real parser
                // Actually, Gemini stream returns a JSON array structure often "[{},{},...]" or separate objects.
                // Let's use a simpler approach: Try to decode complete lines if separated by newlines, 
                // but Gemini usually sends a JSON array wrapper.
                
                // ALTERNATIVE: Use the 'lines' approach if the API supports line-delimited JSON.
                // Gemini standard is usually a JSON array opening '[' then objects separated by ','
                
                // For robustness in this quick implementation, let's just yield the raw text if we can extract it,
                // or easier: just yield the chunk and let the frontend handle the jitter, OR implement a smoother logic.
                
                // BETTER: Just yield the chunk. The frontend will append.
                // WAIT, we need to extract the TEXT from the JSON chunk.
                // Let's rely on a simpler regex to find "text": "..." patterns in the incoming chunk stream
                // This is hacky but efficient for PHP streaming without a dedicated library.
                
                 if (preg_match_all('/"text":\s*"([^"]+)"/', $chunk, $matches)) {
                    foreach ($matches[1] as $text) {
                        // Unescape JSON string
                       yield json_decode('"' . $text . '"');
                    }
                }
                
                // Clear processed chunk from buffer to avoid infinite loop in this logic
                $buffer = substr($buffer, 1024); 
                break; // Break inner loop to read more
            }
        }
    }

    /**
     * Analyze a job against a user profile (Structured JSON)
     */
    public function analyzeJobMatch(array $jobData, array $userProfile): array
    {
        $prompt = "Analyze the match between this candidate and the job.\n\n";
        $prompt .= "Job: " . json_encode($jobData) . "\n";
        $prompt .= "Candidate: " . json_encode($userProfile) . "\n";
        $prompt .= "Return JSON with keys: match_score (0-100), missing_skills (array), strengths (array), advice (string).";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json'; // Force JSON

        return $this->sendStructuredPrompt($prompt, $config);
    }

    public function generateProfileReport(array $userProfile): array
    {
        $prompt = "Generate a strategic career report for this user.\nUser: " . json_encode($userProfile);
        $prompt .= "\nReturn JSON with keys: summary, strengths (array), improvement_areas (array), recommended_roles (array), action_plan (array).";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';

        return $this->sendStructuredPrompt($prompt, $config);
    }

    /**
     * Generate Career Assessment Report based on user answers
     */
    public function generateCareerAssessment(array $userProfile, array $answers): array
    {
        $prompt = "You are an expert career counselor. Analyze this user's career assessment answers and provide a comprehensive Career DNA report.\n\n";
        $prompt .= "User Profile:\n" . json_encode($userProfile, JSON_PRETTY_PRINT) . "\n\n";
        $prompt .= "Assessment Answers:\n" . json_encode($answers, JSON_PRETTY_PRINT) . "\n\n";
        $prompt .= "Return JSON with these exact keys:\n";
        $prompt .= "- career_dna: object with { personality_type (string), work_style (string), core_values (array of 3 strings) }\n";
        $prompt .= "- recommended_roles: array of 5 objects, each with { title (string), match_percentage (int 0-100), reason (string) }\n";
        $prompt .= "- skill_gaps: array of 3 objects, each with { skill (string), importance (string: 'high'|'medium'|'low'), how_to_develop (string) }\n";
        $prompt .= "- strengths: array of 4 strings describing key strengths\n";
        $prompt .= "- action_plan: array of 5 objects for a 90-day plan, each with { week (string like 'Week 1-2'), action (string), expected_outcome (string) }";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';
        $config['maxOutputTokens'] = 4096;

        return $this->sendStructuredPrompt($prompt, $config);
    }

    /**
     * Generate an interview question for a specific role and step
     */
    public function generateInterviewQuestion(string $role, int $questionNumber, array $previousQA = []): array
    {
        $prompt = "You are an expert interviewer for the role of: {$role}.\n\n";
        
        if (!empty($previousQA)) {
            $prompt .= "Previous questions asked (do NOT repeat):\n";
            foreach ($previousQA as $qa) {
                $prompt .= "- Q: {$qa['question']}\n";
            }
            $prompt .= "\n";
        }
        
        $prompt .= "Generate interview question #{$questionNumber} for this role.\n";
        $prompt .= "Mix behavioral (STAR method) and competency-based questions. Make it challenging but fair.\n\n";
        $prompt .= "Return JSON with these exact keys:\n";
        $prompt .= "- question: string (the interview question)\n";
        $prompt .= "- question_type: string ('behavioral' or 'technical' or 'situational')\n";
        $prompt .= "- what_to_look_for: string (hints for evaluation, hidden from candidate)\n";
        $prompt .= "- ideal_answer_points: array of 3-4 strings (key points a good answer should cover)";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';

        return $this->sendStructuredPrompt($prompt, $config);
    }

    /**
     * Evaluate a candidate's interview answer
     */
    public function evaluateInterviewAnswer(string $role, string $question, string $answer, array $idealPoints): array
    {
        $prompt = "You are evaluating an interview answer for the role of: {$role}.\n\n";
        $prompt .= "Question: {$question}\n\n";
        $prompt .= "Candidate's Answer:\n\"{$answer}\"\n\n";
        $prompt .= "Ideal Answer Points:\n" . json_encode($idealPoints) . "\n\n";
        $prompt .= "Evaluate the answer. Return JSON with these exact keys:\n";
        $prompt .= "- score: int (0-100)\n";
        $prompt .= "- feedback: string (2-3 sentences of constructive feedback)\n";
        $prompt .= "- strengths: array of 1-2 strings (what they did well)\n";
        $prompt .= "- improvements: array of 1-2 strings (what to improve)\n";
        $prompt .= "- star_method_used: boolean (did they use Situation-Task-Action-Result structure?)";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';

        return $this->sendStructuredPrompt($prompt, $config);
    }

    /**
     * Generate final interview readiness report
     */
    public function generateInterviewReport(string $role, array $questionsAndScores): array
    {
        $prompt = "Generate an Interview Readiness Report for a candidate who completed a mock interview for: {$role}.\n\n";
        $prompt .= "Interview Performance:\n" . json_encode($questionsAndScores, JSON_PRETTY_PRINT) . "\n\n";
        $prompt .= "Return JSON with these exact keys:\n";
        $prompt .= "- overall_score: int (0-100, weighted average)\n";
        $prompt .= "- readiness_level: string ('Ready', 'Almost Ready', 'Needs Practice')\n";
        $prompt .= "- summary: string (2-3 sentence overall assessment)\n";
        $prompt .= "- key_strengths: array of 2-3 strings\n";
        $prompt .= "- areas_to_improve: array of 2-3 strings\n";
        $prompt .= "- recommended_practice: array of 3 objects with { topic (string), resource_type (string like 'video'|'article'|'practice'), why (string) }";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';
        $config['maxOutputTokens'] = 3000;

        return $this->sendStructuredPrompt($prompt, $config);
    }

    /**
     * Analyze a resume and provide structured feedback
     */
    public function analyzeResume(string $resumeText, array $userProfile = []): array
    {
        $prompt = "You are an expert ATS (Applicant Tracking System) and resume reviewer.\n\n";
        $prompt .= "Resume Content:\n\"\"\"\n{$resumeText}\n\"\"\"\n\n";
        
        if (!empty($userProfile)) {
            $prompt .= "User's Profile Data (for context):\n" . json_encode($userProfile) . "\n\n";
        }
        
        $prompt .= "Analyze this resume thoroughly. Return JSON with these exact keys:\n";
        $prompt .= "- ats_score: int (0-100, how well it would pass ATS systems)\n";
        $prompt .= "- overall_rating: string ('Excellent'|'Good'|'Needs Improvement'|'Poor')\n";
        $prompt .= "- summary_feedback: string (2-3 sentence overall assessment)\n";
        $prompt .= "- section_scores: object with keys { summary (int), experience (int), skills (int), education (int), formatting (int) } each 0-100\n";
        $prompt .= "- section_feedback: object with same keys as section_scores, values are strings with specific feedback\n";
        $prompt .= "- keywords_found: array of strings (good keywords identified)\n";
        $prompt .= "- keywords_missing: array of strings (important keywords to add based on profile/industry)\n";
        $prompt .= "- action_items: array of 5 objects with { priority ('high'|'medium'|'low'), section (string), suggestion (string) }";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';
        $config['maxOutputTokens'] = 4096;

        return $this->sendStructuredPrompt($prompt, $config);
    }

    protected function sendStructuredPrompt(string $prompt, array $config): array
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API key is empty, cannot make structured prompt request.');
            return [];
        }

        try {
            $response = Http::withoutVerifying()->timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}", [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                    'generationConfig' => $config,
                ]);

            if (!$response->successful()) {
                Log::error('Gemini API returned error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Gemini API Error (HTTP ' . $response->status() . '): ' . $response->body());
            }

            $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
            
            if (empty($text)) {
                Log::error('Gemini API returned empty text in response');
                return [];
            }
            
            // Clean up the text - remove markdown code blocks if present
            $text = preg_replace('/```json\s*/', '', $text);
            $text = preg_replace('/```\s*$/', '', $text);
            $text = trim($text);
            
            // Try to decode directly first
            $json = json_decode($text, true);
            
            // If that fails, try to extract JSON using regex
            if (json_last_error() !== JSON_ERROR_NONE) {
                if (preg_match('/(\[[\s\S]*\]|\{[\s\S]*\})/', $text, $matches)) {
                    $text = $matches[0];
                    $json = json_decode($text, true);
                }
            }
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Gemini JSON parse error', [
                    'error' => json_last_error_msg(),
                    'raw_text_preview' => substr($text, 0, 500),
                ]);
                return [];
            }
            
            return $json ?? [];

        } catch (\Throwable $e) {
            Log::error('Gemini Structured Prompt Error', ['msg' => $e->getMessage()]);
            return [];
        }
    }

    protected function getGenerationConfig(): array
    {
        return [
            'temperature' => $this->temperature,
            'maxOutputTokens' => $this->maxTokens,
            'topP' => 0.95,
            'topK' => 40,
            'candidateCount' => 1, // Only generate 1 response for speed
        ];
    }

    protected function getSafetySettings(): array
    {
        return [
            ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
            ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
            ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
            ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
        ];
    }

    protected function buildSystemPrompt(array $context): string
    {
        $prompt = "You are an expert Career Agent at SpeedJobs. Your goal is to help the user get hired.\n";
        $prompt .= "Be concise, professional, and actionable. Use Markdown.\n";
        if (!empty($context['current_page'])) {
            $prompt .= "User is currently looking at: {$context['current_page']}\n";
        }
        if (!empty($context['user_data'])) {
            $prompt .= "User Profile: " . json_encode($context['user_data']) . "\n";
        }
        return $prompt;
    }

    protected function buildContents(string $systemPrompt, array $history, string $lastMessage): array
    {
        $contents = [];
        // System instruction is best passed as standard part for simple models, 
        // or system_instruction field for newer ones. We'll use the 'user' role trick for compatibility.
        $contents[] = ['role' => 'user', 'parts' => [['text' => "System: " . $systemPrompt]]];
        $contents[] = ['role' => 'model', 'parts' => [['text' => "Understood. I am ready to assist."]]];

        foreach ($history as $msg) {
            $role = $msg['role'] === 'user' ? 'user' : 'model';
            $contents[] = ['role' => $role, 'parts' => [['text' => $msg['content']]]];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $lastMessage]]];
        return $contents;
    }

    protected function getMockResponse(): array
    {
        return [
            'content' => "This is a simulated AI response because the API key is missing.",
            'metadata' => ['mock' => true],
        ];
    }

    /**
     * Get suggested follow-up questions based on conversation history
     */
    public function getSuggestedQuestions(array $conversationHistory, array $userProfile): array
    {
        $cacheKey = 'suggested_questions_' . md5(json_encode($conversationHistory));
        
        return Cache::remember($cacheKey, 300, function () use ($conversationHistory, $userProfile) {
            $lastMessages = array_slice($conversationHistory, -3);
            $context = implode("\n", array_map(fn($m) => $m['role'] . ': ' . $m['content'], $lastMessages));
            
            $prompt = "Based on this conversation context, suggest 3 relevant follow-up questions the user might want to ask:\n\n{$context}\n\nReturn only the questions, one per line, without numbering.";
            
            $response = $this->sendMessage($prompt, $userProfile);
            
            $questions = array_filter(array_map('trim', explode("\n", $response['content'])));
            return array_slice($questions, 0, 3);
        });
    }

    /**
     * Generate interview questions for a specific role
     * Optimized to generate all questions in a single API call
     */
    public function generateInterviewQuestions(string $role, string $experienceLevel, int $count = 5): array
    {
        $prompt = "Generate {$count} interview questions for a {$experienceLevel} level {$role} position.\n\n";
        $prompt .= "Mix behavioral (STAR method), technical, and situational questions.\n";
        $prompt .= "Make them challenging but fair for the experience level.\n\n";
        $prompt .= "Return JSON array with {$count} objects, each having these exact keys:\n";
        $prompt .= "- question: string (the interview question)\n";
        $prompt .= "- type: string ('behavioral' or 'technical' or 'situational')\n";
        $prompt .= "- tips: string (brief hint for the candidate on how to approach this question)\n\n";
        $prompt .= "Example format:\n";
        $prompt .= "[\n";
        $prompt .= "  {\"question\": \"Tell me about a time...\", \"type\": \"behavioral\", \"tips\": \"Use STAR method\"},\n";
        $prompt .= "  {\"question\": \"How would you...\", \"type\": \"technical\", \"tips\": \"Explain your approach\"}\n";
        $prompt .= "]";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';
        $config['maxOutputTokens'] = 2048;

        $result = $this->sendStructuredPrompt($prompt, $config);
        
        // If result is already an array of questions, return it
        if (isset($result[0]) && is_array($result[0])) {
            return $result;
        }
        
        // If result has a 'questions' key, return that
        if (isset($result['questions']) && is_array($result['questions'])) {
            return $result['questions'];
        }
        
        // Otherwise return empty array (fallback will be used)
        return [];
    }

    /**
     * Analyze assessment results and provide career insights
     */
    public function analyzeAssessment(string $type, array $questions, array $answers, array $userProfile): string
    {
        $assessmentTitles = [
            'personality' => 'Personality Assessment (Myers-Briggs Style)',
            'skills' => 'Skills Assessment',
            'interest' => 'Interest Inventory',
            'aptitude' => 'Aptitude Test',
        ];
        
        $prompt = "You are an expert career counselor analyzing a {$assessmentTitles[$type]} for a job seeker in Africa.\n\n";
        
        $prompt .= "ASSESSMENT RESPONSES:\n";
        $prompt .= "==================\n";
        foreach ($questions as $index => $question) {
            $answer = $answers[$index] ?? 'No answer';
            $prompt .= ($index + 1) . ". {$question}\n";
            $prompt .= "   Answer: {$answer}\n\n";
        }
        
        if (!empty($userProfile['name'])) {
            $prompt .= "\nCANDIDATE PROFILE:\n";
            $prompt .= "==================\n";
            if (!empty($userProfile['university'])) $prompt .= "University: {$userProfile['university']}\n";
            if (!empty($userProfile['field_of_study'])) $prompt .= "Field of Study: {$userProfile['field_of_study']}\n";
            if (!empty($userProfile['graduation_year'])) $prompt .= "Graduation Year: {$userProfile['graduation_year']}\n";
            if (!empty($userProfile['experience_level'])) $prompt .= "Experience Level: {$userProfile['experience_level']}\n";
            if (!empty($userProfile['location'])) $prompt .= "Location: {$userProfile['location']}\n";
            $prompt .= "\n";
        }
        
        $prompt .= "ANALYSIS REQUIREMENTS:\n";
        $prompt .= "=====================\n";
        $prompt .= "Provide a comprehensive, encouraging, and actionable analysis with these sections:\n\n";
        
        $prompt .= "1. OVERALL SUMMARY (2-3 sentences)\n";
        $prompt .= "   - Key personality traits or assessment highlights\n";
        $prompt .= "   - Overall impression\n\n";
        
        $prompt .= "2. KEY STRENGTHS (3-4 specific strengths)\n";
        $prompt .= "   - Identify clear strengths based on responses\n";
        $prompt .= "   - Explain how each strength benefits career development\n\n";
        
        $prompt .= "3. AREAS FOR DEVELOPMENT (2-3 areas)\n";
        $prompt .= "   - Constructive feedback on growth opportunities\n";
        $prompt .= "   - Frame positively as development potential\n\n";
        
        $prompt .= "4. CAREER RECOMMENDATIONS (3-5 specific career paths)\n";
        $prompt .= "   - Suggest careers that align with the assessment results\n";
        $prompt .= "   - Explain why each career is a good fit\n";
        $prompt .= "   - Consider the African job market context\n\n";
        
        $prompt .= "5. ACTION STEPS (5 concrete, actionable steps)\n";
        $prompt .= "   - Specific actions the candidate can take immediately\n";
        $prompt .= "   - Include skill development, networking, and learning resources\n";
        $prompt .= "   - Make each step clear and achievable\n\n";
        
        if ($type === 'personality') {
            $prompt .= "SPECIAL NOTE FOR PERSONALITY ASSESSMENT:\n";
            $prompt .= "- Identify the candidate's Myers-Briggs type tendencies (E/I, S/N, T/F, J/P)\n";
            $prompt .= "- Explain what this means for their work style and career fit\n";
            $prompt .= "- Suggest work environments that suit their personality\n\n";
        }
        
        $prompt .= "TONE: Professional, encouraging, specific, and culturally sensitive to the African context.\n";
        $prompt .= "FORMAT: Use clear headings and bullet points for easy reading.\n";

        $response = $this->sendMessage($prompt, []);
        return $response['content'] ?? 'Unable to generate analysis at this time. Please try again.';
    }

    /**
     * Generate a personalized career pathway
     */
    public function generateCareerPathway(string $targetRole, array $currentSkills, string $experienceLevel): array
    {
        $skillsList = implode(', ', $currentSkills);
        
        $prompt = "You are a career counselor creating a personalized career development plan.\n\n";
        $prompt .= "CLIENT PROFILE:\n";
        $prompt .= "- Target Role: {$targetRole}\n";
        $prompt .= "- Current Experience: {$experienceLevel}\n";
        $prompt .= "- Current Skills: {$skillsList}\n\n";
        
        $prompt .= "Create a SPECIFIC, ACTIONABLE career pathway with:\n\n";
        
        $prompt .= "1. MILESTONES (5-7 detailed steps):\n";
        $prompt .= "   - Each milestone should be SPECIFIC to {$targetRole}\n";
        $prompt .= "   - Include concrete actions, not generic advice\n";
        $prompt .= "   - List 3-5 SPECIFIC skills for each milestone\n";
        $prompt .= "   - Example: Instead of 'Learn fundamentals', say 'Master React hooks, state management, and component lifecycle'\n\n";
        
        $prompt .= "2. RESOURCES (3-5 specific recommendations):\n";
        $prompt .= "   - Provide REAL course names, book titles, or certification names\n";
        $prompt .= "   - Example: 'AWS Certified Solutions Architect' not 'Industry Certification'\n";
        $prompt .= "   - Example: 'The Pragmatic Programmer by Hunt & Thomas' not 'Career Development Book'\n";
        $prompt .= "   - Example: 'Complete {$targetRole} Bootcamp on Udemy' not 'Online Course'\n\n";
        
        $prompt .= "Return ONLY valid JSON with these exact keys:\n";
        $prompt .= "{\n";
        $prompt .= "  \"title\": \"Career Path to {$targetRole}\",\n";
        $prompt .= "  \"description\": \"2-3 sentence personalized overview based on their current skills and target role\",\n";
        $prompt .= "  \"duration_months\": 12-24,\n";
        $prompt .= "  \"milestones\": [\n";
        $prompt .= "    {\n";
        $prompt .= "      \"title\": \"Specific milestone name\",\n";
        $prompt .= "      \"description\": \"Detailed description with concrete actions\",\n";
        $prompt .= "      \"duration_weeks\": 8-16,\n";
        $prompt .= "      \"skills_gained\": [\"Specific skill 1\", \"Specific skill 2\", \"Specific skill 3\"]\n";
        $prompt .= "    }\n";
        $prompt .= "  ],\n";
        $prompt .= "  \"required_skills\": [\"List of specific technical and soft skills for {$targetRole}\"],\n";
        $prompt .= "  \"recommended_resources\": [\n";
        $prompt .= "    {\n";
        $prompt .= "      \"type\": \"course|book|certification\",\n";
        $prompt .= "      \"title\": \"REAL, specific resource name\",\n";
        $prompt .= "      \"description\": \"Why this resource is valuable for {$targetRole}\"\n";
        $prompt .= "    }\n";
        $prompt .= "  ]\n";
        $prompt .= "}\n\n";
        $prompt .= "IMPORTANT: Be specific and actionable. Avoid generic advice.";

        $config = $this->getGenerationConfig();
        $config['responseMimeType'] = 'application/json';
        $config['maxOutputTokens'] = 4000;

        return $this->sendStructuredPrompt($prompt, $config);
    }

    /**
     * Review resume with optional job description
     */
    public function reviewResume(string $resumeText, ?string $jobDescription = null, array $userProfile = []): string
    {
        $prompt = "You are an expert ATS (Applicant Tracking System) specialist and professional resume reviewer.\n\n";
        $prompt .= "RESUME CONTENT:\n";
        $prompt .= "===============\n";
        $prompt .= $resumeText . "\n\n";
        
        if (!empty($jobDescription)) {
            $prompt .= "TARGET JOB DESCRIPTION:\n";
            $prompt .= "======================\n";
            $prompt .= $jobDescription . "\n\n";
        }
        
        if (!empty($userProfile['name'])) {
            $prompt .= "CANDIDATE PROFILE:\n";
            $prompt .= "==================\n";
            if (!empty($userProfile['university'])) $prompt .= "University: {$userProfile['university']}\n";
            if (!empty($userProfile['field_of_study'])) $prompt .= "Field of Study: {$userProfile['field_of_study']}\n";
            if (!empty($userProfile['experience_level'])) $prompt .= "Experience Level: {$userProfile['experience_level']}\n";
            $prompt .= "\n";
        }
        
        $prompt .= "ANALYSIS REQUIREMENTS:\n";
        $prompt .= "=====================\n";
        $prompt .= "Provide a comprehensive resume review with these sections:\n\n";
        
        $prompt .= "**ATS COMPATIBILITY SCORE: [X]/100**\n";
        $prompt .= "Start with this exact format on the first line.\n\n";
        
        $prompt .= "1. OVERALL ASSESSMENT (2-3 sentences)\n";
        $prompt .= "   - General impression of the resume\n";
        $prompt .= "   - Key strengths at a glance\n\n";
        
        $prompt .= "2. ATS COMPATIBILITY ANALYSIS\n";
        $prompt .= "   - Formatting issues that might cause ATS problems\n";
        $prompt .= "   - Keyword optimization level\n";
        $prompt .= "   - Section structure and organization\n";
        $prompt .= "   - File format compatibility\n\n";
        
        $prompt .= "3. SECTION-BY-SECTION REVIEW\n";
        $prompt .= "   For each section (Summary, Experience, Skills, Education):\n";
        $prompt .= "   - What's working well\n";
        $prompt .= "   - What needs improvement\n";
        $prompt .= "   - Specific suggestions\n\n";
        
        $prompt .= "4. KEYWORD ANALYSIS\n";
        $prompt .= "   - Strong keywords found (list 5-7)\n";
        $prompt .= "   - Missing important keywords (list 5-7)\n";
        $prompt .= "   - Industry-specific terms to add\n\n";
        
        if (!empty($jobDescription)) {
            $prompt .= "5. JOB MATCH ANALYSIS\n";
            $prompt .= "   - How well the resume aligns with the job description\n";
            $prompt .= "   - Matching qualifications\n";
            $prompt .= "   - Gaps to address\n";
            $prompt .= "   - Tailoring suggestions\n\n";
        }
        
        $prompt .= "6. ACTION ITEMS (Priority-based)\n";
        $prompt .= "   HIGH PRIORITY (Fix immediately):\n";
        $prompt .= "   - List 3-4 critical improvements\n";
        $prompt .= "   \n";
        $prompt .= "   MEDIUM PRIORITY (Improve soon):\n";
        $prompt .= "   - List 3-4 important enhancements\n";
        $prompt .= "   \n";
        $prompt .= "   LOW PRIORITY (Nice to have):\n";
        $prompt .= "   - List 2-3 optional improvements\n\n";
        
        $prompt .= "7. SPECIFIC RECOMMENDATIONS\n";
        $prompt .= "   - Provide 5-7 concrete, actionable suggestions\n";
        $prompt .= "   - Include before/after examples where helpful\n";
        $prompt .= "   - Focus on African job market context\n\n";
        
        $prompt .= "IMPORTANT: Start your response with the ATS score in this exact format:\n";
        $prompt .= "**ATS COMPATIBILITY SCORE: [number]/100**\n\n";
        $prompt .= "TONE: Professional, constructive, and encouraging.\n";
        $prompt .= "FORMAT: Use clear headings, bullet points, and bold text for emphasis.\n";

        // Increase token limit for comprehensive analysis
        $originalMaxTokens = $this->maxTokens;
        $this->maxTokens = 8192; // Increase to allow full detailed analysis
        
        $response = $this->sendMessage($prompt, [], []);
        
        // Restore original token limit
        $this->maxTokens = $originalMaxTokens;
        
        $content = $response['content'] ?? '';
        
        // Check if the response is an error or empty
        if (empty($content) || isset($response['metadata']['error'])) {
            Log::error('Resume review: Gemini API returned empty or error response');
            return 'Unable to analyze resume at this time. Please try again.';
        }
        
        return $content;
    }

    /**
     * Generate AI-powered career plan from workbook data
     */
    public function generateCareerPlan(array $userProfile, array $workbookData): string
    {
        $prompt = "You are an expert career counselor creating a personalized career development plan for an African job seeker.\n\n";
        
        $prompt .= "CANDIDATE PROFILE:\n";
        $prompt .= "==================\n";
        if (!empty($userProfile['name'])) $prompt .= "Name: {$userProfile['name']}\n";
        if (!empty($userProfile['university'])) $prompt .= "University: {$userProfile['university']}\n";
        if (!empty($userProfile['field_of_study'])) $prompt .= "Field of Study: {$userProfile['field_of_study']}\n";
        if (!empty($userProfile['graduation_year'])) $prompt .= "Graduation Year: {$userProfile['graduation_year']}\n";
        if (!empty($userProfile['skills'])) $prompt .= "Current Skills: {$userProfile['skills']}\n";
        if (!empty($userProfile['experience_level'])) $prompt .= "Experience Level: {$userProfile['experience_level']}\n";
        if (!empty($userProfile['location'])) $prompt .= "Location: {$userProfile['location']}\n";
        $prompt .= "\n";
        
        $prompt .= "CAREER PLANNING WORKBOOK RESPONSES:\n";
        $prompt .= "===================================\n";
        $prompt .= "Professional Strengths: {$workbookData['strengths']}\n";
        $prompt .= "Core Values: {$workbookData['values']}\n";
        $prompt .= "Interests: {$workbookData['interests']}\n";
        $prompt .= "Short-term Goal (6-12 months): {$workbookData['short_term_goal']}\n";
        $prompt .= "Long-term Goal (3-5 years): {$workbookData['long_term_goal']}\n";
        
        if (!empty($workbookData['skills_gap'])) {
            $prompt .= "Skills to Acquire: {$workbookData['skills_gap']}\n";
        }
        if (!empty($workbookData['experience_gap'])) {
            $prompt .= "Experiences Needed: {$workbookData['experience_gap']}\n";
        }
        if (!empty($workbookData['actions'])) {
            $prompt .= "Planned Actions: " . implode(', ', $workbookData['actions']) . "\n";
        }
        $prompt .= "\n";
        
        $prompt .= "ANALYSIS REQUIREMENTS:\n";
        $prompt .= "=====================\n";
        $prompt .= "Create a comprehensive, actionable career development plan with these sections:\n\n";
        
        $prompt .= "1. CAREER VISION ANALYSIS (2-3 paragraphs)\n";
        $prompt .= "   - Assess the alignment between their strengths, values, interests, and goals\n";
        $prompt .= "   - Evaluate the feasibility and realism of their career goals\n";
        $prompt .= "   - Provide encouraging feedback on their self-awareness\n\n";
        
        $prompt .= "2. PATHWAY TO SHORT-TERM GOAL (6-12 months)\n";
        $prompt .= "   - Break down the short-term goal into 3-4 key milestones\n";
        $prompt .= "   - For each milestone, provide:\n";
        $prompt .= "     * Specific actions to take\n";
        $prompt .= "     * Timeline (e.g., Month 1-2, Month 3-4)\n";
        $prompt .= "     * Success metrics\n\n";
        
        $prompt .= "3. PATHWAY TO LONG-TERM GOAL (3-5 years)\n";
        $prompt .= "   - Outline 5-7 major milestones from current position to target role\n";
        $prompt .= "   - For each milestone:\n";
        $prompt .= "     * Title and description\n";
        $prompt .= "     * Estimated timeframe\n";
        $prompt .= "     * Key skills to develop\n";
        $prompt .= "     * Potential challenges and how to overcome them\n\n";
        
        $prompt .= "4. SKILLS DEVELOPMENT PLAN\n";
        $prompt .= "   - List 8-10 critical skills needed for their career goals\n";
        $prompt .= "   - Prioritize them (High/Medium priority)\n";
        $prompt .= "   - Suggest specific learning resources for each:\n";
        $prompt .= "     * Online courses (Coursera, Udemy, edX)\n";
        $prompt .= "     * Certifications relevant to African job market\n";
        $prompt .= "     * Books and articles\n";
        $prompt .= "     * Practical projects\n\n";
        
        $prompt .= "5. NETWORKING & EXPERIENCE STRATEGY\n";
        $prompt .= "   - Recommend 5-6 specific networking activities\n";
        $prompt .= "   - Suggest ways to gain relevant experience:\n";
        $prompt .= "     * Volunteer opportunities\n";
        $prompt .= "     * Side projects\n";
        $prompt .= "     * Internships or part-time roles\n";
        $prompt .= "     * Professional associations in Africa\n\n";
        
        $prompt .= "6. 90-DAY ACTION PLAN\n";
        $prompt .= "   - Create a detailed 90-day plan with specific, measurable actions\n";
        $prompt .= "   - Organize by weeks:\n";
        $prompt .= "     * Weeks 1-4: [specific actions]\n";
        $prompt .= "     * Weeks 5-8: [specific actions]\n";
        $prompt .= "     * Weeks 9-12: [specific actions]\n";
        $prompt .= "   - Include both skill-building and networking activities\n";
        $prompt .= "   - Make each action concrete and achievable\n\n";
        
        $prompt .= "7. SUCCESS METRICS & TRACKING\n";
        $prompt .= "   - Define 5-7 key performance indicators (KPIs) to track progress\n";
        $prompt .= "   - Suggest monthly review questions\n";
        $prompt .= "   - Recommend tools or methods for tracking progress\n\n";
        
        $prompt .= "8. POTENTIAL CHALLENGES & SOLUTIONS\n";
        $prompt .= "   - Identify 4-5 common challenges they might face\n";
        $prompt .= "   - Provide practical solutions for each\n";
        $prompt .= "   - Include African job market specific challenges\n\n";
        
        $prompt .= "CONTEXT: Consider the African job market, available resources, and cultural context.\n";
        $prompt .= "TONE: Professional, encouraging, specific, and actionable.\n";
        $prompt .= "FORMAT: Use clear headings, bullet points, and numbered lists for easy reading.\n";
        $prompt .= "LENGTH: Comprehensive but concise - aim for 1500-2000 words.\n";

        $response = $this->sendMessage($prompt, []);
        return $response['content'] ?? 'Unable to generate career plan at this time. Please try again.';
    }
}
