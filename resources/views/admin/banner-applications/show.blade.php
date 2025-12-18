<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Application Details') }}
            </h2>
            <a href="{{ route('admin.banner-applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Applications
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Application Status Banner -->
            <div class="mb-6 p-4 rounded-lg @if($application->status === 'pending') bg-yellow-50 border border-yellow-200 @elseif($application->status === 'approved') bg-green-50 border border-green-200 @else bg-red-50 border border-red-200 @endif">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        @if($application->status === 'pending')
                            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold text-yellow-800">Pending Review</span>
                        @elseif($application->status === 'approved')
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold text-green-800">Approved</span>
                        @else
                            <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold text-red-800">Rejected</span>
                        @endif
                    </div>
                    @if($application->reviewed_at)
                        <span class="text-sm text-gray-600">Reviewed {{ $application->reviewed_at->diffForHumans() }} by {{ $application->reviewer?->name ?? 'Unknown' }}</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Applicant Info -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Applicant Information</h3>
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                {{ strtoupper(substr($application->user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $application->user->name }}</p>
                                <p class="text-gray-600 dark:text-gray-400">{{ $application->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            @if($application->user->phone)
                                <p><span class="font-medium text-gray-700 dark:text-gray-300">Phone:</span> {{ $application->user->phone }}</p>
                            @endif
                            @if($application->user->location)
                                <p><span class="font-medium text-gray-700 dark:text-gray-300">Location:</span> {{ $application->user->location }}</p>
                            @endif
                            @if($application->user->university)
                                <p><span class="font-medium text-gray-700 dark:text-gray-300">University:</span> {{ $application->user->university }}</p>
                            @endif
                            @if($application->user->field_of_study)
                                <p><span class="font-medium text-gray-700 dark:text-gray-300">Field of Study:</span> {{ $application->user->field_of_study }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Programme Info -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Programme Details</h3>
                        @if($application->banner->image)
                            <img src="{{ asset('storage/' . $application->banner->image) }}" alt="{{ $application->banner->title }}" class="w-full h-32 object-cover rounded-lg mb-4">
                        @endif
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $application->banner->title }}</p>
                        <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full
                            @if($application->banner->type === 'training') bg-green-100 text-green-800
                            @elseif($application->banner->type === 'event') bg-purple-100 text-purple-800
                            @elseif($application->banner->type === 'workshop') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($application->banner->type) }}
                        </span>
                        <p class="mt-3 text-gray-600 dark:text-gray-400">{{ $application->banner->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Cover Letter -->
            @if($application->cover_letter)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Cover Letter / Message</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Resume -->
            @if($application->resume_path)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Attached Resume</h3>
                        <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Resume
                        </a>
                    </div>
                </div>
            @endif

            <!-- Admin Notes -->
            @if($application->admin_notes)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Admin Notes</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $application->admin_notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            @if($application->status === 'pending')
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Take Action</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form action="{{ route('admin.banner-applications.approve', $application) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Notes (Optional)</label>
                                    <textarea name="admin_notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Add notes for approval..."></textarea>
                                </div>
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Approve Application
                                </button>
                            </form>
                            <form action="{{ route('admin.banner-applications.reject', $application) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rejection Reason (Optional)</label>
                                    <textarea name="admin_notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Add reason for rejection..."></textarea>
                                </div>
                                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 transition font-semibold">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Reject Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
