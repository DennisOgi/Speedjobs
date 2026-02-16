<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-10 bg-white/80 backdrop-blur-lg rounded-3xl shadow-lg border border-white/20 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary-100 to-accent-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-16 -mt-16"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-heading font-bold text-gray-900">
                            Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-primary-800">{{ Auth::user()->name }}</span>!
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">Ready to take the next step in your career? Here's your daily overview.</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('resume.create') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Update CV
                        </a>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 border border-transparent rounded-xl font-bold text-white hover:bg-primary-700 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            Find Jobs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @php
                    $isPaid = auth()->user()->is_paid ?? false;
                @endphp
                @if($isPaid)
                    <a href="{{ route('applications.index') }}" class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-2xl border border-white/20 p-6 group block">
                @else
                    <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm rounded-2xl border border-white/20 p-6">
                @endif
                    <div class="flex items-center">
                        <div class="p-4 rounded-2xl bg-blue-50 text-blue-600 @if($isPaid) group-hover:bg-blue-600 group-hover:text-white @endif transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Job Applications</p>
                            <p class="text-3xl font-heading font-bold text-gray-900">{{ count($recentApplications) }}</p>
                        </div>
                    </div>
                @if($isPaid)
                    </a>
                @else
                    </div>
                @endif
                <a href="{{ route('courses.my-courses') }}" class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-2xl border border-white/20 p-6 group block">
                    <div class="flex items-center">
                        <div class="p-4 rounded-2xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Courses</p>
                            <p class="text-3xl font-heading font-bold text-gray-900">{{ count($activeEnrollments) }}</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('saved-jobs.index') }}" class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-2xl border border-white/20 p-6 group block">
                    <div class="flex items-center">
                        <div class="p-4 rounded-2xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Saved Jobs</p>
                            <p class="text-3xl font-heading font-bold text-gray-900">{{ count($savedJobs) }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recommended Jobs -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- AI Career Intelligence Report -->
                    <div x-data="careerReport()" x-init="init()" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
                        <div class="p-6 border-b border-gray-50 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                            <h2 class="text-xl font-heading font-bold text-gray-900 flex items-center gap-2">
                                <span class="text-2xl">🚀</span> Career Intelligence Report
                            </h2>
                            @if(Auth::user()->is_paid)
                                <button @click="refreshReport()" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1" :disabled="loading">
                                    <svg class="w-4 h-4" :class="{'animate-spin': loading}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Refresh Analysis
                                </button>
                            @endif
                        </div>

                        <div class="p-6">
                            @if(!Auth::user()->is_paid)
                                <!-- Premium Gate -->
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Unlock Your Career Potential</h3>
                                    <p class="text-gray-500 max-w-md mx-auto mb-6">Get a personalized AI-powered career report analyzing your skills, suggesting roles, and providing a custom action plan.</p>
                                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                                        Update Profile to Premium
                                    </a>
                                </div>
                            @else
                                <!-- Loading State -->
                                <div x-show="loading" class="py-12 text-center">
                                    <div class="inline-block relative w-20 h-20 mb-4">
                                        <div class="absolute top-0 left-0 w-full h-full border-4 border-gray-100 rounded-full"></div>
                                        <div class="absolute top-0 left-0 w-full h-full border-4 border-primary-500 rounded-full border-t-transparent animate-spin"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-2xl">🤖</span>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Analyzing Your Profile...</h3>
                                    <p class="text-gray-500 text-sm mt-2">Our AI is reviewing your experience and skills.</p>
                                </div>

                                <!-- Error State -->
                                <div x-show="error" x-cloak class="py-8 text-center">
                                    <p class="text-red-500 mb-4" x-text="error"></p>
                                    <button @click="fetchReport()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 font-medium transition-colors">
                                        Try Again
                                    </button>
                                </div>

                                <!-- Report Content -->
                                <div x-show="!loading && !error && report" x-cloak class="space-y-8">
                                    <!-- Summary -->
                                    <div class="bg-blue-50/50 rounded-xl p-5 border border-blue-100">
                                        <h3 class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Executive Summary
                                        </h3>
                                        <div class="text-gray-700 leading-relaxed prose prose-sm max-w-none" x-html="formatMarkdown(report.summary)"></div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Strengths -->
                                        <div>
                                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Key Strengths
                                            </h3>
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="strength in report.strengths" :key="strength">
                                                    <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm border border-green-100 font-medium" x-text="strength"></span>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Improvement Areas -->
                                        <div>
                                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                                Areas for Growth
                                            </h3>
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="area in report.improvement_areas" :key="area">
                                                    <span class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg text-sm border border-amber-100 font-medium" x-text="area"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Recommended Roles -->
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            Recommended Roles
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <template x-for="role in report.recommended_roles" :key="role">
                                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-400 shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                    <span class="font-medium text-gray-700" x-text="role"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Action Plan -->
                                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                            Your Action Plan
                                        </h3>
                                        <ul class="space-y-3">
                                            <template x-for="(step, index) in report.action_plan" :key="index">
                                                <li class="flex gap-3">
                                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold" x-text="index + 1"></span>
                                                    <div class="text-gray-700 prose prose-sm max-w-none" x-html="formatMarkdown(step)"></div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <script>
                        function careerReport() {
                            return {
                                loading: false,
                                report: null,
                                error: null,
                                
                                init() {
                                    @if(Auth::user()->is_paid)
                                        this.fetchReport();
                                    @endif
                                },
                                
                                formatMarkdown(text) {
                                    if (!text) return '';
                                    // Convert **bold** to <strong>
                                    text = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
                                    // Convert *italic* to <em>
                                    text = text.replace(/\*(.+?)\*/g, '<em>$1</em>');
                                    // Convert line breaks
                                    text = text.replace(/\n/g, '<br>');
                                    return text;
                                },
                                
                                async fetchReport(forceRefresh = false) {
                                    this.loading = true;
                                    this.error = null;
                                    try {
                                        const url = forceRefresh ? '/ai-counselor/profile-report?refresh=true' : '/ai-counselor/profile-report';
                                        const response = await fetch(url, {
                                            headers: {
                                                'Accept': 'application/json',
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                                            }
                                        });
                                        
                                        if (!response.ok) {
                                            const errorData = await response.json().catch(() => ({}));
                                            throw new Error(errorData.message || "Failed to load your career report.");
                                        }
                                        
                                        const data = await response.json();
                                        console.log('Report data received:', data);
                                        
                                        // Data is returned directly from API
                                        if (!data || typeof data !== 'object') {
                                            throw new Error("Invalid report format received");
                                        }
                                        
                                        // Validate required fields
                                        if (!data.summary) {
                                            throw new Error("Report is missing required fields. Please try refreshing.");
                                        }
                                        
                                        // Ensure arrays exist with defaults
                                        this.report = {
                                            summary: data.summary || '',
                                            strengths: data.strengths || [],
                                            improvement_areas: data.improvement_areas || [],
                                            recommended_roles: data.recommended_roles || [],
                                            action_plan: data.action_plan || []
                                        };
                                        
                                        console.log('Report loaded successfully:', this.report);
                                    } catch (e) {
                                        console.error('Report error:', e);
                                        this.error = e.message || "We couldn't generate your report right now. Please try again later.";
                                    } finally {
                                        this.loading = false;
                                    }
                                },
                                
                                refreshReport() {
                                    if (confirm('Generate a new analysis? This may take a few moments.')) {
                                        this.fetchReport(true);
                                    }
                                }
                            }
                        }
                    </script>
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-heading font-bold text-gray-900">Recommended for You</h2>
                        <a href="{{ route('jobs.index') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1">
                            View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 divide-y divide-gray-100">
                        @forelse($recommendedJobs as $job)
                        <div class="p-6 hover:bg-white/50 transition-colors group relative">
                            <div class="flex justify-between items-start">
                                <div class="flex gap-5">
                                    <div class="w-14 h-14 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl flex items-center justify-center text-gray-500 font-bold text-xl shrink-0 shadow-inner border border-gray-100">
                                        {{ substr($job->company, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                                            <a href="{{ route('jobs.show', $job) }}" class="focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ $job->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm font-medium text-gray-500 mt-1">{{ $job->company }} • {{ $job->location }}</p>
                                        <div class="flex gap-2 mt-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $job->type }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                                {{ $job->salary_range }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button class="text-gray-300 hover:text-primary-600 transition-colors z-10 relative">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p>No recommended jobs found yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Sidebar Widgets -->
                <div class="space-y-8">
                    <!-- My Learning -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 p-6">
                        <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            My Learning
                        </h3>
                        
                        <div class="space-y-4">
                            @forelse($activeEnrollments as $enrollment)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-gray-700 truncate w-2/3">{{ $enrollment->course->title }}</span>
                                        <span class="text-blue-600 font-bold">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No active courses.</p>
                                <a href="{{ route('courses.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Start Learning</a>
                            @endforelse
                        </div>
                        
                        @if($activeEnrollments->count() > 0)
                            <a href="{{ route('courses.my-courses') }}" class="block mt-4 text-center text-sm font-bold text-gray-500 hover:text-gray-700">View All Courses</a>
                        @endif
                    </div>

                    <!-- Counseling Requests -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 p-6">
                        <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Counseling Requests
                        </h3>

                        <div class="space-y-3">
                            @forelse($counselingRequests as $request)
                                <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $request->request_type }}</p>
                                        <p class="text-xs text-gray-500">{{ $request->created_at->format('M d') }}</p>
                                    </div>
                                    @if($request->status === 'pending')
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($request->status === 'assigned')
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">Assigned</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-800">{{ ucfirst($request->status) }}</span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No requests yet.</p>
                                <a href="{{ route('counseling.create') }}" class="text-sm font-bold text-purple-600 hover:text-purple-700">Request Guidance</a>
                            @endforelse
                        </div>
                        
                        @if($counselingRequests->count() > 0)
                            <a href="{{ route('counseling.index') }}" class="block mt-4 text-center text-sm font-bold text-gray-500 hover:text-gray-700">View All Requests</a>
                        @endif
                    </div>

                    <!-- My Programme Applications -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 p-6">
                        <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            My Applications
                        </h3>

                        <div class="space-y-3">
                            @forelse($bannerApplications ?? [] as $application)
                                <div class="block p-3 rounded-xl hover:bg-gray-50 transition-colors border border-gray-100">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $application->banner->title }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="px-2 py-0.5 rounded text-xs font-semibold
                                                    @if($application->banner->type === 'training') bg-green-50 text-green-700
                                                    @elseif($application->banner->type === 'event') bg-purple-50 text-purple-700
                                                    @elseif($application->banner->type === 'workshop') bg-blue-50 text-blue-700
                                                    @else bg-gray-50 text-gray-700
                                                    @endif">
                                                    {{ ucfirst($application->banner->type) }}
                                                </span>
                                                <span class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        @if($application->status === 'pending')
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800 shrink-0 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Pending
                                            </span>
                                        @elseif($application->status === 'approved')
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800 shrink-0 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Approved
                                            </span>
                                        @elseif($application->status === 'rejected')
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800 shrink-0 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Rejected
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-800 shrink-0">{{ ucfirst($application->status) }}</span>
                                        @endif
                                    </div>
                                    @if($application->admin_notes && $application->status !== 'pending')
                                        <p class="text-xs text-gray-600 mt-2 pl-1">💬 {{ Str::limit($application->admin_notes, 60) }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No applications yet.</p>
                                <a href="{{ route('welcome') }}" class="text-sm font-bold text-green-600 hover:text-green-700">Browse Programmes</a>
                            @endforelse
                        </div>
                        
                        @if(isset($bannerApplications) && $bannerApplications->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('banner-applications.index') }}" class="text-sm font-bold text-green-600 hover:text-green-700 flex items-center gap-1">
                                    View All Applications
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- My Career Pathways -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 p-6">
                        <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            My Career Pathways
                        </h3>

                        <div class="space-y-3">
                            @forelse($careerPathways ?? [] as $pathway)
                                <a href="{{ route('pathways.show', $pathway) }}" class="block p-4 rounded-xl hover:bg-blue-50 transition-colors border border-gray-100 group">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                {{ $pathway->target_role }}
                                            </p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                From {{ $pathway->current_role }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-2">
                                                <span class="text-xs text-gray-500">
                                                    {{ $pathway->pathway_data['duration_months'] ?? 12 }} months
                                                </span>
                                                <span class="text-xs text-gray-400">•</span>
                                                <span class="text-xs text-gray-500">
                                                    {{ count($pathway->pathway_data['milestones'] ?? []) }} milestones
                                                </span>
                                            </div>
                                        </div>
                                        <div class="shrink-0 text-right">
                                            <div class="text-2xl font-bold text-blue-600">{{ $pathway->progress_percentage }}%</div>
                                            <p class="text-xs text-gray-500 mt-1">Progress</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div class="mt-3 bg-gray-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full transition-all duration-500" style="width: {{ $pathway->progress_percentage }}%"></div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-6">
                                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3">No career pathways yet</p>
                                    <a href="{{ route('career-planning.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Create Your First Pathway
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        
                        @if(isset($careerPathways) && $careerPathways->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('pathways.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                    View All Pathways
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Completion -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 p-6">
                        <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile Completion
                        </h3>
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    @if($profileCompletion >= 100)
                                        <span class="text-xs font-bold inline-block py-1 px-2 uppercase rounded-lg text-green-700 bg-green-100">
                                            Complete
                                        </span>
                                    @elseif($profileCompletion >= 50)
                                        <span class="text-xs font-bold inline-block py-1 px-2 uppercase rounded-lg text-primary-700 bg-primary-100">
                                            In Progress
                                        </span>
                                    @else
                                        <span class="text-xs font-bold inline-block py-1 px-2 uppercase rounded-lg text-amber-700 bg-amber-100">
                                            Getting Started
                                        </span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold inline-block {{ $profileCompletion >= 100 ? 'text-green-600' : 'text-primary-600' }}">
                                        {{ $profileCompletion }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-100">
                                <div style="width:{{ $profileCompletion }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $profileCompletion >= 100 ? 'bg-gradient-to-r from-green-500 to-green-600' : 'bg-gradient-to-r from-primary-500 to-primary-600' }} rounded-full transition-all duration-500"></div>
                            </div>
                            @if($profileCompletion < 100)
                                <p class="text-sm text-gray-500 mb-5 leading-relaxed">Complete your profile to increase your chances of being scouted by top employers.</p>
                                <a href="{{ route('profile.edit') }}" class="block w-full text-center px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all">
                                    Complete Profile
                                </a>
                            @else
                                <p class="text-sm text-green-600 mb-5 leading-relaxed font-medium">Great job! Your profile is complete. Employers can now find you easily.</p>
                                <a href="{{ route('profile.edit') }}" class="block w-full text-center px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all">
                                    Edit Profile
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Career Advice -->
                    <div class="bg-gradient-to-br from-brand-dark to-primary-900 rounded-2xl shadow-lg p-8 text-white relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl -mr-10 -mt-10 transition-transform duration-700 group-hover:scale-150"></div>
                        
                        <h3 class="font-heading font-bold text-xl mb-2 relative z-10">Need Career Advice?</h3>
                        <p class="text-primary-100 text-sm mb-6 relative z-10 leading-relaxed">Get expert guidance on your CV, interview skills, and career path from industry professionals.</p>
                        <a href="{{ route('counseling.create') }}" class="block w-full py-3 bg-white text-primary-900 font-bold rounded-xl hover:bg-primary-50 transition-colors shadow-lg relative z-10 text-center">
                            Book a Session
                        </a>
                    </div>


                    @if(Auth::user()->is_paid)
                    <!-- Resources & Workbooks (Paid Users Only) -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-white/20 p-6">
                        <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Career Planning Workbook & Resources
                        </h3>
                        <div class="space-y-3">
                            @forelse($resources as $resource)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-white transition-all border border-transparent hover:border-gray-100 shadow-sm">
                                    <div class="flex-1 min-w-0 mr-3">
                                        <h4 class="text-sm font-bold text-gray-900 truncate">{{ $resource->title }}</h4>
                                        <p class="text-xs text-gray-500 truncate">{{ $resource->description }}</p>
                                    </div>
                                    <a href="{{ Storage::url($resource->file_path) }}" target="_blank" class="p-2 bg-white text-blue-600 rounded-lg shadow-sm hover:text-blue-700 hover:shadow transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">No resources available yet.</p>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
