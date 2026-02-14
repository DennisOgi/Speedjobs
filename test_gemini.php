<?php

use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$gemini = new GeminiService();

$userProfile = [
    'user_name' => 'Test User',
    'skills' => ['PHP', 'Laravel', 'JavaScript'],
    'experience_level' => 'Entry Level',
    'field_of_study' => 'Computer Science',
    'target_role' => 'Software Engineer',
];

$answers = [
    ['question' => 'What type of work environment do you prefer?', 'answer' => 'Fast-paced startup'],
    ['question' => 'Which of these activities energizes you most?', 'answer' => 'Solving complex problems'],
    ['question' => 'How do you prefer to work?', 'answer' => 'Collaboratively in a team'],
    ['question' => 'Describe a project or achievement you\'re most proud of.', 'answer' => 'Built a full-stack web app'],
    ['question' => 'What matters most to you in a career?', 'answer' => 'Continuous learning'],
    ['question' => 'If you could do any job for one year with guaranteed success, what would it be?', 'answer' => 'Chief Technology Officer'],
];

echo "Testing Gemini Career Assessment...\n";

try {
    $report = $gemini->generateCareerAssessment($userProfile, $answers);
    
    if (empty($report)) {
        echo "FAILED: Report is empty.\n";
    } else {
        echo "SUCCESS: Report generated.\n";
        print_r($report);
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
