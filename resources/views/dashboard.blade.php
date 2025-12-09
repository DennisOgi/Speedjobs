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
                <a href="{{ route('applications.index') }}" class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-2xl border border-white/20 p-6 group block">
                    <div class="flex items-center">
                        <div class="p-4 rounded-2xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Applications</p>
                            <p class="text-3xl font-heading font-bold text-gray-900">{{ count($recentApplications) }}</p>
                        </div>
                    </div>
                </a>
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
