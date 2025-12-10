@props(['workshops'])

@if($workshops->count() > 0)
<div class="py-8 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-primary-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-primary-600/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Sponsored Workshops</h3>
                    <p class="text-sm text-gray-400">Upgrade your skills with expert-led training</p>
                </div>
            </div>
            <a href="{{ route('workshops.index') }}" class="hidden sm:inline-flex items-center gap-2 text-sm text-primary-400 hover:text-primary-300 font-medium transition-colors">
                View All
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Slider Container -->
        <div x-data="{
            currentSlide: 0,
            totalSlides: {{ $workshops->count() }},
            autoplay: null,
            init() {
                this.startAutoplay();
            },
            startAutoplay() {
                this.autoplay = setInterval(() => {
                    this.next();
                }, 6000);
            },
            stopAutoplay() {
                clearInterval(this.autoplay);
            },
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            },
            goTo(index) {
                this.currentSlide = index;
                this.stopAutoplay();
                this.startAutoplay();
            }
        }" class="relative" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
            
            <!-- Slides -->
            <div class="relative overflow-hidden rounded-2xl">
                <div class="flex transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (currentSlide * 100) + '%)'">
                    @foreach($workshops as $index => $workshop)
                    <div class="w-full flex-shrink-0">
                        <div class="relative h-64 md:h-80 rounded-2xl overflow-hidden group">
                            <!-- Background Image -->
                            <img src="{{ $workshop->banner_url }}" 
                                 alt="{{ $workshop->title }}" 
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/80 to-transparent"></div>
                            
                            <!-- Content -->
                            <div class="relative h-full flex items-center p-6 md:p-10">
                                <div class="max-w-xl space-y-4">
                                    <!-- Badge -->
                                    <div class="flex items-center gap-3">
                                        @if($workshop->is_free)
                                            <span class="px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">FREE</span>
                                        @else
                                            <span class="px-3 py-1 bg-primary-500/20 text-primary-400 text-xs font-bold rounded-full border border-primary-500/30">₦{{ number_format($workshop->price) }}</span>
                                        @endif
                                        <span class="px-3 py-1 bg-white/10 text-gray-300 text-xs font-medium rounded-full">
                                            {{ $workshop->start_date->format('M d, Y') }}
                                        </span>
                                        @if($workshop->location)
                                            <span class="hidden md:inline-flex items-center gap-1 px-3 py-1 bg-white/10 text-gray-300 text-xs font-medium rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                </svg>
                                                {{ $workshop->location }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Title -->
                                    <h4 class="text-2xl md:text-3xl font-bold text-white leading-tight">{{ $workshop->title }}</h4>
                                    
                                    <!-- Description -->
                                    <p class="text-gray-300 text-sm md:text-base line-clamp-2">{{ Str::limit($workshop->description, 120) }}</p>
                                    
                                    <!-- Instructor & CTA -->
                                    <div class="flex items-center gap-4 pt-2">
                                        @if($workshop->instructor)
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                    {{ strtoupper(substr($workshop->instructor, 0, 1)) }}
                                                </div>
                                                <span class="text-sm text-gray-400">by {{ $workshop->instructor }}</span>
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('workshops.register', $workshop) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                                Apply Now
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Spots Left -->
                                    @if($workshop->max_participants)
                                        <div class="flex items-center gap-2 text-xs">
                                            @if($workshop->is_sold_out)
                                                <span class="text-red-400">Sold Out</span>
                                            @else
                                                <span class="text-gray-400">{{ $workshop->available_spots }} spots left</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrows -->
            @if($workshops->count() > 1)
                <button @click="prev()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center transition-all z-10 border border-white/10">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="next()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center transition-all z-10 border border-white/10">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots -->
                <div class="flex justify-center gap-2 mt-4">
                    @foreach($workshops as $index => $workshop)
                        <button @click="goTo({{ $index }})" 
                                :class="currentSlide === {{ $index }} ? 'bg-primary-500 w-8' : 'bg-white/20 w-2 hover:bg-white/40'"
                                class="h-2 rounded-full transition-all duration-300">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Mobile View All Link -->
        <div class="sm:hidden text-center mt-4">
            <a href="{{ route('workshops.index') }}" class="inline-flex items-center gap-2 text-sm text-primary-400 hover:text-primary-300 font-medium transition-colors">
                View All Workshops
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endif
