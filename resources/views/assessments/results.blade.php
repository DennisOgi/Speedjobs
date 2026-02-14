<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('assessments.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-4 inline-block">
                    ← Back to Assessments
                </a>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-4xl">
                            {{ $assessmentInfo['icon'] }}
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">{{ $assessmentInfo['title'] }} Results</h1>
                            <p class="text-lg text-gray-600">Completed {{ $result->completed_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('assessments.download', $result) }}" 
                       class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        Download PDF
                    </a>
                </div>
            </div>

            <!-- Overall Score -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 mb-8 text-white">
                <div class="text-center">
                    <p class="text-lg mb-2 opacity-90">Overall Score</p>
                    <p class="text-6xl font-bold mb-2">{{ $result->overall_score }}%</p>
                    <p class="text-lg opacity-90">
                        @if($result->overall_score >= 80)
                            Excellent Performance
                        @elseif($result->overall_score >= 60)
                            Good Performance
                        @elseif($result->overall_score >= 40)
                            Average Performance
                        @else
                            Needs Improvement
                        @endif
                    </p>
                </div>
            </div>

            <!-- Scores Breakdown -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Score Breakdown</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($result->scores as $category => $score)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-700 font-semibold capitalize">{{ str_replace('_', ' ', $category) }}</span>
                                <span class="text-gray-900 font-bold">{{ $score }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-3 rounded-full transition-all" 
                                     style="width: {{ $score }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- AI Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">AI Analysis</h2>
                <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                    {{ $result->ai_analysis }}
                </div>
            </div>

            <!-- Recommendations -->
            @if(!empty($result->recommendations))
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Recommendations</h2>
                    <div class="space-y-4">
                        @foreach($result->recommendations as $index => $recommendation)
                            <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-lg">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                    {{ $index + 1 }}
                                </div>
                                <p class="text-gray-700 flex-1">{{ $recommendation }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-4">
                <a href="{{ route('assessments.show', $result->assessment_type) }}" 
                   class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all text-center">
                    Retake Assessment
                </a>
                <a href="{{ route('ai-counselor.index') }}" 
                   class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors text-center">
                    Discuss with AI Counselor
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
