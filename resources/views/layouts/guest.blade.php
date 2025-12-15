<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding & Visual -->
            <div class="hidden lg:flex lg:w-[45%] xl:w-1/2 relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900">
                <!-- Animated Background Elements -->
                <div class="absolute inset-0">
                    <div class="absolute top-10 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-10 right-10 w-72 h-72 bg-primary-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                </div>
                
                <!-- Grid Pattern Overlay -->
                <div class="absolute inset-0 opacity-[0.03]">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="32" height="32" patternUnits="userSpaceOnUse">
                                <path d="M 32 0 L 0 0 0 32" fill="none" stroke="white" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-between p-6 lg:p-8 xl:p-10 w-full">
                    <!-- Logo -->
                    <div class="flex items-center justify-between">
                        <a href="/" class="inline-flex items-center gap-3">
                            <img src="{{ asset('assets/logo.png') }}" alt="SpeedJobs" class="h-8 w-auto brightness-0 invert">
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <span class="text-white/70 text-xs font-medium">1,234 online</span>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="flex-1 flex flex-col justify-center py-6 space-y-5">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-full text-white/80 text-xs font-medium mb-3">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                #1 Job Platform in Africa
                            </div>
                            <h1 class="text-2xl lg:text-3xl xl:text-4xl font-extrabold text-white leading-tight">
                                Accelerate Your<br>
                                <span class="text-emerald-300">Career Journey</span>
                            </h1>
                            <p class="mt-3 text-sm text-white/70 max-w-xs leading-relaxed">
                                Join thousands of professionals across Africa who have found their dream careers through SpeedJobs.
                            </p>
                        </div>

                        <!-- Feature Cards - 2x2 Grid -->
                        <div class="grid grid-cols-2 gap-2.5">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center mb-2">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-white font-semibold text-xs">Smart Matching</p>
                                <p class="text-white/50 text-[10px] mt-0.5">AI-powered recommendations</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center mb-2">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <p class="text-white font-semibold text-xs">Fast Apply</p>
                                <p class="text-white/50 text-[10px] mt-0.5">One-click applications</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center mb-2">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-white font-semibold text-xs">Resume Builder</p>
                                <p class="text-white/50 text-[10px] mt-0.5">Professional templates</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center mb-2">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </div>
                                <p class="text-white font-semibold text-xs">Job Alerts</p>
                                <p class="text-white/50 text-[10px] mt-0.5">Instant notifications</p>
                            </div>
                        </div>

                        <!-- Stats Row -->
                        <div class="flex items-center justify-between bg-white/5 rounded-xl p-4 border border-white/10">
                            <div class="text-center">
                                <p class="text-xl font-bold text-white">10K+</p>
                                <p class="text-[10px] text-white/50">Active Jobs</p>
                            </div>
                            <div class="w-px h-8 bg-white/20"></div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-white">50K+</p>
                                <p class="text-[10px] text-white/50">Job Seekers</p>
                            </div>
                            <div class="w-px h-8 bg-white/20"></div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-white">2K+</p>
                                <p class="text-[10px] text-white/50">Companies</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                A
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white/90 text-sm leading-relaxed italic truncate">
                                    "SpeedJobs helped me land my dream job within 2 weeks!"
                                </p>
                                <p class="text-white/50 text-xs mt-1">Adaeze O. - Software Engineer at Paystack</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-[55%] xl:w-1/2 flex flex-col">
                <!-- Mobile Header -->
                <div class="lg:hidden p-6 bg-gradient-to-r from-primary-600 to-primary-700">
                    <a href="/" class="inline-flex items-center gap-3">
                        <img src="{{ asset('assets/logo.png') }}" alt="SpeedJobs" class="h-10 w-auto brightness-0 invert">
                    </a>
                </div>

                <!-- Form Container -->
                <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12 xl:p-16 bg-white">
                    <div class="w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-6 text-center text-sm text-slate-400 bg-white border-t border-slate-100">
                    <p>&copy; {{ date('Y') }} SpeedJobs Africa. All rights reserved.</p>
                </div>
            </div>
        </div>

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
        </style>
    </body>
</html>
