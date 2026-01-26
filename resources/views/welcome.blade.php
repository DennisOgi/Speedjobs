<x-app-layout>
    <!-- Splash Screen -->
    <div x-data="{ showSplash: true, splashPhase: 1 }" 
         x-init="
            setTimeout(() => splashPhase = 2, 800);
            setTimeout(() => splashPhase = 3, 1600);
            setTimeout(() => showSplash = false, 2400);
         "
         x-cloak>
        
        <!-- Splash Overlay -->
        <div x-show="showSplash" 
             x-transition:leave="transition-all duration-700 ease-in-out"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-110"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 overflow-hidden">
            
            <!-- Splash Background Effects -->
            <div class="absolute inset-0 overflow-hidden">
                <!-- Animated Gradient Orbs - Darker to match hero -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-600/15 rounded-full blur-[150px] animate-pulse"></div>
                <div :class="splashPhase >= 2 ? 'scale-100 opacity-100' : 'scale-50 opacity-0'" 
                     class="absolute top-1/4 -left-20 w-96 h-96 bg-primary-700/20 rounded-full blur-[120px] transition-all duration-1000"></div>
                <div :class="splashPhase >= 2 ? 'scale-100 opacity-100' : 'scale-50 opacity-0'" 
                     class="absolute bottom-1/4 right-0 w-[500px] h-[500px] bg-primary-600/15 rounded-full blur-[150px] transition-all duration-1000 delay-200"></div>
                
                <!-- Grid Pattern -->
                <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]"></div>
                
                <!-- Radiating Lines -->
                <div :class="splashPhase >= 2 ? 'opacity-30 rotate-180' : 'opacity-0 rotate-0'" 
                     class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] transition-all duration-[2000ms] ease-out">
                    <div class="absolute inset-0 border border-primary-500/10 rounded-full"></div>
                    <div class="absolute inset-8 border border-primary-500/10 rounded-full"></div>
                    <div class="absolute inset-16 border border-primary-500/10 rounded-full"></div>
                    <div class="absolute inset-24 border border-primary-500/10 rounded-full"></div>
                </div>
            </div>
            
            <!-- Logo Container -->
            <div class="relative z-10 text-center">
                <!-- Logo with Animation -->
                <div :class="splashPhase >= 1 ? 'scale-100 opacity-100' : 'scale-75 opacity-0'" 
                     class="transition-all duration-700 ease-out">
                    <!-- Actual Logo Image -->
                    <div class="relative inline-block mb-8">
                        <div :class="splashPhase >= 2 ? 'scale-100 opacity-100' : 'scale-0 opacity-0'" 
                             class="absolute -inset-8 bg-primary-500/20 rounded-full blur-2xl transition-all duration-700"></div>
                        <img src="{{ asset('assets/images/logo.png') }}" 
                             alt="SpeedJobs Africa" 
                             class="h-24 md:h-32 lg:h-40 w-auto relative z-10 drop-shadow-2xl"
                             :class="splashPhase >= 1 ? 'scale-100' : 'scale-90'">
                    </div>
                    
                    <!-- Tagline -->
                    <div :class="splashPhase >= 2 ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'" 
                         class="transition-all duration-700 delay-200">
                        <p class="text-gray-300 text-lg md:text-xl font-medium">Connecting People, Skills & Opportunity</p>
                    </div>
                    
                    <!-- Loading Indicator -->
                    <div :class="splashPhase >= 3 ? 'opacity-100' : 'opacity-0'" 
                         class="transition-opacity duration-500 delay-300 mt-10">
                        <div class="flex items-center justify-center gap-1.5">
                            <div class="w-2.5 h-2.5 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                            <div class="w-2.5 h-2.5 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                            <div class="w-2.5 h-2.5 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Floating Elements that transition to hero -->
            <div :class="splashPhase >= 3 ? 'opacity-100' : 'opacity-0'" 
                 class="absolute inset-0 pointer-events-none transition-opacity duration-700">
                <div class="absolute top-20 left-[10%] w-2 h-2 bg-primary-400 rounded-full animate-float opacity-60"></div>
                <div class="absolute top-40 right-[20%] w-3 h-3 bg-primary-300 rounded-full animate-float animation-delay-1000 opacity-40"></div>
                <div class="absolute bottom-32 left-[30%] w-2 h-2 bg-white rounded-full animate-float animation-delay-2000 opacity-30"></div>
            </div>
        </div>
    </div>

    <!-- Hero Section - Enhanced -->
    <div class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient Orbs - Darker, more subtle -->
            <div class="absolute top-1/4 -left-20 w-[500px] h-[500px] bg-primary-600/20 rounded-full blur-[150px] animate-pulse"></div>
            <div class="absolute bottom-1/4 right-0 w-[600px] h-[600px] bg-primary-700/15 rounded-full blur-[180px] animate-pulse animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-800/10 rounded-full blur-[200px]"></div>
            
            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:80px_80px]"></div>
            
            </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-24 md:pt-28 pb-12 md:pb-16">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left space-y-6 md:space-y-8">
                    <!-- Badge - Enhanced -->
                    <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-full bg-white/5 backdrop-blur-xl border border-white/10 animate-fade-in-up shadow-lg shadow-black/10">
                        <span class="text-sm font-medium text-gray-300">{{ __('content.brand.secondary_tagline') }} • Powering Africa's Future</span>
                    </div>
                    
                    <!-- Headline - Enhanced typography -->
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-6xl xl:text-7xl font-heading font-black text-white leading-[1.05] tracking-tight animate-fade-in-up animation-delay-100">
                        Find your dream job.
                        <br class="hidden sm:block"><span class="sm:hidden"> </span>
                        <span class="relative inline-block">
                            <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-primary-400 via-emerald-400 to-primary-400 bg-[length:200%_auto] animate-gradient">Build a career.</span>
                            <svg class="absolute -bottom-1 md:-bottom-2 left-0 w-full h-3 md:h-4 text-primary-500/40" viewBox="0 0 200 12" preserveAspectRatio="none">
                                <path d="M0,8 Q50,0 100,8 T200,8" stroke="currentColor" stroke-width="3" fill="none" class="animate-draw-line"/>
                            </svg>
                        </span>
                    </h1>
                    
                    <!-- Subheadline -->
                    <p class="text-base md:text-lg lg:text-xl text-gray-400 max-w-xl mx-auto lg:mx-0 leading-relaxed animate-fade-in-up animation-delay-200">
                        {{ __('content.home.hero.subheadline') }}
                    </p>
                    
                    <!-- Search Bar - Enhanced -->
                    <div class="animate-fade-in-up animation-delay-300">
                        <form action="{{ route('jobs.index') }}" method="GET" class="relative">
                            <div class="flex flex-col sm:flex-row gap-2 p-1.5 sm:p-2 bg-white/[0.07] backdrop-blur-2xl rounded-xl border border-white/10 shadow-xl shadow-black/20">
                                <div class="flex-1 flex items-center gap-2 px-3 py-2.5 sm:py-2.5 bg-white/[0.05] rounded-lg hover:bg-white/[0.08] transition-colors">
                                    <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <input type="text" name="search" placeholder="Job title, keywords..." class="w-full bg-transparent border-none focus:ring-0 text-white placeholder-gray-500 text-sm p-0">
                                </div>
                                <div class="flex-1 flex items-center gap-2 px-3 py-2.5 sm:py-2.5 bg-white/[0.05] rounded-lg hover:bg-white/[0.08] transition-colors">
                                    <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <input type="text" name="location" placeholder="Lagos, Nairobi..." class="w-full bg-transparent border-none focus:ring-0 text-white placeholder-gray-500 text-sm p-0">
                                </div>
                                <button type="submit" class="px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 text-white font-bold text-sm rounded-lg shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all transform hover:-translate-y-0.5 hover:scale-[1.02] whitespace-nowrap">
                                    Search Jobs
                                </button>
                            </div>
                        </form>
                        
                        <!-- Popular Searches -->
                        <div class="flex flex-col sm:flex-row gap-3 mt-5 justify-center lg:justify-start">
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-slate-900 font-bold text-sm rounded-lg shadow-lg hover:bg-gray-100 transition-all">
                                {{ __('content.home.hero.cta_primary') }}
                            </a>
                            <a href="{{ route('browse-candidates') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white/10 text-white font-bold text-sm rounded-lg border border-white/20 hover:bg-white/15 transition-all">
                                {{ __('content.home.hero.cta_secondary') }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- Stats Row - Enhanced with icons -->
                    <div class="grid grid-cols-3 gap-4 md:gap-6 pt-6 md:pt-8 border-t border-white/10 animate-fade-in-up animation-delay-400">
                        <div class="text-center lg:text-left group cursor-default">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white group-hover:text-primary-400 transition-colors">10K+</div>
                            <div class="text-xs sm:text-sm text-gray-500 mt-1">Active Jobs</div>
                        </div>
                        <div class="text-center lg:text-left group cursor-default">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white group-hover:text-primary-400 transition-colors">50K+</div>
                            <div class="text-xs sm:text-sm text-gray-500 mt-1">Job Seekers</div>
                        </div>
                        <div class="text-center lg:text-left group cursor-default">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white group-hover:text-primary-400 transition-colors">2K+</div>
                            <div class="text-xs sm:text-sm text-gray-500 mt-1">Companies</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Premium Featured Banner -->
                <div class="hidden lg:block relative animate-fade-in-up animation-delay-500" x-data="{
                    currentBanner: 0,
                    bannerCount: {{ $banners->count() }},
                    autoplay: null,
                    init() {
                        if (this.bannerCount > 1) {
                            this.autoplay = setInterval(() => this.next(), 5000);
                        }
                    },
                    next() {
                        this.currentBanner = (this.currentBanner + 1) % this.bannerCount;
                    },
                    prev() {
                        this.currentBanner = (this.currentBanner - 1 + this.bannerCount) % this.bannerCount;
                    },
                    goTo(index) {
                        this.currentBanner = index;
                    }
                }">
                    <!-- Decorative Glow Effects -->
                    <div class="absolute -inset-8 opacity-60 blur-3xl pointer-events-none">
                        <div class="absolute top-0 right-0 w-72 h-72 bg-primary-500/30 rounded-full"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/20 rounded-full"></div>
                    </div>
                    
                    <!-- Floating Decorative Elements -->
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-primary-400/20 to-emerald-400/20 rounded-2xl rotate-12 backdrop-blur-sm border border-white/10"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-gradient-to-br from-amber-400/20 to-orange-400/20 rounded-xl -rotate-12 backdrop-blur-sm border border-white/10"></div>
                    
                    @if($banners->count() > 0)
                    <div class="relative">
                        <!-- Section Label -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-primary-500/30">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-sm">Featured Programmes</h3>
                                    <p class="text-gray-400 text-xs">Empowering your career journey</p>
                                </div>
                            </div>
                            @if($banners->count() > 1)
                            <div class="flex gap-2">
                                <button @click="prev()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all border border-white/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <button @click="next()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all border border-white/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Banner Carousel -->
                        <div class="relative h-[400px] xl:h-[440px]">
                            @foreach($banners as $index => $banner)
                                <div x-show="currentBanner === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-500"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-300"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute inset-0 group"
                                     x-cloak>
                                    
                                    <!-- Main Card -->
                                    <div class="relative h-full rounded-3xl overflow-hidden border border-white/20 shadow-2xl shadow-black/50 
                                        @if($banner->type === 'training') bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800
                                        @elseif($banner->type === 'event') bg-gradient-to-br from-violet-600 via-violet-700 to-purple-800
                                        @elseif($banner->type === 'workshop') bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800
                                        @else bg-gradient-to-br from-slate-600 via-slate-700 to-slate-800
                                        @endif">
                                        
                                        <!-- Background Pattern -->
                                        <div class="absolute inset-0 opacity-10">
                                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                                <defs>
                                                    <pattern id="hero-grid-{{ $index }}" width="10" height="10" patternUnits="userSpaceOnUse">
                                                        <circle cx="1" cy="1" r="0.5" fill="currentColor"/>
                                                    </pattern>
                                                </defs>
                                                <rect width="100" height="100" fill="url(#hero-grid-{{ $index }})"/>
                                            </svg>
                                        </div>
                                        
                                        <!-- Image Section (Top Half) -->
                                        @if($banner->image)
                                        <div class="relative h-[55%] overflow-hidden">
                                            <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                            
                                            <!-- Type Badge (Floating on Image) -->
                                            <div class="absolute top-4 left-4 flex items-center gap-2">
                                                <span class="px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wider shadow-lg
                                                    @if($banner->type === 'training') text-emerald-700
                                                    @elseif($banner->type === 'event') text-violet-700
                                                    @elseif($banner->type === 'workshop') text-blue-700
                                                    @else text-slate-700
                                                    @endif">
                                                    <span class="flex items-center gap-1.5">
                                                        <span class="w-1.5 h-1.5 rounded-full animate-pulse
                                                            @if($banner->type === 'training') bg-emerald-500
                                                            @elseif($banner->type === 'event') bg-violet-500
                                                            @elseif($banner->type === 'workshop') bg-blue-500
                                                            @else bg-slate-500
                                                            @endif"></span>
                                                        {{ $banner->type }}
                                                    </span>
                                                </span>
                                            </div>
                                            
                                            <!-- Live indicator -->
                                            <div class="absolute top-4 right-4">
                                                <span class="px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-full text-[10px] font-medium text-white flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                                                    Open for Applications
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Content Section (Bottom Half) -->
                                        <div class="relative h-[45%] p-6 flex flex-col">
                                            <!-- Title & Description -->
                                            <div class="flex-1">
                                                <h4 class="font-black text-white text-xl xl:text-2xl leading-tight mb-2 line-clamp-2">{{ $banner->title }}</h4>
                                                <p class="text-white/70 text-sm leading-relaxed line-clamp-2">{{ Str::limit($banner->description, 100) }}</p>
                                            </div>
                                            
                                            <!-- Action Row -->
                                            <div class="flex items-center justify-between pt-4 border-t border-white/10">
                                                @auth
                                                    @php
                                                        $hasApplied = \App\Models\BannerApplication::where('banner_id', $banner->id)->where('user_id', auth()->id())->exists();
                                                    @endphp
                                                    @if($hasApplied)
                                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 text-white text-sm font-semibold rounded-xl backdrop-blur-sm">
                                                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            Applied Successfully
                                                        </span>
                                                    @else
                                                        <button onclick="document.getElementById('hero-apply-modal-{{ $banner->id }}').showModal()" 
                                                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-900 text-sm font-bold rounded-xl hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                            Apply Now
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                        </button>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-900 text-sm font-bold rounded-xl hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                        Login to Apply
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                    </a>
                                                @endauth
                                                
                                                <!-- Navigation Dots -->
                                                @if($banners->count() > 1)
                                                <div class="flex items-center gap-2">
                                                    <span class="text-white/50 text-xs font-medium" x-text="(currentBanner + 1) + '/' + bannerCount"></span>
                                                    <div class="flex gap-1.5">
                                                        @foreach($banners as $dotIndex => $dotBanner)
                                                            <button @click="goTo({{ $dotIndex }})" 
                                                                    :class="currentBanner === {{ $dotIndex }} ? 'bg-white w-6' : 'bg-white/30 w-2 hover:bg-white/50'"
                                                                    class="h-2 rounded-full transition-all duration-300">
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Bottom Stats -->
                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10 text-center">
                                <div class="text-white font-bold text-lg">{{ $banners->count() }}+</div>
                                <div class="text-gray-400 text-xs">Programmes</div>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10 text-center">
                                <div class="text-white font-bold text-lg">500+</div>
                                <div class="text-gray-400 text-xs">Enrolled</div>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10 text-center">
                                <div class="text-white font-bold text-lg">98%</div>
                                <div class="text-gray-400 text-xs">Success Rate</div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Fallback when no banners -->
                    <div class="relative bg-gradient-to-br from-slate-800/80 to-slate-900/80 backdrop-blur-xl rounded-3xl p-8 border border-white/10 text-center">
                        <div class="w-16 h-16 bg-primary-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-xl mb-2">Career Opportunities</h3>
                        <p class="text-gray-400 text-sm mb-4">Explore training programmes and career development opportunities</p>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-bold rounded-xl transition-all">
                            Browse Jobs
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Hero Apply Modals -->
                @auth
                    @foreach($banners as $banner)
                        <dialog id="hero-apply-modal-{{ $banner->id }}" class="rounded-2xl shadow-2xl backdrop:bg-black/50 p-0 max-w-md w-full">
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-gray-900">Apply to {{ Str::limit($banner->title, 30) }}</h3>
                                    <button onclick="document.getElementById('hero-apply-modal-{{ $banner->id }}').close()" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <form action="{{ route('banners.apply', $banner) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Why are you interested? (Optional)</label>
                                            <textarea name="cover_letter" rows="3" class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Tell us about yourself..."></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Resume (Optional)</label>
                                            <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                        </div>
                                    </div>
                                    <div class="flex gap-2 mt-4">
                                        <button type="button" onclick="document.getElementById('hero-apply-modal-{{ $banner->id }}').close()" class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Cancel</button>
                                        <button type="submit" class="flex-1 px-3 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                    @endforeach
                @endauth
            </div>
        </div>
        
        </div>

    <!-- Mobile Banner Carousel (visible only on mobile/tablet) -->
    @if($banners->count() > 0)
    <div class="lg:hidden bg-gradient-to-b from-slate-900 to-slate-800 py-8 px-4" x-data="{
        currentBanner: 0,
        bannerCount: {{ $banners->count() }},
        autoplay: null,
        init() {
            if (this.bannerCount > 1) {
                this.autoplay = setInterval(() => this.next(), 5000);
            }
        },
        next() {
            this.currentBanner = (this.currentBanner + 1) % this.bannerCount;
        },
        prev() {
            this.currentBanner = (this.currentBanner - 1 + this.bannerCount) % this.bannerCount;
        },
        goTo(index) {
            this.currentBanner = index;
        }
    }">
        <div class="max-w-lg mx-auto">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white font-bold text-lg">Featured Programmes</h3>
                <span class="text-xs text-gray-400">Swipe to explore</span>
            </div>
            
            <!-- Banner Carousel -->
            <div class="relative h-[280px] sm:h-[260px]">
                @foreach($banners as $index => $banner)
                    <div x-show="currentBanner === {{ $index }}"
                         x-transition:enter="transition ease-out duration-400"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform -translate-x-4"
                         class="absolute inset-0 rounded-2xl overflow-hidden border border-white/10 shadow-xl
                            @if($banner->type === 'training') bg-gradient-to-br from-emerald-600 to-teal-700
                            @elseif($banner->type === 'event') bg-gradient-to-br from-violet-600 to-purple-700
                            @elseif($banner->type === 'workshop') bg-gradient-to-br from-blue-600 to-indigo-700
                            @else bg-gradient-to-br from-slate-600 to-slate-700
                            @endif"
                         x-cloak>
                        
                        <!-- Banner Image (top portion) -->
                        @if($banner->image)
                        <div class="h-[120px] sm:h-[110px] relative">
                            <img src="{{ asset($banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <!-- Type Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-full text-[10px] font-bold text-white uppercase tracking-wider">{{ $banner->type }}</span>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Content -->
                        <div class="p-4 flex flex-col h-[160px] sm:h-[150px]">
                            <h4 class="font-bold text-white text-base leading-tight mb-1.5">{{ $banner->title }}</h4>
                            <p class="text-white/70 text-sm leading-relaxed line-clamp-2 flex-1">{{ Str::limit($banner->description, 80) }}</p>
                            
                            <!-- Action Button + Navigation -->
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-white/10">
                                @auth
                                    @php
                                        $hasApplied = \App\Models\BannerApplication::where('banner_id', $banner->id)->where('user_id', auth()->id())->exists();
                                    @endphp
                                    @if($hasApplied)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 text-white text-xs font-semibold rounded-lg">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Applied
                                        </span>
                                    @else
                                        <button onclick="document.getElementById('mobile-apply-modal-{{ $banner->id }}').showModal()" 
                                                class="px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                                            Apply Now
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                                        Login to Apply
                                    </a>
                                @endauth
                                
                                <!-- Navigation Dots -->
                                @if($banners->count() > 1)
                                <div class="flex gap-1.5">
                                    @foreach($banners as $dotIndex => $dotBanner)
                                        <button @click="goTo({{ $dotIndex }})" 
                                                :class="currentBanner === {{ $dotIndex }} ? 'bg-white w-5' : 'bg-white/30 w-2 hover:bg-white/50'"
                                                class="h-2 rounded-full transition-all duration-300">
                                        </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Navigation Arrows (for touch devices) -->
            @if($banners->count() > 1)
            <div class="flex justify-center gap-4 mt-4">
                <button @click="prev()" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
            @endif
        </div>
        
        <!-- Mobile Apply Modals -->
        @auth
            @foreach($banners as $banner)
                <dialog id="mobile-apply-modal-{{ $banner->id }}" class="rounded-2xl shadow-2xl backdrop:bg-black/50 p-0 max-w-md w-full mx-4">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Apply to {{ Str::limit($banner->title, 25) }}</h3>
                            <button onclick="document.getElementById('mobile-apply-modal-{{ $banner->id }}').close()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <form action="{{ route('banners.apply', $banner) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Why are you interested? (Optional)</label>
                                    <textarea name="cover_letter" rows="3" class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Tell us about yourself..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Resume (Optional)</label>
                                    <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                </div>
                            </div>
                            <div class="flex gap-2 mt-4">
                                <button type="button" onclick="document.getElementById('mobile-apply-modal-{{ $banner->id }}').close()" class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">Cancel</button>
                                <button type="submit" class="flex-1 px-3 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition">Submit</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            @endforeach
        @endauth
    </div>
    @endif

    <!-- Sponsored Workshops Slider -->
    <x-workshop-slider :workshops="$workshops" />

    <!-- Featured Categories - Redesigned -->
    <div class="py-16 md:py-24 bg-gray-50 relative overflow-hidden">
        <!-- Subtle Dot Pattern Background -->
        <div class="absolute inset-0 bg-[radial-gradient(#10b98120_1px,transparent_1px)] bg-[size:20px_20px]"></div>
        <!-- Grid Lines Pattern -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#10b98108_1px,transparent_1px),linear-gradient(to_bottom,#10b98108_1px,transparent_1px)] bg-[size:40px_40px]"></div>
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-40 -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-100 rounded-full blur-3xl opacity-40 translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full mb-4">Browse by Category</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-black text-gray-900 tracking-tight">Explore <span class="text-primary-600">Top Industries</span></h2>
                <p class="mt-4 text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">Find your perfect role in Africa's fastest-growing sectors</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
                @php
                $categories = [
                    ['name' => 'Technology', 'jobs' => '2,450', 'color' => 'from-blue-500 to-indigo-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />'],
                    ['name' => 'Finance', 'jobs' => '1,830', 'color' => 'from-emerald-500 to-teal-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'],
                    ['name' => 'Healthcare', 'jobs' => '1,240', 'color' => 'from-rose-500 to-pink-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />'],
                    ['name' => 'Marketing', 'jobs' => '980', 'color' => 'from-amber-500 to-orange-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />'],
                    ['name' => 'Engineering', 'jobs' => '1,560', 'color' => 'from-violet-500 to-purple-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />'],
                    ['name' => 'Sales', 'jobs' => '890', 'color' => 'from-cyan-500 to-blue-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />'],
                    ['name' => 'Design', 'jobs' => '720', 'color' => 'from-fuchsia-500 to-pink-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />'],
                    ['name' => 'Education', 'jobs' => '650', 'color' => 'from-lime-500 to-green-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />'],
                ];
                @endphp

                @foreach($categories as $category)
                <a href="{{ route('jobs.index', ['category' => $category['name']]) }}" class="group relative bg-white p-6 lg:p-8 rounded-3xl border border-gray-100 hover:border-transparent shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <!-- Gradient Background on Hover -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $category['color'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Content -->
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-gray-100 group-hover:bg-white/20 rounded-2xl flex items-center justify-center mb-5 transition-all duration-500">
                            <svg class="w-7 h-7 text-gray-600 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $category['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-white transition-colors duration-500 mb-2">{{ $category['name'] }}</h3>
                        <p class="text-sm text-gray-500 group-hover:text-white/80 transition-colors duration-500">{{ $category['jobs'] }} jobs available</p>
                    </div>
                    
                    <!-- Arrow Icon -->
                    <div class="absolute bottom-6 right-6 w-10 h-10 bg-gray-100 group-hover:bg-white/20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    View All Categories
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- How It Works - New Section -->
    <div class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full mb-4">Simple Process</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-black text-gray-900 tracking-tight">How It <span class="text-primary-600">Works</span></h2>
                <p class="mt-4 text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">Get started in minutes and land your dream job</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12 relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-24 left-[20%] right-[20%] h-0.5 bg-gradient-to-r from-primary-300 via-primary-400 to-green-400"></div>
                
                <!-- Step 1 -->
                <div class="relative text-center group">
                    <div class="relative z-10 w-16 h-16 md:w-20 md:h-20 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl md:rounded-3xl flex items-center justify-center shadow-xl shadow-primary-500/30 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-black text-white">1</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-3">Create Your Profile</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Sign up and build your professional profile with our easy-to-use resume builder</p>
                </div>
                
                <!-- Step 2 -->
                <div class="relative text-center group">
                    <div class="relative z-10 w-16 h-16 md:w-20 md:h-20 mx-auto mb-6 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl md:rounded-3xl flex items-center justify-center shadow-xl shadow-primary-600/30 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-black text-white">2</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-3">Discover Opportunities</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Browse thousands of jobs from top employers across Africa</p>
                </div>
                
                <!-- Step 3 -->
                <div class="relative text-center group">
                    <div class="relative z-10 w-16 h-16 md:w-20 md:h-20 mx-auto mb-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl md:rounded-3xl flex items-center justify-center shadow-xl shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-black text-white">3</span>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-3">Get Hired</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Apply with one click and track your applications in real-time</p>
                </div>
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 text-white font-bold text-lg rounded-2xl shadow-xl shadow-primary-500/25 hover:shadow-2xl hover:shadow-primary-500/30 transition-all transform hover:-translate-y-1">
                    Get Started Free
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Who We Serve - Redesigned -->
    <div class="py-16 md:py-24 bg-slate-900 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-[120px]"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="inline-block px-4 py-1.5 bg-white/10 text-primary-300 text-sm font-semibold rounded-full mb-4 backdrop-blur-sm">Our Ecosystem</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-black text-white tracking-tight">Who We <span class="text-primary-400">Serve</span></h2>
                <p class="mt-4 text-lg md:text-xl text-gray-400 max-w-2xl mx-auto">Empowering every stakeholder in Africa's talent ecosystem</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <!-- Students -->
                <div class="group p-6 md:p-8 rounded-2xl md:rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-primary-500/50 transition-all duration-500 text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-primary-500/30 mx-auto">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-white mb-2 md:mb-3">{{ __('content.home.who_we_serve.students.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-400 leading-relaxed">{{ __('content.home.who_we_serve.students.desc') }}</p>
                </div>

                <!-- Job Seekers -->
                <div class="group p-6 md:p-8 rounded-2xl md:rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-primary-500/50 transition-all duration-500 text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-primary-600/30 mx-auto">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-white mb-2 md:mb-3">{{ __('content.home.who_we_serve.job_seekers.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-400 leading-relaxed">{{ __('content.home.who_we_serve.job_seekers.desc') }}</p>
                </div>

                <!-- Employers -->
                <div class="group p-6 md:p-8 rounded-2xl md:rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-blue-500/50 transition-all duration-500 text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-500/30 mx-auto">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-white mb-2 md:mb-3">{{ __('content.home.who_we_serve.employers.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-400 leading-relaxed">{{ __('content.home.who_we_serve.employers.desc') }}</p>
                </div>

                <!-- Institutions -->
                <div class="group p-6 md:p-8 rounded-2xl md:rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-purple-500/50 transition-all duration-500 text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-purple-500/30 mx-auto">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-white mb-2 md:mb-3">{{ __('content.home.who_we_serve.institutions.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-400 leading-relaxed">{{ __('content.home.who_we_serve.institutions.desc') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action (Resume Builder) -->
    <div class="py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-[3rem] overflow-hidden shadow-2xl relative group">
                <!-- Animated background effects -->
                <div class="absolute top-0 right-0 -mt-40 -mr-40 w-[40rem] h-[40rem] bg-primary-600/20 rounded-full blur-[100px] transition-transform duration-1000 group-hover:scale-110 animate-blob"></div>
                <div class="absolute bottom-0 left-0 -mb-40 -ml-40 w-[40rem] h-[40rem] bg-accent-500/20 rounded-full blur-[100px] transition-transform duration-1000 group-hover:scale-110 animate-blob animation-delay-2000"></div>
                
                <div class="relative grid md:grid-cols-2 gap-20 items-center p-12 md:p-24">
                    <div class="text-white space-y-10">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-primary-300 text-sm font-medium">
                            <span class="w-2 h-2 rounded-full bg-primary-400 animate-pulse"></span>
                            AI-Powered Resume Builder
                        </div>
                        <h2 class="text-5xl md:text-6xl font-heading font-bold leading-tight tracking-tight">Build a CV that <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-accent-400">wins interviews</span></h2>
                        <p class="text-gray-300 text-xl leading-relaxed font-light max-w-lg">Use our AI-powered resume builder to create a professional, ATS-friendly CV in minutes. Choose from premium templates designed for African professionals.</p>
                        <div class="flex flex-wrap gap-6 pt-4">
                            <a href="{{ route('resume.create') }}" class="px-10 py-5 bg-white text-gray-900 hover:bg-gray-100 font-bold rounded-2xl shadow-lg transition-all transform hover:scale-105 hover:shadow-xl text-lg flex items-center gap-3">
                                Build My CV Now
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                            <a href="{{ route('resume.create') }}" class="px-10 py-5 bg-transparent hover:bg-white/5 text-white font-bold rounded-2xl transition-all border border-white/20 transform hover:scale-105 text-lg backdrop-blur-sm">
                                View Templates
                            </a>
                        </div>
                    </div>
                    <div class="relative hidden md:block perspective-1000">
                        <!-- Abstract representation of a CV -->
                        <div class="bg-white rounded-2xl shadow-2xl p-8 transform rotate-6 group-hover:rotate-3 transition-all duration-700 max-w-md mx-auto border border-white/10 relative z-10">
                            <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                            <div class="relative bg-white rounded-xl p-8 h-full">
                                <div class="flex items-center gap-6 mb-8 border-b border-gray-100 pb-8">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full"></div>
                                    <div class="space-y-3 flex-1">
                                        <div class="h-5 w-2/3 bg-gray-800 rounded-full"></div>
                                        <div class="h-3 w-1/2 bg-primary-100 rounded-full"></div>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div class="h-3 w-full bg-gray-100 rounded-full"></div>
                                    <div class="h-3 w-full bg-gray-100 rounded-full"></div>
                                    <div class="h-3 w-5/6 bg-gray-100 rounded-full"></div>
                                    <div class="h-3 w-full bg-gray-100 rounded-full"></div>
                                </div>
                                <div class="mt-10 flex gap-4">
                                    <div class="w-1/3 h-24 bg-gray-50 rounded-xl"></div>
                                    <div class="w-2/3 space-y-3">
                                        <div class="h-3 w-full bg-gray-100 rounded-full"></div>
                                        <div class="h-3 w-full bg-gray-100 rounded-full"></div>
                                        <div class="h-3 w-3/4 bg-gray-100 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Decorative elements behind -->
                        <div class="absolute top-10 -right-10 w-full h-full bg-gray-800/50 rounded-2xl transform -rotate-6 scale-95 z-0 border border-white/5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials - Redesigned -->
    <div class="py-16 md:py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-white to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="inline-block px-4 py-1.5 bg-green-100 text-green-700 text-sm font-semibold rounded-full mb-4">Success Stories</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-black text-gray-900 tracking-tight">Loved by <span class="text-green-600">Thousands</span></h2>
                <p class="mt-4 text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">Real stories from real people who transformed their careers</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @php
                $testimonials = [
                    ['name' => 'Adaeze Okonkwo', 'role' => 'Software Engineer at Flutterwave', 'image' => 'A', 'color' => 'from-primary-500 to-primary-600', 'quote' => 'SpeedJobs helped me land my dream job at a fintech company. The resume builder and career coaching were invaluable!'],
                    ['name' => 'Kwame Asante', 'role' => 'Marketing Manager at MTN', 'image' => 'K', 'color' => 'from-accent-500 to-accent-600', 'quote' => 'Within 2 weeks of creating my profile, I received 5 interview requests. The platform truly connects you with the right opportunities.'],
                    ['name' => 'Fatima Hassan', 'role' => 'Data Analyst at Safaricom', 'image' => 'F', 'color' => 'from-purple-500 to-purple-600', 'quote' => 'The skill-up courses prepared me for the job market. I went from graduate to employed in just 3 months!'],
                ];
                @endphp
                
                @foreach($testimonials as $testimonial)
                <div class="group relative bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-primary-100">
                    <!-- Quote Icon -->
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-br {{ $testimonial['color'] }} rounded-2xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    
                    <p class="text-gray-600 text-lg leading-relaxed mb-8 pt-4">"{{ $testimonial['quote'] }}"</p>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br {{ $testimonial['color'] }} rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            {{ $testimonial['image'] }}
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900">{{ $testimonial['name'] }}</h4>
                            <p class="text-sm text-gray-500">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                    
                    <!-- Star Rating -->
                    <div class="flex gap-1 mt-6">
                        @foreach(range(1,5) as $star)
                        <svg class="w-5 h-5 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Job Listings - Redesigned -->
    <div class="py-16 md:py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-10 md:mb-12">
                <div>
                    <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full mb-4">Fresh Opportunities</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-black text-gray-900 tracking-tight">Latest <span class="text-blue-600">Job Openings</span></h2>
                    <p class="mt-4 text-lg md:text-xl text-gray-600 max-w-2xl">Discover your next career move from top employers across Africa</p>
                </div>
                <a href="{{ route('jobs.index') }}" class="mt-6 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                    View All Jobs
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recentJobs as $job)
                <a href="{{ route('jobs.show', $job) }}" class="group relative bg-white p-6 rounded-3xl border-2 border-gray-100 hover:border-primary-500 shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <!-- Hover Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 group-hover:from-primary-500 group-hover:to-primary-600 rounded-2xl flex items-center justify-center text-xl font-bold text-gray-500 group-hover:text-white transition-all duration-500 shadow-lg">
                                {{ substr($job->company, 0, 1) }}
                            </div>
                            @if($job->is_featured)
                                <span class="px-3 py-1.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg">Featured</span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-xl text-gray-900 group-hover:text-primary-700 transition-colors mb-2">{{ $job->title }}</h3>
                        <p class="text-gray-500 mb-4 flex items-center gap-2">
                            <span class="font-medium text-gray-700">{{ $job->company }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span>{{ $job->location }}</span>
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-5">
                            <span class="px-3 py-1.5 bg-primary-100 text-primary-700 text-xs font-bold rounded-full">{{ $job->type }}</span>
                            <span class="px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">{{ $job->category }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                            <span class="text-lg font-black text-gray-900">{{ $job->salary_range ?: 'Competitive' }}</span>
                            <span class="text-sm text-gray-400">{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <!-- Apply Arrow -->
                    <div class="absolute bottom-6 right-6 w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No jobs available yet</h3>
                    <p class="text-gray-500">Check back soon for new opportunities!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Featured Employers / Partners - Redesigned -->
    <div class="py-20 bg-gray-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-gray-200 text-gray-600 text-sm font-semibold rounded-full mb-4">Trusted Partners</span>
                <h2 class="text-3xl font-heading font-bold text-gray-900 tracking-tight">Companies That Trust Us</h2>
            </div>

            <!-- Animated Logo Marquee -->
            <div class="relative overflow-hidden py-8">
                <div class="flex animate-marquee space-x-16">
                    @foreach(['Flutterwave', 'Safaricom', 'MTN', 'Andela', 'Paystack', 'Interswitch', 'Jumia', 'Konga'] as $partner)
                    <div class="flex-shrink-0 w-40 h-20 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center hover:shadow-lg transition-shadow">
                        <span class="text-gray-400 font-bold text-lg">{{ $partner }}</span>
                    </div>
                    @endforeach
                    @foreach(['Flutterwave', 'Safaricom', 'MTN', 'Andela', 'Paystack', 'Interswitch', 'Jumia', 'Konga'] as $partner)
                    <div class="flex-shrink-0 w-40 h-20 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center hover:shadow-lg transition-shadow">
                        <span class="text-gray-400 font-bold text-lg">{{ $partner }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-500">Want to partner with us? <a href="{{ route('contact') }}" class="text-primary-600 font-bold hover:text-primary-700 underline underline-offset-4">Get in touch</a></p>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="py-20 md:py-32 bg-gradient-to-br from-slate-900 via-slate-800 to-primary-900 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-[150px]"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-[150px]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:60px_60px]"></div>
        </div>
        
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 mb-6 md:mb-8">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                </span>
                <span class="text-sm font-medium text-gray-300">Join 50,000+ African professionals</span>
            </div>
            
            <h2 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-heading font-black text-white mb-6 leading-tight">
                Ready to Start Your 
                <span class="text-primary-400">Career Journey?</span>
            </h2>
            
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Create your free account today and unlock access to thousands of opportunities across Africa.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-3 px-10 py-5 bg-white hover:bg-gray-100 text-gray-900 font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    Get Started Free
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center gap-3 px-10 py-5 bg-white/10 hover:bg-white/20 text-white font-bold text-lg rounded-2xl border border-white/20 backdrop-blur-sm transition-all">
                    Browse Jobs
                </a>
            </div>
            
            <!-- Trust Badges -->
            <div class="flex flex-wrap items-center justify-center gap-8 mt-16 pt-16 border-t border-white/10">
                <div class="text-center">
                    <div class="text-3xl font-black text-white">10K+</div>
                    <div class="text-sm text-gray-500">Active Jobs</div>
                </div>
                <div class="w-px h-12 bg-white/10 hidden sm:block"></div>
                <div class="text-center">
                    <div class="text-3xl font-black text-white">50K+</div>
                    <div class="text-sm text-gray-500">Job Seekers</div>
                </div>
                <div class="w-px h-12 bg-white/10 hidden sm:block"></div>
                <div class="text-center">
                    <div class="text-3xl font-black text-white">2K+</div>
                    <div class="text-sm text-gray-500">Companies</div>
                </div>
                <div class="w-px h-12 bg-white/10 hidden sm:block"></div>
                <div class="text-center">
                    <div class="text-3xl font-black text-white">95%</div>
                    <div class="text-sm text-gray-500">Success Rate</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
