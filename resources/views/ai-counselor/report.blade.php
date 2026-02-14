<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Report Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 mb-8">
            <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center
                        @if($session->module === 'career_assessment') bg-gradient-to-br from-blue-500 to-blue-600
                        @elseif($session->module === 'interview_prep') bg-gradient-to-br from-green-500 to-teal-600
                        @else bg-gradient-to-br from-purple-500 to-pink-600 @endif text-white shadow-lg">
                        @if($session->module === 'career_assessment')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        @elseif($session->module === 'interview_prep')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900">
                            @if($session->module === 'career_assessment') Your Career DNA Report
                            @elseif($session->module === 'interview_prep') Interview Readiness Report
                            @else Resume Analysis Report @endif
                        </h1>
                        <p class="text-gray-500">Completed {{ $session->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('ai-counselor.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>

            @php
                $report = $session->report_data ?? [];
            @endphp

            <!-- Career Assessment Report -->
            @if($session->module === 'career_assessment')
                @if(isset($report['work_style']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Your Work Style
                    </h2>
                    <p class="text-gray-700 leading-relaxed">{{ $report['work_style'] }}</p>
                </div>
                @endif

                @if(isset($report['top_strengths']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        Top Strengths
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach((array)$report['top_strengths'] as $strength)
                            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ $strength }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($report['recommended_roles']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Recommended Roles
                    </h2>
                    <div class="grid gap-4">
                        @foreach((array)$report['recommended_roles'] as $role)
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <h3 class="font-semibold text-gray-900">{{ is_array($role) ? ($role['title'] ?? $role['name'] ?? 'Role') : $role }}</h3>
                                @if(is_array($role) && isset($role['reason']))
                                    <p class="text-gray-600 text-sm mt-1">{{ $role['reason'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($report['action_plan']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        90-Day Action Plan
                    </h2>
                    <div class="space-y-3">
                        @foreach((array)$report['action_plan'] as $index => $action)
                            <div class="flex items-start gap-4 p-4 bg-purple-50 rounded-xl border border-purple-100">
                                <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">{{ $index + 1 }}</div>
                                <div class="flex-1">
                                    @if(is_array($action))
                                        @if(isset($action['week']))
                                            <div class="text-xs font-semibold text-purple-600 mb-1">Week {{ $action['week'] }}</div>
                                        @endif
                                        <p class="text-gray-900 font-medium">{{ $action['task'] ?? $action['action'] ?? 'Action item' }}</p>
                                        @if(isset($action['expected_outcome']))
                                            <p class="text-gray-600 text-sm mt-1">Expected: {{ $action['expected_outcome'] }}</p>
                                        @endif
                                    @else
                                        <p class="text-gray-700">{{ $action }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            <!-- Interview Prep Report -->
            @elseif($session->module === 'interview_prep')
                @if(isset($report['overall_score']))
                <div class="text-center mb-8 p-6 bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl border border-green-100">
                    <div class="text-5xl font-black text-green-600 mb-2">{{ $report['overall_score'] }}/100</div>
                    <p class="text-gray-600 font-medium">Interview Readiness Score</p>
                    @if(isset($report['readiness_level']))
                        <p class="text-green-700 text-sm mt-1">{{ $report['readiness_level'] }}</p>
                    @endif
                </div>
                @endif

                @if(isset($report['summary']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Summary</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $report['summary'] }}</p>
                </div>
                @endif

                @if(isset($report['key_strengths']) && !empty($report['key_strengths']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 text-green-700">Key Strengths</h2>
                    <ul class="space-y-2">
                        @foreach((array)$report['key_strengths'] as $strength)
                            <li class="flex items-start gap-2 text-gray-700">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                {{ $strength }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(isset($report['areas_to_improve']) && !empty($report['areas_to_improve']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 text-amber-700">Areas to Improve</h2>
                    <ul class="space-y-2">
                        @foreach((array)$report['areas_to_improve'] as $area)
                            <li class="flex items-start gap-2 text-gray-700">
                                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                {{ $area }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(isset($report['recommended_practice']) && !empty($report['recommended_practice']))
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Recommended Practice</h2>
                    <div class="grid gap-4">
                        @foreach((array)$report['recommended_practice'] as $practice)
                            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="flex items-start gap-3">
                                    <span class="px-2 py-1 bg-blue-600 text-white text-xs font-semibold rounded uppercase shrink-0">
                                        {{ $practice['resource_type'] ?? 'Resource' }}
                                    </span>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $practice['topic'] ?? 'Practice Topic' }}</h3>
                                        <p class="text-gray-600 text-sm mt-1">{{ $practice['why'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            <!-- Legacy Resume Review Sessions -->
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Resume Analysis Has Moved</h2>
                    <p class="text-gray-600 mb-6">Resume analysis is now available on its own dedicated page with improved features and better results.</p>
                    <a href="{{ route('resume-analysis.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg">
                        Go to Resume Analysis →
                    </a>
                </div>
            @endif

        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('ai-counselor.index') }}" class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all text-center">
                Back to Modules
            </a>
            <form action="{{ route('ai-counselor.start') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="module" value="{{ $session->module }}">
                @if($session->module === 'interview_prep' && isset($session->context_data['target_role']))
                    <input type="hidden" name="target_role" value="{{ $session->context_data['target_role'] }}">
                @endif
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg">
                    Retake {{ ucwords(str_replace('_', ' ', $session->module)) }}
                </button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>
