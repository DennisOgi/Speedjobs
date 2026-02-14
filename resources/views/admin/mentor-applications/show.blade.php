<x-app-layout>
    <div class="min-h-screen py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.mentor-applications.index') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-2 inline-flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Applications
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Mentor Application Review</h1>
            </div>

            <!-- Status Card -->
            <div class="mb-6">
                @if($application->status === 'pending')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-yellow-900">Pending Review</h3>
                                    <p class="text-yellow-700 text-sm">This application is awaiting your decision</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($application->status === 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-green-900">Approved</h3>
                                <p class="text-green-700 text-sm">
                                    Approved by {{ $application->reviewer->name }} on {{ $application->reviewed_at->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-900">Rejected</h3>
                                <p class="text-red-700 text-sm">
                                    Rejected by {{ $application->reviewer->name }} on {{ $application->reviewed_at->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Applicant Info -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Applicant Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Name</p>
                        <p class="text-gray-900">{{ $application->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                        <p class="text-gray-900">{{ $application->user->email }}</p>
                    </div>
                    @if($application->phone)
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Phone</p>
                        <p class="text-gray-900">{{ $application->phone }}</p>
                    </div>
                    @endif
                    @if($application->linkedin_url)
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">LinkedIn</p>
                        <a href="{{ $application->linkedin_url }}" target="_blank" class="text-purple-600 hover:text-purple-700">
                            View Profile →
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Application Details -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Application Details</h2>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Expertise Area</p>
                            <p class="text-gray-900">{{ $application->expertise_area }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Industry</p>
                            <p class="text-gray-900">{{ $application->industry }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Years of Experience</p>
                            <p class="text-gray-900">{{ $application->years_experience }} years</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Professional Bio</p>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-4">{{ $application->bio }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Mentoring Approach</p>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-4">{{ $application->mentoring_approach }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Availability</p>
                        <p class="text-gray-900">{{ $application->availability }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Submitted</p>
                        <p class="text-gray-900">{{ $application->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>

            @if($application->admin_notes)
            <!-- Admin Notes -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Admin Notes</h2>
                <p class="text-gray-900 bg-gray-50 rounded-lg p-4">{{ $application->admin_notes }}</p>
            </div>
            @endif

            <!-- Actions -->
            @if($application->status === 'pending')
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Review Decision</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Approve Form -->
                    <form action="{{ route('admin.mentor-applications.approve', $application) }}" method="POST" class="border border-green-200 rounded-xl p-6 bg-green-50">
                        @csrf
                        <h3 class="font-bold text-green-900 mb-4">Approve Application</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" placeholder="Add any notes about this approval..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all">
                            Approve Application
                        </button>
                    </form>

                    <!-- Reject Form -->
                    <form action="{{ route('admin.mentor-applications.reject', $application) }}" method="POST" class="border border-red-200 rounded-xl p-6 bg-red-50">
                        @csrf
                        <h3 class="font-bold text-red-900 mb-4">Reject Application</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection <span class="text-red-500">*</span></label>
                            <textarea name="admin_notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Explain why this application is being rejected..." required></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all">
                            Reject Application
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
