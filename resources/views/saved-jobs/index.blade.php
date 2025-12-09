<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-heading font-bold text-gray-900">Saved Jobs</h1>
                <p class="text-gray-600 mt-2">Jobs you've saved for later</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Saved Jobs List -->
            <div class="space-y-5">
                @forelse($savedJobs as $savedJob)
                    <div class="group bg-white/90 backdrop-blur-sm rounded-2xl shadow-sm hover:shadow-xl border border-white/20 p-6 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Company Logo Placeholder -->
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl flex items-center justify-center text-2xl font-bold text-gray-400 shrink-0 shadow-inner border border-gray-100 group-hover:scale-105 transition-transform duration-300">
                                {{ substr($savedJob->job->company, 0, 1) }}
                            </div>

                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
                                    <div>
                                        <h3 class="text-xl font-heading font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                                            <a href="{{ route('jobs.show', $savedJob->job) }}" class="focus:outline-none">
                                                {{ $savedJob->job->title }}
                                            </a>
                                        </h3>
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2 text-sm text-gray-500">
                                            <span class="font-medium text-gray-900 flex items-center gap-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                {{ $savedJob->job->company }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $savedJob->job->location }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary-50 text-primary-700 border border-primary-100">
                                            {{ $savedJob->job->type }}
                                        </span>
                                        <span class="text-sm font-bold text-gray-900">{{ $savedJob->job->salary_range }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                                    <div class="flex gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                            {{ $savedJob->job->category }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                            Saved {{ $savedJob->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('jobs.unsave', $savedJob->job) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Remove
                                            </button>
                                        </form>
                                        <a href="{{ route('jobs.show', $savedJob->job) }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1">
                                            View Job <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white/80 backdrop-blur-lg rounded-2xl border border-white/20 shadow-sm">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No saved jobs</h3>
                        <p class="text-gray-500 mb-6">Save jobs you're interested in to view them later.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            Browse Jobs
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($savedJobs->hasPages())
                <div class="mt-8">
                    {{ $savedJobs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
