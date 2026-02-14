<?php

$apiKey = 'AIzaSyCb2LNF4b12S3tYOt3pGzA-_NG4S7LsTNM';
$model = 'gemini-2.5-flash';

echo "Testing Gemini API directly...\n\n";

$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Say exactly: Hello, I am working!']
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 100,
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
if ($error) {
    echo "CURL Error: $error\n";
}
echo "\n";

if ($httpCode === 200) {
    $json = json_decode($response, true);
    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
        echo "✅ SUCCESS!\n";
        echo "Response: " . $json['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "❌ Unexpected response structure\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }
} else {
    echo "❌ API Error\n";
    echo "Response: " . substr($response, 0, 500) . "\n";
}
