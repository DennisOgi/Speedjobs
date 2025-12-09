<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-gray-900">
                        @if($job)
                            Applicants for {{ $job->title }}
                        @else
                            All Applicants
                        @endif
                    </h1>
                    <p class="text-gray-600 mt-1">Review and manage job applications</p>
                </div>
                <a href="{{ route('employer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 shadow-sm transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Applications List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @forelse($applications as $application)
                    <div class="p-6 border-b border-gray-100 last:border-b-0">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- Applicant Info -->
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center text-primary-700 font-bold text-xl shrink-0">
                                    {{ substr($application->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $application->user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                                    <div class="flex flex-wrap items-center gap-3 mt-2 text-sm">
                                        @if($application->user->location)
                                            <span class="text-gray-500 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $application->user->location }}
                                            </span>
                                        @endif
                                        @if($application->user->experience_level)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-medium">
                                                {{ ucfirst(str_replace('_', ' ', $application->user->experience_level)) }}
                                            </span>
                                        @endif
                                    </div>
                                    @if(!$job)
                                        <p class="text-sm text-primary-600 mt-2">
                                            Applied for: <a href="{{ route('jobs.show', $application->job) }}" class="font-medium hover:underline">{{ $application->job->title }}</a>
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">Applied {{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Actions -->
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

                                <!-- Status Update Dropdown -->
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                        Update Status
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10">
                                        @foreach(['pending', 'reviewed', 'shortlisted', 'interviewed', 'offered', 'rejected'] as $status)
                                            <form action="{{ route('employer.applications.status', $application) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ $status }}">
                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 {{ $application->status === $status ? 'text-primary-600 font-medium' : 'text-gray-700' }}">
                                                    {{ ucfirst($status) }}
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        @if($application->cover_letter)
                            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm font-medium text-gray-700 mb-2">Cover Letter:</p>
                                <p class="text-sm text-gray-600">{{ $application->cover_letter }}</p>
                            </div>
                        @endif

                        <!-- Skills -->
                        @if($application->user->skills)
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Skills:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $application->user->skills) as $skill)
                                        <span class="px-2 py-1 bg-primary-50 text-primary-700 rounded text-xs font-medium">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No applications yet</h3>
                        <p class="text-gray-500 mb-6">Applications will appear here when candidates apply to your jobs.</p>
                        <a href="{{ route('employer.jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            View Your Jobs
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
