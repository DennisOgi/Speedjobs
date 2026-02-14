<?php

$apiKey = 'AIzaSyCb2LNF4b12S3tYOt3pGzA-_NG4S7LsTNM';
$model = 'gemini-1.5-flash';

echo "=== Testing Gemini API Directly ===\n\n";

echo "API Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -5) . "\n";
echo "Model: {$model}\n\n";

$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => 'Hello! Please respond with exactly: "Test successful!" and nothing else.']
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 2048,
    ]
];

echo "Sending request to Gemini API...\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "\nHTTP Status Code: {$httpCode}\n\n";

if ($error) {
    echo "❌ cURL Error: {$error}\n";
    exit(1);
}

if ($httpCode !== 200) {
    echo "❌ API Error:\n";
    echo $response . "\n";
    exit(1);
}

$result = json_decode($response, true);

if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    $text = $result['candidates'][0]['content']['parts'][0]['text'];
    echo "✅ API Response:\n";
    echo str_repeat("-", 60) . "\n";
    echo $text . "\n";
    echo str_repeat("-", 60) . "\n\n";
    
    if (isset($result['usageMetadata'])) {
        echo "Token Usage:\n";
        echo "- Prompt: " . ($result['usageMetadata']['promptTokenCount'] ?? 'N/A') . "\n";
        echo "- Response: " . ($result['usageMetadata']['candidatesTokenCount'] ?? 'N/A') . "\n";
        echo "- Total: " . ($result['usageMetadata']['totalTokenCount'] ?? 'N/A') . "\n\n";
    }
    
    echo "✅ Gemini API is working perfectly!\n\n";
    echo "Your AI Career Counselor is ready to use!\n";
} else {
    echo "⚠️  Unexpected response format:\n";
    echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
}
