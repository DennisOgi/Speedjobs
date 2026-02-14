<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('workshops.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Workshop Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Banner Image -->
                <div class="relative h-64 md:h-80">
                    <img src="{{ $workshop->banner_url }}" alt="{{ $workshop->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    
                    <!-- Badges -->
                    <div class="absolute top-6 left-6 flex gap-3">
                        @if($workshop->is_free)
                            <span class="px-4 py-2 bg-green-500 text-white text-sm font-bold rounded-full shadow-lg">FREE</span>
                        @else
                            <span class="px-4 py-2 bg-primary-500 text-white text-sm font-bold rounded-full shadow-lg">₦{{ number_format($workshop->price) }}</span>
                        @endif
                        @if($workshop->is_sold_out)
                            <span class="px-4 py-2 bg-red-500 text-white text-sm font-bold rounded-full shadow-lg">SOLD OUT</span>
                        @endif
                    </div>

                    <!-- Title Overlay -->
                    <div class="absolute bottom-6 left-6 right-6">
                        <h1 class="text-2xl md:text-4xl font-bold text-white mb-2">{{ $workshop->title }}</h1>
                        @if($workshop->instructor)
                            <p class="text-white/80">by {{ $workshop->instructor }}</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <!-- Meta Info Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                            <svg class="w-6 h-6 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Date</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $workshop->start_date->format('M d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                            <svg class="w-6 h-6 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Time</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $workshop->start_date->format('h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                            <svg class="w-6 h-6 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Location</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $workshop->location ?? 'TBA' }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                            <svg class="w-6 h-6 mx-auto text-primary-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Spots</p>
                            @if($workshop->max_participants)
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $workshop->available_spots }} left</p>
                            @else
                                <p class="font-semibold text-gray-900 dark:text-white">Unlimited</p>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">About This Workshop</h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $workshop->description }}</p>
                        </div>
                    </div>

                    <!-- Registration Status / Action -->
                    <div class="border-t dark:border-gray-700 pt-6">
                        @auth
                            @if($isRegistered)
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-green-800 dark:text-green-300">You're Registered!</h3>
                                            <p class="text-green-700 dark:text-green-400 text-sm mt-1">
                                                Status: 
                                                @if($registration->status === 'pending')
                                                    <span class="font-medium">Pending Approval</span>
                                                @elseif($registration->status === 'approved')
                                                    <span class="font-medium">Approved</span>
                                                @else
                                                    <span class="font-medium">{{ ucfirst($registration->status) }}</span>
                                                @endif
                                            </p>
                                            @if($registration->notes)
                                                <p class="text-green-600 dark:text-green-500 text-xs mt-2">
                                                    <span class="font-medium">Your message:</span> {{ Str::limit($registration->notes, 100) }}
                                                </p>
                                            @endif
                                            <p class="text-green-600 dark:text-green-500 text-xs mt-2">Registered on {{ $registration->created_at->format('M d, Y') }}</p>
                                        </div>
                                        @if($registration->status !== 'cancelled')
                                            <form action="{{ route('workshops.cancel', $workshop) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your registration?');">
                                                @csrf
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Cancel Registration</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400">Ready to join this workshop?</p>
                                        @if($workshop->is_free)
                                            <p class="text-2xl font-bold text-green-600">Free</p>
                                        @else
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">₦{{ number_format($workshop->price) }}</p>
                                        @endif
                                    </div>
                                    @if($workshop->is_sold_out)
                                        <button disabled class="px-8 py-3 bg-gray-400 text-white rounded-xl font-bold cursor-not-allowed">
                                            Sold Out
                                        </button>
                                    @else
                                        <button onclick="document.getElementById('registration-modal').showModal()" class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold shadow-lg shadow-primary-500/30 transition transform hover:-translate-y-0.5">
                                            Apply Now
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Ready to join this workshop?</p>
                                    @if($workshop->is_free)
                                        <p class="text-2xl font-bold text-green-600">Free</p>
                                    @else
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">₦{{ number_format($workshop->price) }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('login') }}" class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold shadow-lg shadow-primary-500/30 transition transform hover:-translate-y-0.5">
                                    Login to Apply
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    @auth
        @if(!$isRegistered && !$workshop->is_sold_out)
        <dialog id="registration-modal" class="rounded-2xl shadow-2xl backdrop:bg-black/50 p-0 max-w-md w-full">
            <div class="bg-white dark:bg-gray-800 rounded-2xl">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Apply for Workshop</h3>
                        <button onclick="document.getElementById('registration-modal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $workshop->title }}</h4>
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <p><span class="font-medium">Date:</span> {{ $workshop->start_date->format('M d, Y') }}</p>
                            <p><span class="font-medium">Time:</span> {{ $workshop->start_date->format('h:i A') }}</p>
                            @if($workshop->location)
                                <p><span class="font-medium">Location:</span> {{ $workshop->location }}</p>
                            @endif
                            @if(!$workshop->is_free)
                                <p><span class="font-medium">Price:</span> ₦{{ number_format($workshop->price) }}</p>
                            @else
                                <p class="text-green-600 dark:text-green-400 font-semibold">Free Workshop</p>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('workshops.register', $workshop) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Why do you want to attend this workshop? (Optional)
                            </label>
                            <textarea name="reason" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Share your motivation and what you hope to learn..."></textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">This helps us understand your goals and tailor the workshop experience.</p>
                        </div>

                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                <span class="font-semibold">Note:</span> Your registration will be pending approval. You'll receive a confirmation email once approved.
                            </p>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="document.getElementById('registration-modal').close()" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg transition shadow-lg shadow-primary-500/30">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </dialog>
        @endif
    @endauth
</x-app-layout>
