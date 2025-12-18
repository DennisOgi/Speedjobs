@props(['banners'])

@if($banners->count() > 0)
<div x-data="{
    currentSlide: 0,
    banners: {{ $banners->count() }},
    autoplay: null,
    showApplyModal: false,
    selectedBanner: null,
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
        this.currentSlide = (this.currentSlide + 1) % this.banners;
    },
    prev() {
        this.currentSlide = (this.currentSlide - 1 + this.banners) % this.banners;
    },
    goTo(index) {
        this.currentSlide = index;
        this.stopAutoplay();
        this.startAutoplay();
    }
}" class="relative w-full overflow-hidden" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
    
    <!-- Main Slider Container -->
    <div class="relative">
        @foreach($banners as $index => $banner)
            <div x-show="currentSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative"
                 x-cloak>
                
                <!-- Banner Card -->
                <div class="relative overflow-hidden rounded-2xl mx-4 md:mx-8 lg:mx-auto lg:max-w-6xl shadow-2xl">
                    <!-- Background with Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r 
                        @if($banner->type === 'training') from-emerald-600 via-teal-600 to-cyan-600
                        @elseif($banner->type === 'event') from-violet-600 via-purple-600 to-fuchsia-600
                        @elseif($banner->type === 'workshop') from-blue-600 via-indigo-600 to-violet-600
                        @else from-slate-700 via-slate-600 to-slate-500
                        @endif">
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/5 rounded-full"></div>
                        <!-- Grid Pattern -->
                        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 px-6 py-10 md:px-12 md:py-16 lg:py-20">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                            <!-- Text Content -->
                            <div class="text-center lg:text-left space-y-6">
                                <!-- Badge -->
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                    @if($banner->type === 'training')
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    @elseif($banner->type === 'event')
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @elseif($banner->type === 'workshop')
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    @else
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    @endif
                                    <span class="text-sm font-semibold text-white uppercase tracking-wider">{{ $banner->type }}</span>
                                </div>

                                <!-- Title -->
                                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                                    {{ $banner->title }}
                                </h2>

                                <!-- Description -->
                                @if($banner->description)
                                    <p class="text-lg md:text-xl text-white/90 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                                        {{ $banner->description }}
                                    </p>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start pt-4">
                                    @auth
                                        @php
                                            $hasApplied = \App\Models\BannerApplication::where('banner_id', $banner->id)
                                                ->where('user_id', auth()->id())
                                                ->exists();
                                        @endphp
                                        @if($hasApplied)
                                            <span class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl border border-white/30 text-sm sm:text-base">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Applied
                                            </span>
                                        @else
                                            <button onclick="document.getElementById('apply-modal-{{ $banner->id }}').showModal()" 
                                                    class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-white text-gray-900 font-bold rounded-xl hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Apply Now
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-white text-gray-900 font-bold rounded-xl hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                            Login to Apply
                                        </a>
                                    @endauth
                                    
                                    @if($banner->link)
                                        <a href="{{ $banner->link }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-transparent text-white font-bold rounded-xl border-2 border-white/50 hover:bg-white/10 hover:border-white transition-all duration-300 text-sm sm:text-base">
                                            Learn More
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Image Section -->
                            <div class="mt-6 lg:mt-0">
                                @if($banner->image)
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent rounded-2xl"></div>
                                        <img src="{{ asset($banner->image) }}" 
                                             alt="{{ $banner->title }}" 
                                             class="w-full h-48 md:h-64 lg:h-72 object-cover rounded-2xl shadow-2xl ring-4 ring-white/20"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden relative h-48 md:h-64 lg:h-72 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 items-center justify-center">
                                            <p class="text-white/60 font-medium">Image unavailable</p>
                                        </div>
                                    </div>
                                @else
                                    <!-- Placeholder Illustration -->
                                    <div class="relative h-48 md:h-64 lg:h-72 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                        <div class="text-center">
                                            @if($banner->type === 'training')
                                                <svg class="w-16 h-16 md:w-24 md:h-24 mx-auto text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            @elseif($banner->type === 'event')
                                                <svg class="w-16 h-16 md:w-24 md:h-24 mx-auto text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            @else
                                                <svg class="w-16 h-16 md:w-24 md:h-24 mx-auto text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            @endif
                                            <p class="mt-4 text-white/60 font-medium">{{ ucfirst($banner->type) }} Programme</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    @if($banners->count() > 1)
        <button @click="prev()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-3 rounded-full shadow-xl transition-all z-20 hover:scale-110">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button @click="next()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-3 rounded-full shadow-xl transition-all z-20 hover:scale-110">
            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Progress Dots -->
        <div class="flex justify-center gap-2 mt-6 pb-4">
            @foreach($banners as $index => $banner)
                <button @click="goTo({{ $index }})" 
                        :class="currentSlide === {{ $index }} ? 'bg-primary-600 w-10' : 'bg-gray-300 hover:bg-gray-400 w-3'"
                        class="h-3 rounded-full transition-all duration-500">
                </button>
            @endforeach
        </div>
    @endif

    <!-- Apply Modals -->
    @auth
        @foreach($banners as $banner)
            <dialog id="apply-modal-{{ $banner->id }}" class="rounded-2xl shadow-2xl backdrop:bg-black/50 p-0 max-w-lg w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Apply to {{ $banner->title }}</h3>
                        <button onclick="document.getElementById('apply-modal-{{ $banner->id }}').close()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <form action="{{ route('banners.apply', $banner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Why are you interested in this programme? (Optional)</label>
                                <textarea name="cover_letter" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Tell us about yourself and why you'd like to join..."></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Resume (Optional)</label>
                                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX (Max 5MB)</p>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="document.getElementById('apply-modal-{{ $banner->id }}').close()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">Cancel</button>
                            <button type="submit" class="flex-1 px-4 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">Submit Application</button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endforeach
    @endauth
</div>
@endif
