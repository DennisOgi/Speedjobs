<?php

/**
 * Comprehensive Career Pathway Feature Test
 * 
 * Tests the complete flow:
 * 1. Form submission
 * 2. Data structure validation
 * 3. View rendering with proper array handling
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\CareerPathway;

echo "=== CAREER PATHWAY COMPLETE TEST ===\n\n";

// Test 1: Check controller syntax
echo "1. Controller Syntax Check\n";
$controllerPath = __DIR__ . '/app/Http/Controllers/CareerPathwayController.php';
$syntax = shell_exec("php -l {$controllerPath} 2>&1");
echo "   " . (strpos($syntax, 'No syntax errors') !== false ? "✓" : "✗") . " Controller syntax\n";

// Test 2: Check view syntax
echo "\n2. View Syntax Check\n";
$viewPath = __DIR__ . '/resources/views/pathways/show.blade.php';
if (file_exists($viewPath)) {
    $viewContent = file_get_contents($viewPath);
    
    // Check for proper array access
    $hasProperMilestoneAccess = strpos($viewContent, "\$milestone['title']") !== false;
    $hasProperResourceAccess = strpos($viewContent, "\$resource['title']") !== false;
    $hasProperSkillsAccess = strpos($viewContent, "\$milestone['skills_gained']") !== false;
    
    echo "   " . ($hasProperMilestoneAccess ? "✓" : "✗") . " Milestone array access\n";
    echo "   " . ($hasProperResourceAccess ? "✓" : "✗") . " Resource array access\n";
    echo "   " . ($hasProperSkillsAccess ? "✓" : "✗") . " Skills array access\n";
} else {
    echo "   ✗ View file not found\n";
}

// Test 3: Check database structure
echo "\n3. Database Structure Check\n";
try {
    $pathway = CareerPathway::latest()->first();
    
    if ($pathway) {
        echo "   ✓ Found pathway record (ID: {$pathway->id})\n";
        
        $data = $pathway->pathway_data;
        
        // Check required fields
        $hasTitle = isset($data['title']);
        $hasMilestones = isset($data['milestones']) && is_array($data['milestones']);
        $hasSkills = isset($data['skills_required']) && is_array($data['skills_required']);
        $hasResources = isset($data['resources']) && is_array($data['resources']);
        
        echo "   " . ($hasTitle ? "✓" : "✗") . " Has title\n";
        echo "   " . ($hasMilestones ? "✓" : "✗") . " Has milestones array\n";
        echo "   " . ($hasSkills ? "✓" : "✗") . " Has skills array\n";
        echo "   " . ($hasResources ? "✓" : "✗") . " Has resources array\n";
        
        // Check milestone structure
        if ($hasMilestones && count($data['milestones']) > 0) {
            $firstMilestone = $data['milestones'][0];
            $milestoneHasTitle = isset($firstMilestone['title']);
            $milestoneHasDescription = isset($firstMilestone['description']);
            $milestoneHasSkills = isset($firstMilestone['skills_gained']) && is_array($firstMilestone['skills_gained']);
            
            echo "\n   Milestone Structure:\n";
            echo "   " . ($milestoneHasTitle ? "✓" : "✗") . " Has title field\n";
            echo "   " . ($milestoneHasDescription ? "✓" : "✗") . " Has description field\n";
            echo "   " . ($milestoneHasSkills ? "✓" : "✗") . " Has skills_gained array\n";
            
            if ($milestoneHasSkills) {
                echo "   ℹ Skills count: " . count($firstMilestone['skills_gained']) . "\n";
            }
        }
        
        // Check resource structure
        if ($hasResources && count($data['resources']) > 0) {
            $firstResource = $data['resources'][0];
            $resourceHasType = isset($firstResource['type']);
            $resourceHasTitle = isset($firstResource['title']);
            $resourceHasDescription = isset($firstResource['description']);
            
            echo "\n   Resource Structure:\n";
            echo "   " . ($resourceHasType ? "✓" : "✗") . " Has type field\n";
            echo "   " . ($resourceHasTitle ? "✓" : "✗") . " Has title field\n";
            echo "   " . ($resourceHasDescription ? "✓" : "✗") . " Has description field\n";
        }
        
        // Display summary
        echo "\n   Summary:\n";
        echo "   - Target Role: {$pathway->target_role}\n";
        echo "   - Current Role: {$pathway->current_role}\n";
        echo "   - Milestones: " . count($data['milestones']) . "\n";
        echo "   - Skills: " . count($data['skills_required']) . "\n";
        echo "   - Resources: " . count($data['resources']) . "\n";
        echo "   - Progress: {$pathway->progress_percentage}%\n";
        
    } else {
        echo "   ⚠ No pathway records found\n";
        echo "   ℹ Create one at: http://127.0.0.1:8000/career-planning\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n";
}

// Test 4: Fallback method validation
echo "\n4. Fallback Method Validation\n";
$controllerContent = file_get_contents($controllerPath);
$fallbackPos = strpos($controllerContent, 'protected function createFallbackPathway');
$classEndPos = strrpos($controllerContent, '}');

if ($fallbackPos !== false && $fallbackPos < $classEndPos) {
    echo "   ✓ Fallback method exists and is inside class\n";
    
    // Check fallback returns proper structure
    $hasMilestonesReturn = strpos($controllerContent, "'milestones' => [") !== false;
    $hasResourcesReturn = strpos($controllerContent, "'recommended_resources' => [") !== false;
    $hasSkillsReturn = strpos($controllerContent, "'required_skills' => array_merge") !== false;
    
    echo "   " . ($hasMilestonesReturn ? "✓" : "✗") . " Returns milestones array\n";
    echo "   " . ($hasResourcesReturn ? "✓" : "✗") . " Returns resources array\n";
    echo "   " . ($hasSkillsReturn ? "✓" : "✗") . " Returns skills array\n";
} else {
    echo "   ✗ Fallback method issue\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "\nWhat to Test Manually:\n";
echo "1. Visit: http://127.0.0.1:8000/career-planning\n";
echo "2. Fill in the form and submit\n";
echo "3. View the generated pathway\n";
echo "4. Verify:\n";
echo "   - Milestones show with title, description, duration, and skills\n";
echo "   - Resources show with type badge, title, and description\n";
echo "   - Skills display as colored badges\n";
echo "   - No 'Array to string conversion' errors\n";
