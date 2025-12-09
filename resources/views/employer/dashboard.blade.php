<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-gray-900">Employer Dashboard</h1>
                    <p class="text-gray-600 mt-1">Manage your job postings and find the best talent.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('employer.applications') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 shadow-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        View Applicants
                    </a>
                    <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-white hover:bg-primary-700 shadow-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Post a Job
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Jobs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_jobs'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Applicants</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_applicants'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pending Review</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_applications'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-50 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Views</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_views'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Jobs -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="font-bold text-gray-900">Your Job Postings</h2>
                            <a href="{{ route('employer.jobs.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
                        </div>
                        
                        @forelse($jobs->take(5) as $job)
                            <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-900">
                                            <a href="{{ route('jobs.show', $job) }}" class="hover:text-primary-600">{{ $job->title }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $job->location }} • {{ $job->type }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Posted {{ $job->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-600">
                                            <span class="font-bold text-primary-600">{{ $job->applications->count() }}</span> applicants
                                        </span>
                                        <a href="{{ route('employer.jobs.edit', $job) }}" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-500">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">No jobs posted yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first job posting.</p>
                                <a href="{{ route('jobs.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200">
                                    Create Job Posting
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Applicants -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="font-bold text-gray-900">Recent Applicants</h2>
                            <a href="{{ route('employer.applications') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
                        </div>
                        
                        @forelse($recentApplications as $application)
                            <div class="p-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center text-primary-700 font-bold">
                                        {{ substr($application->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate">{{ $application->user->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">Applied for {{ $application->job->title }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full 
                                        @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                                        @elseif($application->status === 'shortlisted') bg-purple-100 text-purple-800
                                        @elseif($application->status === 'offered') bg-green-100 text-green-800
                                        @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                <p class="text-sm">No applicants yet.</p>
                                <p class="text-xs text-gray-400 mt-1">Post a job to start receiving applications.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 bg-gradient-to-br from-primary-600 to-primary-800 rounded-xl shadow-lg p-6 text-white">
                        <h3 class="font-bold text-lg mb-2">Find Top Talent</h3>
                        <p class="text-primary-100 text-sm mb-4">Browse our database of qualified candidates ready to work.</p>
                        <a href="{{ route('browse-candidates') }}" class="block w-full py-2 bg-white text-primary-700 font-bold rounded-lg text-center hover:bg-primary-50 transition-colors">
                            Browse Candidates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
