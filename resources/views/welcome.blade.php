<x-app-layout>
    <!-- Hero Section -->
    <div x-data="{ scroll: 0 }" @scroll.window="scroll = window.pageYOffset" class="relative overflow-hidden min-h-[85vh] lg:min-h-[90vh] flex items-center bg-white">
        <!-- 3D Globe Background - Positioned further right to avoid overlap -->
        <x-hero-globe class="absolute inset-0 top-20 lg:top-0 lg:left-[45%] lg:w-[55%] z-0 opacity-100 lg:opacity-100 -translate-y-0 lg:-translate-y-12 pointer-events-none" />
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-16 lg:pt-20 pb-12 lg:pb-0">
            <div class="max-w-3xl lg:max-w-xl text-center lg:text-left" x-data x-intersect="$el.classList.add('animate-fade-in-up')">
                <div class="hidden lg:inline-flex items-center gap-2 px-3 py-1.5 lg:px-4 lg:py-2 rounded-full bg-white/80 lg:bg-white/60 backdrop-blur-md border border-gray-200 lg:border-white/40 shadow-sm mb-6 lg:mb-8 opacity-0 animate-fade-in-up mx-auto lg:mx-0">
                    <span class="flex h-2 w-2 rounded-full bg-accent-500"></span>
                    <span class="text-xs lg:text-sm font-medium text-gray-600">{{ __('content.brand.secondary_tagline') }}</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-7xl tracking-tight font-heading font-extrabold text-gray-900 opacity-0 animation-delay-100 leading-tight drop-shadow-sm" :class="'animate-fade-in-up'">
                    {{ __('content.home.hero.headline') }}
                </h1>
                
                <p class="mt-4 lg:mt-6 max-w-lg text-base sm:text-lg lg:text-xl text-white lg:text-primary-600 bg-gray-900/30 lg:bg-transparent opacity-0 animation-delay-200 leading-relaxed font-medium mx-auto lg:mx-0 drop-shadow-md" :class="'animate-fade-in-up'">
                    {{ __('content.home.hero.subheadline') }}
                </p>
                
                <!-- Search Bar -->
                <div class="mt-8 lg:mt-10 max-w-full opacity-0 animation-delay-400" :class="'animate-fade-in-up'">
                    <form action="{{ route('jobs.index') }}" method="GET" class="relative flex flex-col md:flex-row gap-3 p-2 lg:p-3 bg-white/90 lg:bg-white/80 backdrop-blur-2xl rounded-2xl lg:rounded-[2rem] shadow-xl lg:shadow-2xl shadow-primary-900/5 border border-gray-100 lg:border-white/60 transform transition-transform hover:scale-[1.01]">
                        <div class="flex-1 flex items-center px-4 lg:px-6 h-12 lg:h-auto border-b md:border-b-0 md:border-r border-gray-200/50">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-400 mr-3 lg:mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="search" placeholder="Job title, skills..." class="w-full bg-transparent border-none focus:ring-0 text-gray-900 placeholder-gray-400 text-base lg:text-lg font-medium p-0">
                        </div>
                        <div class="flex-1 flex items-center px-4 lg:px-6 h-12 lg:h-auto">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-400 mr-3 lg:mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="text" name="location" placeholder="City or remote" class="w-full bg-transparent border-none focus:ring-0 text-gray-900 placeholder-gray-400 text-base lg:text-lg font-medium p-0">
                        </div>
                        <button type="submit" class="w-full md:w-auto px-6 lg:px-10 py-3 lg:py-4 bg-gray-900 hover:bg-black text-white font-bold rounded-xl lg:rounded-[1.5rem] shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-base lg:text-lg whitespace-nowrap">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Why SpeedJobs? Stats -->
                <div class="mt-10 lg:mt-14 grid grid-cols-1 gap-4 lg:gap-6 md:grid-cols-3 border-t border-gray-200/60 pt-6 lg:pt-8 opacity-0 animation-delay-600" :class="'animate-fade-in-up'">
                    <div class="group cursor-default text-center lg:text-left p-3 lg:p-4 rounded-2xl hover:bg-gray-50 transition-colors duration-300">
                        <div class="text-3xl lg:text-4xl font-heading font-bold text-gray-900 tracking-tight group-hover:text-primary-600 transition-colors">
                            {{ __('content.home.stats.stat1') }}
                        </div>
                        <div class="text-xs lg:text-sm text-gray-500 font-semibold uppercase tracking-wider mt-1 lg:mt-2">{{ __('content.home.stats.stat1_desc') }}</div>
                    </div>
                    <div class="group cursor-default text-center lg:text-left p-3 lg:p-4 rounded-2xl hover:bg-gray-50 transition-colors duration-300">
                        <div class="text-3xl lg:text-4xl font-heading font-bold text-gray-900 tracking-tight group-hover:text-primary-600 transition-colors">
                            {{ __('content.home.stats.stat2') }}
                        </div>
                        <div class="text-xs lg:text-sm text-gray-500 font-semibold uppercase tracking-wider mt-1 lg:mt-2">{{ __('content.home.stats.stat2_desc') }}</div>
                    </div>
                    <div class="group cursor-default text-center lg:text-left p-3 lg:p-4 rounded-2xl hover:bg-gray-50 transition-colors duration-300">
                        <div class="text-base lg:text-lg font-medium text-gray-900 leading-snug">
                            "{{ __('content.home.stats.value_prop') }}"
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advertisement Banner Slider -->
    <x-banner-slider :banners="$banners" />

    <!-- Featured Categories -->
    <div class="py-16 bg-gray-50/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 tracking-tight">Popular Categories</h2>
                <p class="mt-3 text-lg text-gray-600 font-light max-w-2xl mx-auto">Explore opportunities in top industries and find your perfect role.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                $categories = [
                    [
                        'name' => 'Technology',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />'
                    ],
                    [
                        'name' => 'Finance',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                    ],
                    [
                        'name' => 'Healthcare',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />'
                    ],
                    [
                        'name' => 'Education',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />'
                    ],
                    [
                        'name' => 'Marketing',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />'
                    ],
                    [
                        'name' => 'Engineering',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />'
                    ],
                    [
                        'name' => 'Sales',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />'
                    ],
                    [
                        'name' => 'Design',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />'
                    ]
                ];
                @endphp

                @foreach($categories as $category)
                <a href="{{ route('jobs.index', ['category' => $category['name']]) }}" class="group bg-white p-6 rounded-[1.5rem] shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 hover:border-primary-100 flex flex-col items-center text-center transform hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 w-16 h-16 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-600 group-hover:text-white transition-all duration-500 shadow-inner group-hover:shadow-lg group-hover:scale-110">
                        <svg class="w-8 h-8 transition-transform duration-500 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $category['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="relative z-10 font-bold text-lg text-gray-900 group-hover:text-primary-700 transition-colors">{{ $category['name'] }}</h3>
                    <span class="relative z-10 text-sm font-medium text-gray-500 mt-3 group-hover:text-primary-600 transition-colors bg-gray-100 group-hover:bg-white/60 px-3 py-1 rounded-full">120+ Jobs</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Who We Serve -->
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-heading font-bold text-gray-900 tracking-tight">Who We Serve</h2>
                <p class="mt-4 text-lg text-gray-600 font-light max-w-2xl mx-auto">Empowering the entire ecosystem of the African labor market.</p>
            </div>

            <div 
                x-data="{
                    scrollContainer: null,
                    startAutoScroll() {
                        if (window.innerWidth >= 768) return; // Don't auto-scroll on desktop
                        this.scrollContainer = $el;
                        setInterval(() => {
                            if (!this.scrollContainer) return;
                            const maxScroll = this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth;
                            if (this.scrollContainer.scrollLeft >= maxScroll - 10) {
                                this.scrollContainer.scrollTo({ left: 0, behavior: 'smooth' });
                            } else {
                                this.scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
                            }
                        }, 3000);
                    }
                }"
                x-init="startAutoScroll()"
                class="flex md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 overflow-x-auto md:overflow-visible snap-x snap-mandatory pb-8 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0 scrollbar-hide"
            >
                <!-- Students -->
                <div class="min-w-[85vw] md:min-w-0 snap-center p-6 md:p-8 rounded-2xl bg-white border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:shadow-primary-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-500 to-primary-300 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v5m0 0c-1.657 0-3-.895-3-2s1.343-2 3-2 3 .895 3 2-1.343 2-3 2"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-primary-600 transition-colors">{{ __('content.home.who_we_serve.students.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('content.home.who_we_serve.students.desc') }}</p>
                </div>

                <!-- Job Seekers -->
                <div class="min-w-[85vw] md:min-w-0 snap-center p-6 md:p-8 rounded-2xl bg-white border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:shadow-accent-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-accent-500 to-accent-300 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-accent-50 text-accent-600 rounded-xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 group-hover:bg-accent-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-accent-600 transition-colors">{{ __('content.home.who_we_serve.job_seekers.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('content.home.who_we_serve.job_seekers.desc') }}</p>
                </div>

                <!-- Employers -->
                <div class="min-w-[85vw] md:min-w-0 snap-center p-6 md:p-8 rounded-2xl bg-white border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-300 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-blue-600 transition-colors">{{ __('content.home.who_we_serve.employers.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('content.home.who_we_serve.employers.desc') }}</p>
                </div>

                <!-- Institutions -->
                <div class="min-w-[85vw] md:min-w-0 snap-center p-6 md:p-8 rounded-2xl bg-white border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-purple-300 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-purple-600 transition-colors">{{ __('content.home.who_we_serve.institutions.title') }}</h3>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('content.home.who_we_serve.institutions.desc') }}</p>
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

    <!-- Testimonials -->
    <div class="py-20 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-heading font-bold text-gray-900">Success Stories</h2>
                <p class="mt-3 text-lg text-gray-600">Hear from people who found their path with SpeedJobs</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach(range(1, 3) as $i)
                <div class="bg-white/80 backdrop-blur-lg p-8 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-white/50 hover:border-primary-200 group">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full overflow-hidden border-2 border-white shadow-sm">
                            <!-- Avatar placeholder -->
                            <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900">Sarah K.</h4>
                            <p class="text-sm font-medium text-primary-600">Software Engineer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic leading-relaxed">"The resume builder is a game changer! I applied to 5 jobs and got 3 interviews within a week. Highly recommended."</p>
                    <div class="flex text-accent mt-6 gap-1">
                        @foreach(range(1,5) as $star)
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Job Listings -->
    <div class="py-24 bg-gray-50/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-heading font-bold text-gray-900 tracking-tight">Latest Opportunities</h2>
                    <p class="mt-3 text-lg text-gray-600 font-light max-w-2xl">Fresh job openings from top employers across Africa.</p>
                </div>
                <a href="{{ route('jobs.index') }}" class="mt-4 md:mt-0 inline-flex items-center text-primary-600 font-bold hover:text-primary-700 transition-colors">
                    View All Jobs
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recentJobs as $job)
                <a href="{{ route('jobs.show', $job) }}" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-primary-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-50/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl flex items-center justify-center text-lg font-bold text-gray-400 shadow-inner border border-gray-100">
                                {{ substr($job->company, 0, 1) }}
                            </div>
                            @if($job->is_featured)
                                <span class="px-2 py-1 bg-accent-100 text-accent-700 text-xs font-bold rounded-full">Featured</span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-primary-600 transition-colors mb-2">{{ $job->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $job->company }} • {{ $job->location }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-2.5 py-1 bg-primary-50 text-primary-700 text-xs font-medium rounded-lg">{{ $job->type }}</span>
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">{{ $job->category }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-sm font-bold text-gray-900">{{ $job->salary_range }}</span>
                            <span class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">No jobs available at the moment. Check back soon!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Featured Employers / Partners -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-heading font-bold text-gray-900 tracking-tight">Trusted by Leading Organizations</h2>
                <p class="mt-3 text-lg text-gray-600 font-light">Partner companies and institutions that trust SpeedJobs Africa</p>
            </div>

            <!-- Partner Logos Slider -->
            <div class="relative overflow-hidden">
                <div class="flex items-center justify-center gap-12 flex-wrap opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <!-- Placeholder logos - replace with actual partner logos -->
                    <div class="w-32 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-sm">Partner 1</span>
                    </div>
                    <div class="w-32 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-sm">Partner 2</span>
                    </div>
                    <div class="w-32 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-sm">Partner 3</span>
                    </div>
                    <div class="w-32 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-sm">Partner 4</span>
                    </div>
                    <div class="w-32 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-sm">Partner 5</span>
                    </div>
                    <div class="w-32 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-sm">Partner 6</span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-500 text-sm">Want to partner with us? <a href="{{ route('contact') }}" class="text-primary-600 font-medium hover:text-primary-700">Get in touch</a></p>
            </div>
        </div>
    </div>

    <!-- Newsletter CTA -->
    <div class="py-20 bg-gradient-to-r from-primary-600 to-primary-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">Get Job Alerts Straight to Your Inbox</h2>
            <p class="text-primary-100 text-lg mb-8 max-w-2xl mx-auto">Be the first to know about new opportunities that match your skills and interests.</p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-white/50 text-gray-900 placeholder-gray-400 shadow-lg">
                <button type="submit" class="px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-primary-50 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Subscribe
                </button>
            </form>
            
            <p class="text-primary-200 text-sm mt-4">Join 10,000+ job seekers. Unsubscribe anytime.</p>
        </div>
    </div>
</x-app-layout>
