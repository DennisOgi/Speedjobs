<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Career Assessments</h1>
                <p class="text-lg text-gray-600">Discover your strengths, interests, and ideal career paths</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Completed</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_completed'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">📊</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Personality</p>
                            <p class="text-2xl font-bold {{ $stats['personality_completed'] ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $stats['personality_completed'] ? '✓ Done' : 'Pending' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🧠</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Skills</p>
                            <p class="text-2xl font-bold {{ $stats['skills_completed'] ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $stats['skills_completed'] ? '✓ Done' : 'Pending' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">⚡</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Interest</p>
                            <p class="text-2xl font-bold {{ $stats['interest_completed'] ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $stats['interest_completed'] ? '✓ Done' : 'Pending' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">❤️</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($assessmentTypes as $type => $info)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-3xl">
                                        {{ $info['icon'] }}
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $info['title'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $info['duration'] }}</p>
                                    </div>
                                </div>
                                @if($completedAssessments->has($type))
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                                        Completed
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 mb-6">{{ $info['description'] }}</p>
                            
                            <div class="flex gap-3">
                                <a href="{{ route('assessments.show', $type) }}" 
                                   class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all text-center">
                                    {{ $completedAssessments->has($type) ? 'Retake Assessment' : 'Start Assessment' }}
                                </a>
                                
                                @if($completedAssessments->has($type))
                                    <a href="{{ route('assessments.results', $completedAssessments[$type]->first()->id) }}" 
                                       class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                                        View Results
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Recent Results -->
            @if($completedAssessments->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Assessment Results</h2>
                    
                    <div class="space-y-4">
                        @foreach($completedAssessments->flatten()->take(5) as $result)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-2xl">
                                        {{ $assessmentTypes[$result->assessment_type]['icon'] }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $assessmentTypes[$result->assessment_type]['title'] }}</h4>
                                        <p class="text-sm text-gray-600">Completed {{ $result->completed_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Overall Score</p>
                                        <p class="text-2xl font-bold text-blue-600">{{ $result->overall_score }}%</p>
                                    </div>
                                    <a href="{{ route('assessments.results', $result) }}" 
                                       class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
