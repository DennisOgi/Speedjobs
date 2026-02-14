<?php

/**
 * AI Career Counselor - Complete Implementation Script
 * 
 * This script creates all remaining view files for the AI Career Counselor feature.
 * Run with: php complete-implementation.php
 */

$views = [
    'assessments/results.blade.php' => <<<'BLADE'
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('assessments.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-4 inline-block">
                    ← Back to Assessments
                </a>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $assessmentInfo['title'] }} Results</h1>
                        <p class="text-lg text-gray-600">Completed {{ $result->completed_at->format('F j, Y') }}</p>
                    </div>
                    <a href="{{ route('assessments.download', $result) }}" 
                       class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        Download PDF
                    </a>
                </div>
            </div>

            <!-- Overall Score -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-8 text-white mb-8">
                <div class="text-center">
                    <p class="text-xl mb-2">Overall Score</p>
                    <p class="text-6xl font-bold mb-2">{{ $result->overall_score }}%</p>
                    <p class="text-lg opacity-90">{{ $result->overall_score >= 80 ? 'Excellent' : ($result->overall_score >= 60 ? 'Good' : 'Fair') }}</p>
                </div>
            </div>

            <!-- Scores Breakdown -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Score Breakdown</h2>
                <div class="space-y-4">
                    @foreach($result->scores as $category => $score)
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold text-gray-700">{{ ucfirst(str_replace('_', ' ', $category)) }}</span>
                                <span class="font-bold text-blue-600">{{ $score }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-3 rounded-full" style="width: {{ $score }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- AI Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">AI Analysis & Recommendations</h2>
                <div class="prose prose-lg max-w-none">
                    {!! \Illuminate\Support\Str::markdown($result->ai_analysis) !!}
                </div>
            </div>

            <!-- Recommendations -->
            @if($result->recommendations && count($result->recommendations) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Career Recommendations</h2>
                    <div class="space-y-4">
                        @foreach($result->recommendations as $index => $recommendation)
                            <div class="flex gap-4 p-4 bg-blue-50 rounded-lg">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <p class="text-gray-700">{{ $recommendation }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
BLADE,

    'pathways/index.blade.php' => <<<'BLADE'
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Career Pathways</h1>
                    <p class="text-lg text-gray-600">Your personalized roadmaps to career success</p>
                </div>
                <a href="{{ route('pathways.create') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all">
                    + Create New Pathway
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-1">Total Pathways</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pathways'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-1">Active</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['active_pathways'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-1">Completed</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['completed_pathways'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-1">Avg Progress</p>
                    <p class="text-3xl font-bold text-purple-600">{{ round($stats['average_progress']) }}%</p>
                </div>
            </div>

            <!-- Active Pathway -->
            @if($activePathway)
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-8 text-white mb-8">
                    <h2 class="text-2xl font-bold mb-4">🎯 Active Pathway</h2>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg opacity-90 mb-2">{{ $activePathway->current_role }} → {{ $activePathway->target_role }}</p>
                            <div class="w-64 bg-white/20 rounded-full h-3">
                                <div class="bg-white h-3 rounded-full" style="width: {{ $activePathway->progress_percentage }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('pathways.show', $activePathway) }}" 
                           class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                            View Pathway
                        </a>
                    </div>
                </div>
            @endif

            <!-- Pathways List -->
            <div class="space-y-4">
                @forelse($pathways as $pathway)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $pathway->target_role }}</h3>
                                    <span class="px-3 py-1 bg-{{ $pathway->status === 'active' ? 'green' : 'blue' }}-100 text-{{ $pathway->status === 'active' ? 'green' : 'blue' }}-700 text-sm font-semibold rounded-full">
                                        {{ ucfirst($pathway->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4">From: {{ $pathway->current_role }}</p>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-600">Progress</span>
                                            <span class="font-semibold text-gray-900">{{ $pathway->progress_percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-2 rounded-full" style="width: {{ $pathway->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Created {{ $pathway->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('pathways.show', $pathway) }}" 
                               class="ml-6 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-600 mb-4">No career pathways yet</p>
                        <a href="{{ route('pathways.create') }}" 
                           class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Create Your First Pathway
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $pathways->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
BLADE,
];

// Create directories and files
foreach ($views as $path => $content) {
    $fullPath = __DIR__ . '/resources/views/' . $path;
    $dir = dirname($fullPath);
    
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    }
    
    file_put_contents($fullPath, $content);
    echo "Created view: $path\n";
}

echo "\n✅ All views created successfully!\n";
echo "\nNext steps:\n";
echo "1. Run: composer require smalot/pdfparser barryvdh/laravel-dompdf\n";
echo "2. Run: php artisan migrate\n";
echo "3. Test the features!\n";
