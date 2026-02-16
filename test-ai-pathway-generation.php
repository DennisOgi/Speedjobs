<?php

/**
 * Test AI Career Pathway Generation
 * 
 * This directly tests the Gemini API to see if it's working
 * and what response we're getting
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GeminiService;

echo "=== AI CAREER PATHWAY GENERATION TEST ===\n\n";

// Test 1: Check API key
echo "1. Checking Gemini API Configuration\n";
$apiKey = config('services.gemini.api_key');
if (empty($apiKey)) {
    echo "   ✗ GEMINI_API_KEY is not set!\n";
    echo "   Add it to your .env file\n";
    exit(1);
} else {
    echo "   ✓ API key is configured (length: " . strlen($apiKey) . ")\n";
}

$model = config('services.gemini.model', 'gemini-2.0-flash-exp');
echo "   ℹ Using model: {$model}\n";

// Test 2: Initialize service
echo "\n2. Initializing GeminiService\n";
try {
    $gemini = new GeminiService();
    echo "   ✓ Service initialized\n";
} catch (\Exception $e) {
    echo "   ✗ Failed to initialize: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 3: Test career pathway generation
echo "\n3. Testing Career Pathway Generation\n";
echo "   Target Role: Senior Software Engineer\n";
echo "   Current Skills: PHP, Laravel, JavaScript\n";
echo "   Experience: Junior Developer\n\n";

try {
    $targetRole = "Senior Software Engineer";
    $currentSkills = ['PHP', 'Laravel', 'JavaScript', 'React'];
    $experienceLevel = "Junior Developer";
    
    echo "   Calling Gemini API...\n";
    $startTime = microtime(true);
    
    $result = $gemini->generateCareerPathway($targetRole, $currentSkills, $experienceLevel);
    
    $duration = round((microtime(true) - $startTime) * 1000);
    echo "   Response received in {$duration}ms\n\n";
    
    // Check if result is empty
    if (empty($result)) {
        echo "   ✗ AI returned EMPTY response\n";
        echo "   This means the API call failed or returned invalid JSON\n\n";
        
        echo "   Checking Laravel logs for errors...\n";
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $lines = explode("\n", $logContent);
            $recentErrors = array_slice(array_reverse($lines), 0, 20);
            
            $foundError = false;
            foreach ($recentErrors as $line) {
                if (stripos($line, 'gemini') !== false || stripos($line, 'career pathway') !== false) {
                    echo "   " . trim($line) . "\n";
                    $foundError = true;
                }
            }
            
            if (!$foundError) {
                echo "   No recent Gemini errors in logs\n";
            }
        }
        
        exit(1);
    }
    
    // Validate structure
    echo "   ✓ AI returned data\n\n";
    
    echo "4. Validating Response Structure\n";
    
    $hasTitle = isset($result['title']);
    $hasDescription = isset($result['description']);
    $hasDuration = isset($result['duration_months']);
    $hasMilestones = isset($result['milestones']) && is_array($result['milestones']);
    $hasSkills = isset($result['required_skills']) && is_array($result['required_skills']);
    $hasResources = isset($result['recommended_resources']) && is_array($result['recommended_resources']);
    
    echo "   " . ($hasTitle ? "✓" : "✗") . " Has title\n";
    echo "   " . ($hasDescription ? "✓" : "✗") . " Has description\n";
    echo "   " . ($hasDuration ? "✓" : "✗") . " Has duration_months\n";
    echo "   " . ($hasMilestones ? "✓" : "✗") . " Has milestones array\n";
    echo "   " . ($hasSkills ? "✓" : "✗") . " Has required_skills array\n";
    echo "   " . ($hasResources ? "✓" : "✗") . " Has recommended_resources array\n";
    
    if (!$hasTitle || !$hasMilestones || !$hasSkills || !$hasResources) {
        echo "\n   ✗ Response is missing required fields\n";
        echo "   Raw response:\n";
        echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
        exit(1);
    }
    
    // Check milestone quality
    echo "\n5. Checking Content Quality\n";
    
    if ($hasMilestones && count($result['milestones']) > 0) {
        echo "   Milestones: " . count($result['milestones']) . "\n";
        
        $firstMilestone = $result['milestones'][0];
        echo "   First milestone:\n";
        echo "     Title: " . ($firstMilestone['title'] ?? 'MISSING') . "\n";
        echo "     Description: " . substr($firstMilestone['description'] ?? 'MISSING', 0, 80) . "...\n";
        echo "     Duration: " . ($firstMilestone['duration_weeks'] ?? 'MISSING') . " weeks\n";
        echo "     Skills: " . implode(', ', $firstMilestone['skills_gained'] ?? []) . "\n";
        
        // Check if it's generic
        $isGeneric = (
            stripos($firstMilestone['title'] ?? '', 'foundation') !== false ||
            stripos($firstMilestone['title'] ?? '', 'building') !== false
        ) && (
            stripos($firstMilestone['description'] ?? '', 'fundamental') !== false ||
            stripos($firstMilestone['description'] ?? '', 'master the') !== false
        );
        
        if ($isGeneric) {
            echo "\n   ⚠ WARNING: Milestone appears generic\n";
            echo "   The AI might not be following the improved prompt\n";
        } else {
            echo "\n   ✓ Milestone appears specific and actionable\n";
        }
    }
    
    if ($hasResources && count($result['recommended_resources']) > 0) {
        echo "\n   Resources: " . count($result['recommended_resources']) . "\n";
        
        $firstResource = $result['recommended_resources'][0];
        echo "   First resource:\n";
        echo "     Type: " . ($firstResource['type'] ?? 'MISSING') . "\n";
        echo "     Title: " . ($firstResource['title'] ?? 'MISSING') . "\n";
        echo "     Description: " . substr($firstResource['description'] ?? 'MISSING', 0, 80) . "...\n";
        
        // Check if it's generic
        $isGeneric = (
            stripos($firstResource['title'] ?? '', 'professional development') !== false ||
            stripos($firstResource['title'] ?? '', 'industry-recognized') !== false ||
            stripos($firstResource['title'] ?? '', 'career development') !== false
        );
        
        if ($isGeneric) {
            echo "\n   ⚠ WARNING: Resource appears generic\n";
            echo "   The AI should provide specific course/book/certification names\n";
        } else {
            echo "\n   ✓ Resource appears specific\n";
        }
    }
    
    echo "\n=== TEST COMPLETE ===\n";
    echo "\nFull Response:\n";
    echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
    
} catch (\Exception $e) {
    echo "   ✗ Exception: " . $e->getMessage() . "\n";
    echo "   Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
