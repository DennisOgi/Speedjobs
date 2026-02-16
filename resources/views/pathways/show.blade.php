<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <a href="{{ route('career-planning.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-2 inline-flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Career Planning
                        </a>
                        <h1 class="text-3xl font-bold text-gray-900 mt-2">Your AI-Powered Career Pathway</h1>
                        <p class="text-gray-600 mt-1">Generated on {{ $pathway->ai_generated_at->format('F j, Y') }}</p>
                    </div>
                    
                    <div class="text-right">
                        <div class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-200">
                            <span class="text-sm text-gray-600 mr-2">Progress:</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $pathway->progress_percentage }}%</span>
                        </div>
                    </div>
                </div>
                
                <!-- Career Path Summary -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm mb-1">Current Role</p>
                            <p class="text-xl font-semibold">{{ $pathway->current_role }}</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-8 h-8 mx-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm mb-1">Target Role</p>
                            <p class="text-xl font-semibold">{{ $pathway->target_role }}</p>
                        </div>
                    </div>
                    
                    @if(isset($pathway->pathway_data['timeline_years']))
                    <div class="mt-4 pt-4 border-t border-blue-400">
                        <p class="text-blue-100 text-sm">Estimated Timeline: <span class="font-semibold text-white">{{ $pathway->pathway_data['timeline_years'] }} years</span></p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- AI Analysis -->
            @if(isset($pathway->pathway_data['ai_analysis']))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">AI Career Analysis</h2>
                        <p class="text-gray-600">Personalized insights and recommendations</p>
                    </div>
                </div>
                
                <div class="prose prose-blue max-w-none">
                    {!! nl2br(e($pathway->pathway_data['ai_analysis'])) !!}
                </div>
            </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Milestones -->
                @if(isset($pathway->pathway_data['milestones']) && count($pathway->pathway_data['milestones']) > 0)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Milestones</h3>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">{{ count($pathway->pathway_data['milestones']) }}</p>
                    <p class="text-sm text-gray-600 mt-1">Key achievements to reach</p>
                </div>
                @endif

                <!-- Skills -->
                @if(isset($pathway->pathway_data['skills_required']) && count($pathway->pathway_data['skills_required']) > 0)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Skills</h3>
                    </div>
                    <p class="text-3xl font-bold text-purple-600">{{ count($pathway->pathway_data['skills_required']) }}</p>
                    <p class="text-sm text-gray-600 mt-1">Skills to develop</p>
                </div>
                @endif

                <!-- Resources -->
                @if(isset($pathway->pathway_data['resources']) && count($pathway->pathway_data['resources']) > 0)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Resources</h3>
                    </div>
                    <p class="text-3xl font-bold text-green-600">{{ count($pathway->pathway_data['resources']) }}</p>
                    <p class="text-sm text-gray-600 mt-1">Learning resources</p>
                </div>
                @endif
            </div>

            <!-- Detailed Sections -->
            <div class="space-y-6">
                
                <!-- Milestones -->
                @if(isset($pathway->pathway_data['milestones']) && count($pathway->pathway_data['milestones']) > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        Key Milestones
                    </h3>
                    <div class="space-y-4">
                        @foreach($pathway->pathway_data['milestones'] as $index => $milestone)
                        <div class="border-l-4 border-blue-600 pl-6 py-4 bg-gray-50 rounded-r-lg hover:bg-blue-50 transition-colors">
                            <div class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm mr-4 -ml-10">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $milestone['title'] ?? 'Milestone ' . ($index + 1) }}</h4>
                                    <p class="text-gray-700 mb-3">{{ $milestone['description'] ?? '' }}</p>
                                    
                                    @if(isset($milestone['duration_weeks']))
                                    <p class="text-sm text-blue-600 font-medium mb-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Duration: {{ $milestone['duration_weeks'] }} weeks
                                    </p>
                                    @endif
                                    
                                    @if(isset($milestone['skills_gained']) && is_array($milestone['skills_gained']) && count($milestone['skills_gained']) > 0)
                                    <div class="mt-3">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Skills You'll Gain:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($milestone['skills_gained'] as $skill)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                                {{ $skill }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Skills Required -->
                @if(isset($pathway->pathway_data['skills_required']) && count($pathway->pathway_data['skills_required']) > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </span>
                        Skills to Develop
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($pathway->pathway_data['skills_required'] as $skill)
                        <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg font-medium hover:bg-purple-200 transition-colors">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Resources -->
                @if(isset($pathway->pathway_data['resources']) && count($pathway->pathway_data['resources']) > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </span>
                        Recommended Resources
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($pathway->pathway_data['resources'] as $resource)
                        <div class="p-5 bg-gradient-to-br from-gray-50 to-green-50 rounded-xl border border-green-100 hover:shadow-md transition-all">
                            @if(isset($resource['type']))
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold mb-3
                                {{ $resource['type'] === 'course' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $resource['type'] === 'certification' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $resource['type'] === 'book' ? 'bg-green-100 text-green-700' : '' }}">
                                @if($resource['type'] === 'course')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @elseif($resource['type'] === 'certification')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @endif
                                {{ ucfirst($resource['type']) }}
                            </div>
                            @endif
                            
                            <h4 class="font-bold text-gray-900 mb-2">{{ $resource['title'] ?? 'Resource' }}</h4>
                            <p class="text-gray-600 text-sm">{{ $resource['description'] ?? '' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Workbook Responses -->
                @if(isset($pathway->pathway_data['workbook_responses']))
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        Your Workbook Responses
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php $responses = $pathway->pathway_data['workbook_responses']; @endphp
                        
                        @if(isset($responses['strengths']))
                        <div>
                            <p class="font-semibold text-gray-900 mb-2">Professional Strengths</p>
                            <p class="text-gray-600">{{ $responses['strengths'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($responses['values']))
                        <div>
                            <p class="font-semibold text-gray-900 mb-2">Core Values</p>
                            <p class="text-gray-600">{{ $responses['values'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($responses['interests']))
                        <div>
                            <p class="font-semibold text-gray-900 mb-2">Interests</p>
                            <p class="text-gray-600">{{ $responses['interests'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($responses['short_term_goal']))
                        <div>
                            <p class="font-semibold text-gray-900 mb-2">Short-term Goal</p>
                            <p class="text-gray-600">{{ $responses['short_term_goal'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($responses['long_term_goal']))
                        <div>
                            <p class="font-semibold text-gray-900 mb-2">Long-term Goal</p>
                            <p class="text-gray-600">{{ $responses['long_term_goal'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($responses['skills_gap']))
                        <div>
                            <p class="font-semibold text-gray-900 mb-2">Skills to Acquire</p>
                            <p class="text-gray-600">{{ $responses['skills_gap'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-8 flex gap-4">
                <a href="{{ route('career-planning.index') }}" class="flex-1 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all text-center shadow-lg">
                    Create New Career Plan
                </a>
                <a href="{{ route('pathways.index') }}" class="flex-1 py-4 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all text-center">
                    View All Pathways
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
