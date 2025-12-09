<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-pink-50 to-purple-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center px-4 py-2 bg-pink-100 rounded-full mb-4">
                    <svg class="w-5 h-5 text-pink-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-pink-700 font-semibold">Premium Feature</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Workshops & Events</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Join live workshops, employer sessions, and networking events to accelerate your career.</p>
            </div>

            <!-- Upcoming Events -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Upcoming Events</h2>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Event 1 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                        <div class="h-40 bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 bg-pink-100 text-pink-700 text-xs font-bold rounded-full">Workshop</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Virtual</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Resume Writing Masterclass</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn how to craft a compelling resume that gets noticed by recruiters.</p>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Dec 15, 2025 • 2:00 PM WAT
                            </div>
                            <button class="w-full py-3 bg-pink-600 text-white font-semibold rounded-xl hover:bg-pink-700 transition-all">
                                Register Now
                            </button>
                        </div>
                    </div>

                    <!-- Event 2 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                        <div class="h-40 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Networking</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">In-Person</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Tech Career Fair Lagos</h3>
                            <p class="text-gray-600 text-sm mb-4">Meet top tech employers and explore exciting career opportunities.</p>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Dec 20, 2025 • 10:00 AM WAT
                            </div>
                            <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                                Register Now
                            </button>
                        </div>
                    </div>

                    <!-- Event 3 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                        <div class="h-40 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Workshop</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Virtual</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Interview Skills Bootcamp</h3>
                            <p class="text-gray-600 text-sm mb-4">Intensive 3-hour session on mastering job interviews.</p>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Jan 5, 2026 • 3:00 PM WAT
                            </div>
                            <button class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all">
                                Register Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Past Events -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Past Events</h2>
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p>Recordings of past events will be available here for premium members.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
