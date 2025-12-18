<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Programme Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if($applications->count() > 0)
                        <div class="space-y-4">
                            @foreach($applications as $application)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            @if($application->banner->image)
                                                <img src="{{ asset('storage/' . $application->banner->image) }}" alt="{{ $application->banner->title }}" class="w-20 h-20 object-cover rounded-lg">
                                            @else
                                                <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $application->banner->title }}</h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($application->banner->description, 100) }}</p>
                                                <div class="flex items-center gap-3 mt-2">
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                                        @if($application->banner->type === 'training') bg-green-100 text-green-800
                                                        @elseif($application->banner->type === 'event') bg-purple-100 text-purple-800
                                                        @elseif($application->banner->type === 'workshop') bg-blue-100 text-blue-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ ucfirst($application->banner->type) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">Applied {{ $application->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($application->status === 'pending')
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Pending
                                                </span>
                                            @elseif($application->status === 'approved')
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Approved
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Rejected
                                                </span>
                                            @endif
                                            @if($application->reviewed_at)
                                                <p class="text-xs text-gray-500 mt-2">Reviewed {{ $application->reviewed_at->diffForHumans() }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($application->admin_notes && $application->status !== 'pending')
                                        <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <p class="text-sm text-gray-600 dark:text-gray-300"><span class="font-medium">Feedback:</span> {{ $application->admin_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if($applications->hasPages())
                            <div class="mt-6">
                                {{ $applications->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No applications yet</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">You haven't applied to any programmes yet. Check out our featured programmes on the homepage!</p>
                            <a href="{{ route('welcome') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
                                Browse Programmes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
