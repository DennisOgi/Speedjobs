<?php
/**
 * Test Career Intelligence Report Generation
 * 
 * This script tests the Career Intelligence Report feature
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Services\GeminiService;
use App\Models\AiReport;

echo "=== CAREER INTELLIGENCE REPORT TEST ===\n\n";

// Test 1: Check if user exists and is paid
echo "1. Checking test user...\n";
$user = User::where('email', 'test@speedjobs.com')->first();

if (!$user) {
    echo "   ✗ Test user not found. Please create user first.\n";
    exit(1);
}

echo "   ✓ User found: {$user->name}\n";
echo "   - Email: {$user->email}\n";
echo "   - Is Paid: " . ($user->is_paid ? 'Yes' : 'No') . "\n";
echo "   - Is Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n\n";

if (!$user->is_paid) {
    echo "   ⚠ User is not paid. Setting is_paid = true...\n";
    $user->is_paid = true;
    $user->save();
    echo "   ✓ User is now paid\n\n";
}

// Test 2: Check Gemini API configuration
echo "2. Checking Gemini API configuration...\n";
$apiKey = config('services.gemini.api_key');

if (empty($apiKey)) {
    echo "   ✗ Gemini API key is not set in .env file\n";
    echo "   Please add: GEMINI_API_KEY=your_api_key_here\n";
    exit(1);
}

echo "   ✓ API Key is configured\n";
echo "   - Model: " . config('services.gemini.model', 'gemini-2.5-flash') . "\n\n";

// Test 3: Check existing reports
echo "3. Checking existing reports...\n";
$existingReport = AiReport::where('user_id', $user->id)
    ->where('type', 'profile_report')
    ->latest()
    ->first();

if ($existingReport) {
    echo "   ✓ Found existing report\n";
    echo "   - Created: {$existingReport->created_at->diffForHumans()}\n";
    echo "   - Expires: {$existingReport->expires_at->diffForHumans()}\n";
    echo "   - Is Valid: " . ($existingReport->expires_at->isFuture() ? 'Yes' : 'No (expired)') . "\n\n";
    
    // Show content preview
    $content = is_string($existingReport->content) ? json_decode($existingReport->content, true) : $existingReport->content;
    if ($content && is_array($content)) {
        echo "   Report Structure:\n";
        echo "   - Has summary: " . (isset($content['summary']) ? 'Yes' : 'No') . "\n";
        echo "   - Strengths count: " . (isset($content['strengths']) ? count($content['strengths']) : 0) . "\n";
        echo "   - Improvement areas count: " . (isset($content['improvement_areas']) ? count($content['improvement_areas']) : 0) . "\n";
        echo "   - Recommended roles count: " . (isset($content['recommended_roles']) ? count($content['recommended_roles']) : 0) . "\n";
        echo "   - Action plan steps: " . (isset($content['action_plan']) ? count($content['action_plan']) : 0) . "\n\n";
    }
} else {
    echo "   - No existing report found\n\n";
}

// Test 4: Generate new report
echo "4. Testing report generation...\n";
echo "   This may take 10-30 seconds...\n";

try {
    $gemini = new GeminiService();
    
    $userContext = [
        'name' => $user->name,
        'role' => $user->role,
        'skills' => $user->skills,
        'experience' => $user->experience_level,
        'field' => $user->field_of_study,
        'university' => $user->university,
        'location' => $user->location,
    ];
    
    echo "   User Context:\n";
    echo "   " . json_encode($userContext, JSON_PRETTY_PRINT) . "\n\n";
    
    $reportData = $gemini->generateProfileReport($userContext);
    
    if (empty($reportData)) {
        echo "   ✗ Report generation returned empty data\n";
        echo "   This could be due to:\n";
        echo "   - API quota exceeded (20 requests/day on free tier)\n";
        echo "   - API key invalid\n";
        echo "   - Network issues\n";
        exit(1);
    }
    
    echo "   ✓ Report generated successfully!\n\n";
    
    // Validate structure
    echo "5. Validating report structure...\n";
    $requiredFields = ['summary', 'strengths', 'improvement_areas', 'recommended_roles', 'action_plan'];
    $allValid = true;
    
    foreach ($requiredFields as $field) {
        $exists = isset($reportData[$field]);
        echo "   " . ($exists ? '✓' : '✗') . " {$field}: " . ($exists ? 'Present' : 'Missing') . "\n";
        if (!$exists) $allValid = false;
    }
    
    if (!$allValid) {
        echo "\n   ⚠ Report is missing required fields\n";
        echo "   Raw data:\n";
        echo "   " . json_encode($reportData, JSON_PRETTY_PRINT) . "\n";
        exit(1);
    }
    
    echo "\n   ✓ All required fields present\n\n";
    
    // Show sample data
    echo "6. Report Preview:\n";
    echo "   Summary: " . substr($reportData['summary'], 0, 100) . "...\n";
    echo "   Strengths: " . count($reportData['strengths']) . " items\n";
    if (!empty($reportData['strengths'])) {
        echo "      - " . $reportData['strengths'][0] . "\n";
    }
    echo "   Improvement Areas: " . count($reportData['improvement_areas']) . " items\n";
    echo "   Recommended Roles: " . count($reportData['recommended_roles']) . " items\n";
    if (!empty($reportData['recommended_roles'])) {
        echo "      - " . $reportData['recommended_roles'][0] . "\n";
    }
    echo "   Action Plan: " . count($reportData['action_plan']) . " steps\n\n";
    
    // Test 7: Save to database
    echo "7. Saving report to database...\n";
    
    // Delete old reports
    AiReport::where('user_id', $user->id)
        ->where('type', 'profile_report')
        ->delete();
    
    $report = AiReport::create([
        'user_id' => $user->id,
        'type' => 'profile_report',
        'content' => json_encode($reportData),
        'expires_at' => now()->addDays(7),
    ]);
    
    echo "   ✓ Report saved with ID: {$report->id}\n";
    echo "   - Expires: {$report->expires_at->format('Y-m-d H:i:s')}\n\n";
    
    // Test 8: Retrieve and parse
    echo "8. Testing retrieval and parsing...\n";
    $retrieved = AiReport::find($report->id);
    $parsedContent = is_string($retrieved->content) ? json_decode($retrieved->content, true) : $retrieved->content;
    
    if ($parsedContent && isset($parsedContent['summary'])) {
        echo "   ✓ Report retrieved and parsed successfully\n";
        echo "   - Content type: " . (is_string($retrieved->content) ? 'JSON string' : 'Array') . "\n";
        echo "   - Parsed type: " . gettype($parsedContent) . "\n\n";
    } else {
        echo "   ✗ Failed to parse retrieved report\n";
        exit(1);
    }
    
    echo "=== ALL TESTS PASSED ===\n\n";
    echo "✓ Career Intelligence Report is working correctly!\n";
    echo "✓ You can now test it in the browser at: http://127.0.0.1:8000/dashboard\n\n";
    
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    echo "   Stack trace:\n";
    echo "   " . $e->getTraceAsString() . "\n";
    exit(1);
}
