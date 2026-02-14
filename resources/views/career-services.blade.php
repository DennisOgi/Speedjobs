<x-app-layout>
    <div class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen">
        <!-- Hero Section -->
        <div class="relative py-24 sm:py-32 overflow-hidden isolate">
            <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-gray-900/80 via-gray-900/60 to-gray-900/80"></div>
            <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white/5 shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                        <svg class="w-4 h-4 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-white">Premium Members Only</span>
                    </div>
                    <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-6xl mb-6 drop-shadow-sm">
                        Career <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-purple-200">Services</span>
                    </h1>
                    <p class="text-xl text-gray-200 max-w-3xl mx-auto leading-relaxed drop-shadow-sm">
                        Comprehensive career support exclusively for premium members. Get expert guidance, professional tools, and personalized support.
                    </p>

                    @guest
                        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-gray-900 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-lg">
                                Create Premium Account
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-white/10 text-white font-bold rounded-xl hover:bg-white/20 transition-all border border-white/30">
                                Login
                            </a>
                        </div>
                    @else
                        @if(!auth()->user()->is_paid)
                            <div class="mt-8">
                                <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all shadow-lg inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Upgrade to Premium
                                </a>
                            </div>
                        @endif
                    @endguest
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-6 lg:px-8 -mt-8 mb-8">
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 font-medium text-center">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Services Section -->
        <div class="py-24 sm:py-32 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Career Services</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Professional resources designed to help you succeed in every stage of your career journey</p>
                </div>

                <!-- Services Grid - 3 columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- AI Career Counselor - PRIMARY FEATURE -->
                    <div class="group relative bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 rounded-3xl p-6 sm:p-8 shadow-2xl hover:shadow-3xl transition-all duration-300 overflow-hidden md:col-span-2 lg:col-span-3">
                        <!-- Animated Background Elements -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -mr-32 -mt-32 animate-pulse"></div>
                            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full -ml-24 -mb-24 animate-pulse delay-75"></div>
                        </div>
                        
                        <div class="relative grid lg:grid-cols-2 gap-6 lg:gap-8 items-center">
                            <!-- Left Column - Main Content -->
                            <div class="text-white">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-xl border border-white/30">
                                        <svg class="w-7 h-7 sm:w-9 sm:h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl sm:text-3xl font-bold mb-1">AI Career Counselor</h3>
                                        <p class="text-emerald-50 text-sm">Your 24/7 Intelligent Career Guide</p>
                                    </div>
                                </div>
                                
                                <p class="text-white/90 text-base sm:text-lg leading-relaxed mb-6">
                                    Get instant, personalized career guidance powered by advanced AI. From assessments to interview prep, we've got you covered.
                                </p>

                                <!-- Quick Stats -->
                                <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                                        <div class="text-2xl sm:text-3xl font-bold">24/7</div>
                                        <div class="text-xs text-emerald-50">Available</div>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                                        <div class="text-2xl sm:text-3xl font-bold">4+</div>
                                        <div class="text-xs text-emerald-50">Features</div>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                                        <div class="text-2xl sm:text-3xl font-bold">AI</div>
                                        <div class="text-xs text-emerald-50">Powered</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Features & CTA -->
                            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-2xl">
                                <h4 class="font-bold text-gray-900 mb-4 text-base sm:text-lg flex items-center gap-2">
                                    <span class="text-2xl">🎯</span>
                                    What You Get:
                                </h4>
                                <ul class="space-y-2.5 sm:space-y-3 text-sm text-gray-700 mb-6">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span><strong>Career DNA Assessment</strong> - Discover your ideal role</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span><strong>Mock Interviews</strong> - Practice with AI feedback</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span><strong>Resume Optimization</strong> - ATS analysis & tips</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span><strong>Career Planning</strong> - Personalized pathways</span>
                                    </li>
                                </ul>
                                
                                @auth
                                    @if(auth()->user()->is_paid)
                                        <a href="{{ route('ai-counselor.index') }}" class="w-full inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm sm:text-base">
                                            Start Your AI Journey
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm sm:text-base">
                                            🔓 Upgrade to Access
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        </a>
                                        <p class="text-center text-xs text-gray-500 mt-2">Premium Feature</p>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm sm:text-base">
                                        Get Started Free
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                    <p class="text-center text-xs text-gray-500 mt-2">Create an account to get started</p>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Resume Builder -->
                    <div class="group relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-orange-100 to-orange-50 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white mb-5 shadow-lg">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Resume Builder</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Build professional, ATS-friendly resumes with our premium templates.</p>
                            <ul class="space-y-2 mb-6 text-sm text-gray-600">
                                <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Premium templates</li>
                                <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Export to PDF</li>
                            </ul>
                            @auth
                                @if(auth()->user()->is_paid)
                                    <a href="{{ route('resume.create') }}" class="inline-flex items-center px-5 py-2.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 transition-all text-sm">
                                        Build Resume <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-500 font-semibold rounded-xl text-sm"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>Premium Only</span>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-900 transition-all text-sm">Sign Up</a>
                            @endauth
                        </div>
                    </div>

                    <!-- 6. Mentorship Program -->
                    <div class="group relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white mb-5 shadow-lg">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Mentorship Program</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Connect with industry leaders and build your professional network.</p>
                            <ul class="space-y-2 mb-6 text-sm text-gray-600">
                                <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Find a mentor</li>
                                <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Become a mentor</li>
                            </ul>
                            @auth
                                @if(auth()->user()->is_paid)
                                    <a href="{{ route('mentorship') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all text-sm">
                                        Join Program <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-500 font-semibold rounded-xl text-sm"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>Premium Only</span>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-900 transition-all text-sm">Sign Up</a>
                            @endauth
                        </div>
                    </div>

                    <!-- 7. Career Planning Tool -->
                    <div class="group relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden md:col-span-2 lg:col-span-1">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-teal-100 to-teal-50 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white mb-5 shadow-lg">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Career Planning Tool</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">AI-powered pathway generator to map your career journey.</p>
                            <ul class="space-y-2 mb-6 text-sm text-gray-600">
                                <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>AI career pathways</li>
                                <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Goal tracking</li>
                            </ul>
                            @auth
                                @if(auth()->user()->is_paid)
                                    <a href="{{ route('career-planning.index') }}" class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-all text-sm">
                                        Plan Career <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-500 font-semibold rounded-xl text-sm"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>Premium Only</span>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-800 text-white font-semibold rounded-xl hover:bg-gray-900 transition-all text-sm">Sign Up</a>
                            @endauth
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
