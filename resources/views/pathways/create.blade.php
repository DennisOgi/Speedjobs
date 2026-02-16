<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Your Career Pathway</h1>
                <p class="text-gray-600">Tell us your career goals and let AI create a personalized roadmap</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                
                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-red-800 mb-1">Error Generating Pathway</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('pathways.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Target Role -->
                    <div>
                        <label for="target_role" class="block text-sm font-semibold text-gray-900 mb-2">
                            What's your dream job? <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="target_role"
                            name="target_role" 
                            required
                            value="{{ old('target_role') }}"
                            class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg" 
                            placeholder="e.g., Senior Software Engineer, Marketing Manager, Data Scientist"
                        >
                        @error('target_role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Be specific about the role you want to achieve</p>
                    </div>

                    <!-- Current Role -->
                    <div>
                        <label for="current_role" class="block text-sm font-semibold text-gray-900 mb-2">
                            Where are you now?
                        </label>
                        <input 
                            type="text" 
                            id="current_role"
                            name="current_role" 
                            value="{{ old('current_role', auth()->user()->experience_level ?? '') }}"
                            class="w-full px-4 py-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            placeholder="e.g., Junior Developer, Recent Graduate, Career Changer"
                        >
                        @error('current_role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Your current position or experience level</p>
                    </div>

                    <!-- Current Skills (Optional - from profile) -->
                    @if(auth()->user()->skills)
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                        <p class="text-sm font-medium text-blue-900 mb-2">Your Current Skills:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', auth()->user()->skills) as $skill)
                                <span class="px-3 py-1 bg-white text-blue-700 rounded-full text-sm border border-blue-200">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                        <p class="text-xs text-blue-600 mt-2">
                            <a href="{{ route('profile.edit') }}" class="hover:underline">Update skills in your profile</a>
                        </p>
                    </div>
                    @endif

                    <!-- What AI Will Generate -->
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-6 border border-purple-100">
                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            AI Will Generate:
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Step-by-step milestones to reach your goal
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Timeline with estimated duration for each phase
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Skills you need to develop at each stage
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Recommended courses, books, and certifications
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Progress tracking to monitor your journey
                            </li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 pt-4">
                        <a href="{{ route('pathways.index') }}" class="flex-1 py-3 px-6 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 py-3 px-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Generate My Pathway
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-gray-600">
                        <p class="font-medium text-gray-900 mb-1">Powered by AI</p>
                        <p>Your career pathway is generated using advanced AI that analyzes thousands of successful career transitions to create a personalized roadmap just for you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
