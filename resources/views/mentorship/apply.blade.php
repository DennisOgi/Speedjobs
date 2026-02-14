<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-purple-50 to-indigo-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('mentorship') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-2 inline-flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Mentorship
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Apply to Become a Mentor</h1>
                <p class="text-gray-600 mt-1">Share your expertise and help shape the next generation of African professionals</p>
            </div>

            @if($existingApplication)
                <!-- Existing Application Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold text-blue-900 mb-1">You have an existing application</h3>
                            <p class="text-blue-700 text-sm mb-3">
                                Status: <span class="font-semibold capitalize">{{ $existingApplication->status }}</span>
                                @if($existingApplication->status === 'pending')
                                    - We're currently reviewing your application.
                                @elseif($existingApplication->status === 'approved')
                                    - Congratulations! Your application has been approved.
                                @else
                                    - Your previous application was not approved. You can submit a new application below.
                                @endif
                            </p>
                            <a href="{{ route('mentorship.my-application') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                View Application Status →
                            </a>
                        </div>
                    </div>
                </div>

                @if(in_array($existingApplication->status, ['pending', 'approved']))
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
                        <p class="text-gray-600 mb-4">You cannot submit a new application while you have an active one.</p>
                        <a href="{{ route('mentorship.my-application') }}" class="inline-block px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all">
                            View My Application
                        </a>
                    </div>
                    @php return; @endphp
                @endif
            @endif

            <!-- Application Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <form action="{{ route('mentorship.store') }}" method="POST">
                    @csrf

                    <!-- Expertise Area -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Area of Expertise <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="expertise_area" value="{{ old('expertise_area') }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('expertise_area') border-red-500 @enderror" 
                               placeholder="e.g., Software Development, Marketing, Finance" required>
                        @error('expertise_area')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Professional Bio <span class="text-red-500">*</span>
                        </label>
                        <textarea name="bio" rows="5" 
                                  class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('bio') border-red-500 @enderror" 
                                  placeholder="Tell us about your professional background, achievements, and what makes you a great mentor (minimum 100 characters)" required>{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Minimum 100 characters</p>
                    </div>

                    <!-- Years of Experience -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Years of Professional Experience <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="years_experience" value="{{ old('years_experience') }}" min="1" max="50"
                               class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('years_experience') border-red-500 @enderror" 
                               placeholder="e.g., 5" required>
                        @error('years_experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Industry -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Industry <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="industry" value="{{ old('industry') }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('industry') border-red-500 @enderror" 
                               placeholder="e.g., Technology, Healthcare, Finance" required>
                        @error('industry')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mentoring Approach -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Mentoring Approach <span class="text-red-500">*</span>
                        </label>
                        <textarea name="mentoring_approach" rows="4" 
                                  class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('mentoring_approach') border-red-500 @enderror" 
                                  placeholder="Describe your mentoring style and what mentees can expect from working with you (minimum 50 characters)" required>{{ old('mentoring_approach') }}</textarea>
                        @error('mentoring_approach')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Minimum 50 characters</p>
                    </div>

                    <!-- Availability -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Availability <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="availability" value="{{ old('availability') }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('availability') border-red-500 @enderror" 
                               placeholder="e.g., 5 hours per month, 2 sessions per week" required>
                        @error('availability')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LinkedIn URL -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            LinkedIn Profile URL
                        </label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('linkedin_url') border-red-500 @enderror" 
                               placeholder="https://linkedin.com/in/yourprofile">
                        @error('linkedin_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('phone') border-red-500 @enderror" 
                               placeholder="+234 XXX XXX XXXX">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('mentorship') }}" class="flex-1 py-4 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
