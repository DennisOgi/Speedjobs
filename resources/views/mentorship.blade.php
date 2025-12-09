<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-indigo-50 to-purple-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center px-4 py-2 bg-indigo-100 rounded-full mb-4">
                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="text-indigo-700 font-semibold">Premium Feature</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Mentorship Program</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Connect with experienced professionals who can guide your career journey and help you reach your goals.</p>
            </div>

            <!-- Options -->
            <div class="grid gap-8 md:grid-cols-2 mb-12">
                <!-- Find a Mentor -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Find a Mentor</h2>
                    <p class="text-gray-600 mb-6">Browse our network of industry professionals ready to share their knowledge and experience with you.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Access to 100+ mentors</li>
                        <li class="flex items-center text-gray-700"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Filter by industry & expertise</li>
                        <li class="flex items-center text-gray-700"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Schedule virtual sessions</li>
                    </ul>
                    <a href="{{ route('counselors.index') }}" class="block w-full py-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all text-center">
                        Browse Mentors
                    </a>
                </div>

                <!-- Become a Mentor -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Become a Mentor</h2>
                    <p class="text-gray-600 mb-6">Share your expertise and help shape the next generation of African professionals.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Give back to the community</li>
                        <li class="flex items-center text-gray-700"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Flexible scheduling</li>
                        <li class="flex items-center text-gray-700"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Build your personal brand</li>
                    </ul>
                    <button class="w-full py-4 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-all">
                        Apply as Mentor
                    </button>
                </div>
            </div>

            <!-- How It Works -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">How It Works</h2>
                <div class="grid gap-8 md:grid-cols-4">
                    <div class="text-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mx-auto mb-4">1</div>
                        <h4 class="font-bold text-gray-900 mb-2">Browse Mentors</h4>
                        <p class="text-sm text-gray-600">Find mentors in your industry or area of interest.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mx-auto mb-4">2</div>
                        <h4 class="font-bold text-gray-900 mb-2">Send Request</h4>
                        <p class="text-sm text-gray-600">Introduce yourself and explain your goals.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mx-auto mb-4">3</div>
                        <h4 class="font-bold text-gray-900 mb-2">Get Matched</h4>
                        <p class="text-sm text-gray-600">Once accepted, schedule your first session.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mx-auto mb-4">4</div>
                        <h4 class="font-bold text-gray-900 mb-2">Grow Together</h4>
                        <p class="text-sm text-gray-600">Meet regularly and track your progress.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
