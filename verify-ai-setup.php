<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🤖 AI Career Counselor - Setup Verification\n";
echo str_repeat("=", 60) . "\n\n";

// Check tables exist
echo "📊 Checking Database Tables...\n";
$tables = [
    'ai_conversations',
    'ai_messages',
    'assessment_results',
    'career_pathways',
    'ai_feedback',
];

foreach ($tables as $table) {
    try {
        $exists = DB::select("SHOW TABLES LIKE '$table'");
        if (count($exists) > 0) {
            echo "  ✅ Table exists: $table\n";
        } else {
            echo "  ❌ Table missing: $table\n";
        }
    } catch (Exception $e) {
        echo "  ❌ Error checking $table: " . $e->getMessage() . "\n";
    }
}

// Check models
echo "\n📦 Checking Models...\n";
$models = [
    'App\Models\AiConversation',
    'App\Models\AiMessage',
    'App\Models\AssessmentResult',
    'App\Models\CareerPathway',
    'App\Models\AiFeedback',
];

foreach ($models as $model) {
    if (class_exists($model)) {
        echo "  ✅ Model exists: " . class_basename($model) . "\n";
    } else {
        echo "  ❌ Model missing: " . class_basename($model) . "\n";
    }
}

// Check service
echo "\n⚙️  Checking Services...\n";
if (class_exists('App\Services\GeminiService')) {
    echo "  ✅ GeminiService exists\n";
    
    $service = app('App\Services\GeminiService');
    $methods = [
        'sendMessage',
        'analyzeAssessment',
        'generateCareerPathway',
        'reviewResume',
        'generateInterviewQuestions',
    ];
    
    foreach ($methods as $method) {
        if (method_exists($service, $method)) {
            echo "    ✅ Method: $method()\n";
        } else {
            echo "    ❌ Missing: $method()\n";
        }
    }
} else {
    echo "  ❌ GeminiService missing\n";
}

// Check controller
echo "\n🎮 Checking Controller...\n";
if (class_exists('App\Http\Controllers\AiCounselorController')) {
    echo "  ✅ AiCounselorController exists\n";
} else {
    echo "  ❌ AiCounselorController missing\n";
}

// Check routes
echo "\n🛣️  Checking Routes...\n";
$routes = Route::getRoutes();
$aiRoutes = 0;
foreach ($routes as $route) {
    if (str_contains($route->getName() ?? '', 'ai-counselor')) {
        $aiRoutes++;
    }
}
echo "  ✅ Found $aiRoutes AI counselor routes\n";

// Check config
echo "\n⚙️  Checking Configuration...\n";
$geminiConfig = config('services.gemini');
if ($geminiConfig) {
    echo "  ✅ Gemini config exists\n";
    echo "    Model: " . ($geminiConfig['model'] ?? 'not set') . "\n";
    echo "    API Key: " . (empty($geminiConfig['api_key']) ? '❌ NOT SET' : '✅ Set') . "\n";
} else {
    echo "  ❌ Gemini config missing\n";
}

// Summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 SUMMARY\n";
echo str_repeat("=", 60) . "\n\n";

if (empty(config('services.gemini.api_key'))) {
    echo "⚠️  NEXT STEP: Add your Gemini API key to .env\n\n";
    echo "1. Get API key: https://aistudio.google.com/app/apikey\n";
    echo "2. Add to .env: GEMINI_API_KEY=your_key_here\n";
    echo "3. Set user as premium: UPDATE users SET is_paid = 1 WHERE email = 'your@email.com'\n";
    echo "4. Visit: http://localhost:8000/ai-counselor\n";
} else {
    echo "✅ Setup complete! Ready to use.\n\n";
    echo "Visit: http://localhost:8000/ai-counselor\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
