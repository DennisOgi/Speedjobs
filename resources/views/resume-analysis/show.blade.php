<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('resume-analysis.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-2 inline-block">
                            ← Back to Analyses
                        </a>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Resume Analysis Results</h1>
                        <p class="text-lg text-gray-600">{{ $analysis->file_name }}</p>
                    </div>
                    <form action="{{ route('resume-analysis.destroy', $analysis) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this analysis?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                            Delete Analysis
                        </button>
                    </form>
                </div>
            </div>

            <!-- ATS Score Card -->
            <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl shadow-lg p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">ATS Compatibility Score</h2>
                        <p class="text-blue-100">Analyzed {{ $analysis->analyzed_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-5xl font-bold {{ $analysis->ats_score >= 80 ? 'text-green-600' : ($analysis->ats_score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $analysis->ats_score }}
                                </div>
                                <div class="text-sm text-gray-600 font-semibold">out of 100</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Score Interpretation -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Score Interpretation</h3>
                <div class="space-y-3">
                    @if($analysis->ats_score >= 80)
                        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-lg">
                            <span class="text-2xl">✅</span>
                            <div>
                                <h4 class="font-semibold text-green-900">Excellent Score!</h4>
                                <p class="text-green-800">Your resume is well-optimized for ATS systems and should pass most automated screenings.</p>
                            </div>
                        </div>
                    @elseif($analysis->ats_score >= 60)
                        <div class="flex items-start gap-3 p-4 bg-yellow-50 rounded-lg">
                            <span class="text-2xl">⚠️</span>
                            <div>
                                <h4 class="font-semibold text-yellow-900">Good Score - Room for Improvement</h4>
                                <p class="text-yellow-800">Your resume has a decent chance of passing ATS systems, but there are areas that could be optimized.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 p-4 bg-red-50 rounded-lg">
                            <span class="text-2xl">❌</span>
                            <div>
                                <h4 class="font-semibold text-red-900">Needs Improvement</h4>
                                <p class="text-red-800">Your resume may struggle with ATS systems. Review the recommendations below to improve your score.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($analysis->job_description)
                <!-- Job Description -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Analyzed Against Job Description</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $analysis->job_description }}</p>
                    </div>
                </div>
            @endif

            <!-- AI Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Detailed Analysis & Recommendations</h3>
                <div class="prose prose-blue max-w-none">
                    {!! $formattedAnalysis !!}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex gap-4">
                <a href="{{ route('resume-analysis.index') }}" 
                   class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    Analyze Another Resume
                </a>
                <a href="{{ route('resume.create') }}" 
                   class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                    Build New Resume
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
