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
                <h1 class="text-3xl font-bold text-gray-900 mt-2">My Mentor Application</h1>
                <p class="text-gray-600 mt-1">Track the status of your mentor application</p>
            </div>

            @if(!$application)
                <!-- No Application -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Application Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't submitted a mentor application. Start your journey as a mentor today!</p>
                    <a href="{{ route('mentorship.apply') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Apply to Become a Mentor
                    </a>
                </div>
            @else
                <!-- Application Status Card -->
                <div class="mb-6">
                    @if($application->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-yellow-900 mb-1">Application Under Review</h3>
                                    <p class="text-yellow-700">Your application is being reviewed by our team. We'll notify you once a decision has been made.</p>
                                    <p class="text-yellow-600 text-sm mt-2">Submitted {{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($application->status === 'approved')
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-green-900 mb-1">Application Approved!</h3>
                                    <p class="text-green-700">Congratulations! Your application has been approved. You are now a mentor on SpeedJobs.</p>
                                    <p class="text-green-600 text-sm mt-2">Approved {{ $application->reviewed_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-red-900 mb-1">Application Not Approved</h3>
                                    <p class="text-red-700">Unfortunately, your application was not approved at this time.</p>
                                    <p class="text-red-600 text-sm mt-2">Reviewed {{ $application->reviewed_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Application Details -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Application Details</h2>

                    <div class="space-y-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Area of Expertise</p>
                            <p class="text-gray-900">{{ $application->expertise_area }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Professional Bio</p>
                            <p class="text-gray-900">{{ $application->bio }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Years of Experience</p>
                                <p class="text-gray-900">{{ $application->years_experience }} years</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Industry</p>
                                <p class="text-gray-900">{{ $application->industry }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Mentoring Approach</p>
                            <p class="text-gray-900">{{ $application->mentoring_approach }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Availability</p>
                            <p class="text-gray-900">{{ $application->availability }}</p>
                        </div>

                        @if($application->linkedin_url)
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">LinkedIn Profile</p>
                            <a href="{{ $application->linkedin_url }}" target="_blank" class="text-purple-600 hover:text-purple-700">
                                {{ $application->linkedin_url }}
                            </a>
                        </div>
                        @endif

                        @if($application->phone)
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Phone Number</p>
                            <p class="text-gray-900">{{ $application->phone }}</p>
                        </div>
                        @endif

                        @if($application->admin_notes)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-500 mb-1">Admin Notes</p>
                            <p class="text-gray-900">{{ $application->admin_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($application->status === 'rejected')
                <div class="mt-6 text-center">
                    <a href="{{ route('mentorship.apply') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg">
                        Submit New Application
                    </a>
                </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
