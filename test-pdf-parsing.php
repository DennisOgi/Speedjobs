<?php

require __DIR__.'/vendor/autoload.php';

use Smalot\PdfParser\Parser as PdfParser;

echo "=== TESTING PDF PARSING ===\n\n";

// Check if PDF parser is available
if (!class_exists('Smalot\PdfParser\Parser')) {
    echo "❌ PDF Parser library NOT installed\n";
    exit(1);
}

echo "✓ PDF Parser library is installed\n\n";

// Look for any PDF files in storage
$resumesPath = __DIR__ . '/storage/app/resumes';
if (!is_dir($resumesPath)) {
    echo "No resumes directory found at: {$resumesPath}\n";
    echo "Upload a resume first to test parsing.\n";
    exit(0);
}

$files = glob($resumesPath . '/*.pdf');

if (empty($files)) {
    echo "No PDF files found in {$resumesPath}\n";
    echo "Upload a resume first to test parsing.\n";
    exit(0);
}

echo "Found " . count($files) . " PDF file(s) in storage:\n\n";

foreach ($files as $file) {
    $filename = basename($file);
    echo "Testing: {$filename}\n";
    echo str_repeat('-', 50) . "\n";
    
    try {
        $parser = new PdfParser();
        $pdf = $parser->parseFile($file);
        $text = $pdf->getText();
        
        // Clean up text
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        $textLength = strlen($text);
        $wordCount = str_word_count($text);
        
        echo "✓ Successfully parsed PDF\n";
        echo "Text length: {$textLength} characters\n";
        echo "Word count: {$wordCount} words\n";
        echo "\nFirst 300 characters:\n";
        echo substr($text, 0, 300) . "...\n\n";
        
        if ($textLength < 50) {
            echo "⚠️  WARNING: Very little text extracted. PDF might be image-based.\n";
        }
        
    } catch (\Exception $e) {
        echo "❌ Error parsing PDF: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "=== TEST COMPLETE ===\n";
