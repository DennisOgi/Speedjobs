<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Workshops & Training') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Upgrade Your Skills</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Join expert-led workshops and training sessions designed to accelerate your career growth.</p>
            </div>

            <!-- Workshops Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($workshops as $workshop)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                        <!-- Banner Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $workshop->banner_url }}" alt="{{ $workshop->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                @if($workshop->is_free)
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">FREE</span>
                                @else
                                    <span class="px-3 py-1 bg-primary-500 text-white text-xs font-bold rounded-full">₦{{ number_format($workshop->price) }}</span>
                                @endif
                            </div>
                            
                            <!-- Date Badge -->
                            <div class="absolute bottom-4 left-4">
                                <span class="px-3 py-1 bg-white/90 text-gray-800 text-xs font-medium rounded-full">
                                    {{ $workshop->start_date->format('M d, Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $workshop->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $workshop->description }}</p>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                @if($workshop->instructor)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $workshop->instructor }}
                                    </div>
                                @endif
                                @if($workshop->location)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        {{ $workshop->location }}
                                    </div>
                                @endif
                            </div>

                            <!-- Spots Left -->
                            @if($workshop->max_participants)
                                <div class="mb-4">
                                    @if($workshop->is_sold_out)
                                        <span class="text-sm text-red-500 font-medium">Sold Out</span>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-primary-500 rounded-full" style="width: {{ (($workshop->max_participants - $workshop->available_spots) / $workshop->max_participants) * 100 }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $workshop->available_spots }} spots left</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('workshops.show', $workshop) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 dark:text-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm font-medium">
                                    View Details
                                </a>
                                @if(!$workshop->is_sold_out)
                                    <form action="{{ route('workshops.register', $workshop) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition text-sm font-medium">
                                            Apply Now
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900 dark:text-white">No Workshops Available</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">Check back soon for upcoming workshops and training sessions.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($workshops->hasPages())
                <div class="mt-8">
                    {{ $workshops->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
