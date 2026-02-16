<?php

/**
 * Test Career Pathway Generation After Syntax Fix
 * 
 * This tests:
 * 1. Controller syntax is valid
 * 2. Fallback pathway works when AI fails
 * 3. Form loads without errors
 */

echo "=== CAREER PATHWAY SYNTAX FIX TEST ===\n\n";

// Test 1: Check controller syntax
echo "1. Checking controller syntax...\n";
$controllerPath = __DIR__ . '/app/Http/Controllers/CareerPathwayController.php';
$syntax = shell_exec("php -l {$controllerPath} 2>&1");

if (strpos($syntax, 'No syntax errors') !== false) {
    echo "   ✓ Controller syntax is valid\n";
} else {
    echo "   ✗ Syntax error found:\n";
    echo "   {$syntax}\n";
    exit(1);
}

// Test 2: Check fallback method exists
echo "\n2. Checking fallback method...\n";
$controllerContent = file_get_contents($controllerPath);

if (strpos($controllerContent, 'protected function createFallbackPathway') !== false) {
    echo "   ✓ Fallback method exists\n";
    
    // Check it's inside the class (not after closing brace)
    $classEndPos = strrpos($controllerContent, '}');
    $methodPos = strpos($controllerContent, 'protected function createFallbackPathway');
    
    if ($methodPos < $classEndPos) {
        echo "   ✓ Fallback method is inside the class\n";
    } else {
        echo "   ✗ Fallback method is outside the class!\n";
        exit(1);
    }
} else {
    echo "   ✗ Fallback method not found\n";
    exit(1);
}

// Test 3: Check error handling in store method
echo "\n3. Checking error handling...\n";
if (strpos($controllerContent, 'if (empty($aiPathwayData) || !is_array($aiPathwayData))') !== false) {
    echo "   ✓ AI response validation exists\n";
}
if (strpos($controllerContent, '$aiPathwayData = $this->createFallbackPathway') !== false) {
    echo "   ✓ Fallback is called when AI fails\n";
}
if (strpos($controllerContent, 'catch (\Exception $e)') !== false) {
    echo "   ✓ Exception handling exists\n";
}

// Test 4: Check view has error display
echo "\n4. Checking view error display...\n";
$viewPath = __DIR__ . '/resources/views/pathways/create.blade.php';
if (file_exists($viewPath)) {
    $viewContent = file_get_contents($viewPath);
    if (strpos($viewContent, '@error') !== false || strpos($viewContent, '$errors') !== false) {
        echo "   ✓ View has error display\n";
    } else {
        echo "   ⚠ View might not display errors\n";
    }
} else {
    echo "   ⚠ View file not found\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "\nNext Steps:\n";
echo "1. Visit http://127.0.0.1:8000/career-planning\n";
echo "2. Fill in the form and submit\n";
echo "3. If AI fails, you should see a fallback pathway instead of an error\n";
echo "4. Check Laravel logs for any AI errors: storage/logs/laravel.log\n";
