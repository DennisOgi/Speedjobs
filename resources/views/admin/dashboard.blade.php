<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">ADMIN</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-l-4 border-primary-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_users']) }}</p>
                            </div>
                            <div class="p-3 bg-primary-100 rounded-full">
                                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Jobs -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-l-4 border-accent-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Jobs</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_jobs']) }}</p>
                            </div>
                            <div class="p-3 bg-accent-100 rounded-full">
                                <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Courses -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Courses</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_courses']) }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-semibold text-blue-600">{{ number_format($stats['total_enrollments']) }}</span> enrollments
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Requests</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['pending_requests']) }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-semibold text-yellow-600">{{ number_format($stats['total_counselors']) }}</span> active counselors
                        </div>
                    </div>
                </div>

                <!-- Active Banners -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Banners</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['active_banners']) }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                        <a href="{{ route('admin.counseling.index') }}" class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-yellow-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-yellow-600">Counseling</p>
                                <p class="text-sm text-gray-600">Manage requests</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.banners.index') }}" class="flex items-center p-4 bg-primary-50 hover:bg-primary-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-primary-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-primary-600">Banners</p>
                                <p class="text-sm text-gray-600">Manage ads</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.resources.index') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-green-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-green-600">Resources</p>
                                <p class="text-sm text-gray-600">Manage files</p>
                            </div>
                        </a>

                        <a href="{{ route('jobs.index') }}" class="flex items-center p-4 bg-accent-50 hover:bg-accent-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-accent-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-accent-600">Jobs</p>
                                <p class="text-sm text-gray-600">View listings</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-blue-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-blue-600">Users</p>
                                <p class="text-sm text-gray-600">Manage users</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.workshops.index') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-purple-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-purple-600">Workshops</p>
                                <p class="text-sm text-gray-600">Manage events</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.banner-applications.index') }}" class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors group">
                            <div class="p-3 bg-orange-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-orange-600">Applications</p>
                                <p class="text-sm text-gray-600">Programme apps</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Users</h3>
                        <div class="space-y-3">
                            @forelse($stats['recent_users'] as $user)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No users yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Jobs -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Jobs</h3>
                        <div class="space-y-3">
                            @forelse($stats['recent_jobs'] as $job)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $job->title }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $job->company }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No jobs yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
