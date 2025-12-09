<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-green-50 to-blue-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center px-4 py-2 bg-green-100 rounded-full mb-4">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span class="text-green-700 font-semibold">Premium Feature</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Interview Coaching</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Master the art of interviewing with expert coaching, mock sessions, and comprehensive resources.</p>
            </div>

            <!-- Services Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mb-12">
                <!-- Mock Interview -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">1-on-1 Mock Interview</h3>
                    <p class="text-gray-600 mb-4">Practice with experienced interviewers and get personalized feedback.</p>
                    <p class="text-2xl font-bold text-gray-900 mb-4">₦15,000 <span class="text-sm font-normal text-gray-500">/ session</span></p>
                    <button class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all">
                        Book Session
                    </button>
                </div>

                <!-- Video Resources -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Video Tutorials</h3>
                    <p class="text-gray-600 mb-4">Access our library of interview tips and techniques from industry experts.</p>
                    <p class="text-2xl font-bold text-green-600 mb-4">Included <span class="text-sm font-normal text-gray-500">with premium</span></p>
                    <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                        Watch Now
                    </button>
                </div>

                <!-- Question Bank -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Question Bank</h3>
                    <p class="text-gray-600 mb-4">500+ common interview questions with sample answers by industry.</p>
                    <p class="text-2xl font-bold text-green-600 mb-4">Included <span class="text-sm font-normal text-gray-500">with premium</span></p>
                    <button class="w-full py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all">
                        Browse Questions
                    </button>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Interview Tips</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold shrink-0">1</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Research the Company</h4>
                            <p class="text-sm text-gray-600">Understand their mission, values, and recent news before your interview.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold shrink-0">2</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Practice STAR Method</h4>
                            <p class="text-sm text-gray-600">Structure your answers using Situation, Task, Action, Result format.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold shrink-0">3</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Prepare Questions</h4>
                            <p class="text-sm text-gray-600">Have thoughtful questions ready to ask your interviewer.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold shrink-0">4</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Follow Up</h4>
                            <p class="text-sm text-gray-600">Send a thank-you email within 24 hours of your interview.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
