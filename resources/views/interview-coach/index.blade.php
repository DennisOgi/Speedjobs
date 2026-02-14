<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Interview Coach</h1>
                <p class="text-lg text-gray-600">Practice interviews with AI-powered feedback</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Sessions</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_sessions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🎯</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Questions Answered</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_questions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">❓</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Average Score</p>
                            <p class="text-3xl font-bold text-purple-600">{{ round($stats['average_score']) }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">⭐</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start New Session -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Start New Practice Session</h2>
                <a href="{{ route('interview-coach.practice') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Start Practice Interview
                </a>
            </div>

            <!-- Recent Sessions -->
            @if($sessions->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Sessions</h2>
                    
                    <div class="space-y-4">
                        @foreach($sessions as $session)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $session->role }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ ucfirst($session->experience_level) }} Level • 
                                        {{ $session->questions_count }} Questions • 
                                        {{ $session->started_at->diffForHumans() }}
                                    </p>
                                </div>
                                
                                @if($session->average_score)
                                    <div class="text-right mr-4">
                                        <p class="text-sm text-gray-600">Score</p>
                                        <p class="text-2xl font-bold {{ $session->average_score >= 80 ? 'text-green-600' : ($session->average_score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ round($session->average_score) }}%
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $sessions->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
