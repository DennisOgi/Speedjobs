<?php

require __DIR__.'/vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== Checking .env File ===\n\n";

echo "GEMINI_API_KEY from .env:\n";
$apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY') ?? null;

if ($apiKey) {
    echo "✅ Found: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "\n";
    echo "Length: " . strlen($apiKey) . " characters\n\n";
} else {
    echo "❌ Not found in .env\n\n";
}

// Now test with Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "GEMINI_API_KEY from Laravel config:\n";
$configKey = config('services.gemini.api_key');

if ($configKey) {
    echo "✅ Found: " . substr($configKey, 0, 10) . "..." . substr($configKey, -5) . "\n";
    echo "Length: " . strlen($configKey) . " characters\n\n";
} else {
    echo "❌ Not found in config\n\n";
}

if ($apiKey && $configKey && $apiKey === $configKey) {
    echo "✅ .env and config match!\n";
} elseif ($apiKey && !$configKey) {
    echo "⚠️  .env has key but config doesn't - restart your server!\n";
} else {
    echo "❌ Keys don't match or missing\n";
}
