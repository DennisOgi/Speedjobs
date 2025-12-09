<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-heading font-bold text-gray-900">My Applications</h1>
                <p class="text-gray-600 mt-2">Track the status of your job applications</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Applications List -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                @forelse($applications as $application)
                    <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50/50 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <!-- Company Initial -->
                                <div class="w-14 h-14 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl flex items-center justify-center text-xl font-bold text-gray-400 shrink-0 shadow-inner border border-gray-100">
                                    {{ substr($application->job->company, 0, 1) }}
                                </div>
                                
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        <a href="{{ route('jobs.show', $application->job) }}" class="hover:text-primary-600 transition-colors">
                                            {{ $application->job->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm">{{ $application->job->company }} • {{ $application->job->location }}</p>
                                    <p class="text-gray-500 text-xs mt-1">Applied {{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <!-- Status Badge -->
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold 
                                    @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($application->status === 'shortlisted') bg-purple-100 text-purple-800
                                    @elseif($application->status === 'interviewed') bg-indigo-100 text-indigo-800
                                    @elseif($application->status === 'offered') bg-green-100 text-green-800
                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>

                                @if($application->status === 'pending')
                                    <form action="{{ route('applications.withdraw', $application) }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw this application?')">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">
                                            Withdraw
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        @if($application->cover_letter)
                            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $application->cover_letter }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No applications yet</h3>
                        <p class="text-gray-500 mb-6">Start applying to jobs to track your applications here.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            Browse Jobs
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($applications->hasPages())
                <div class="mt-8">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
