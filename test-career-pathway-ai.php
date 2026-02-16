<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\GeminiService;

echo "=== Testing Career Pathway AI Generation ===\n\n";

$gemini = new GeminiService();

// Test data
$targetRole = "Senior Software Engineer";
$currentSkills = ["PHP", "Laravel", "JavaScript"];
$experienceLevel = "Junior Developer";

echo "Target Role: $targetRole\n";
echo "Current Skills: " . implode(', ', $currentSkills) . "\n";
echo "Experience Level: $experienceLevel\n\n";

echo "Calling AI...\n";

try {
    $result = $gemini->generateCareerPathway($targetRole, $currentSkills, $experienceLevel);
    
    echo "\n=== AI Response ===\n";
    echo json_encode($result, JSON_PRETTY_PRINT) . "\n\n";
    
    if (empty($result)) {
        echo "❌ ERROR: AI returned empty result\n";
        echo "Check Laravel logs for details: storage/logs/laravel.log\n";
    } else {
        echo "✅ SUCCESS: AI generated pathway data\n\n";
        
        // Check required fields
        $requiredFields = ['title', 'description', 'duration_months', 'milestones', 'required_skills', 'recommended_resources'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($result[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            echo "⚠️  WARNING: Missing fields: " . implode(', ', $missingFields) . "\n";
        } else {
            echo "✅ All required fields present\n";
            echo "   - Milestones: " . count($result['milestones']) . "\n";
            echo "   - Skills: " . count($result['required_skills']) . "\n";
            echo "   - Resources: " . count($result['recommended_resources']) . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "\n❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
