<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('employer.applications.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600 transition-colors mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Applications
                </a>
                <h1 class="text-3xl font-heading font-bold text-gray-900">Application Details</h1>
                <p class="text-gray-600 mt-1">Review and manage this application</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Applicant Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-start gap-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center text-primary-700 font-bold text-3xl shrink-0">
                                {{ substr($application->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $application->user->name }}</h2>
                                <p class="text-gray-600 mt-1">{{ $application->user->email }}</p>
                                
                                <div class="flex flex-wrap items-center gap-4 mt-4">
                                    @if($application->user->phone)
                                        <span class="text-sm text-gray-600 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $application->user->phone }}
                                        </span>
                                    @endif
                                    @if($application->user->location)
                                        <span class="text-sm text-gray-600 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $application->user->location }}
                                        </span>
                                    @endif
                                </div>

                                @if($application->user->experience_level || $application->user->field_of_study)
                                    <div class="flex flex-wrap gap-2 mt-4">
                                        @if($application->user->experience_level)
                                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">
                                                {{ ucfirst(str_replace('_', ' ', $application->user->experience_level)) }}
                                            </span>
                                        @endif
                                        @if($application->user->field_of_study)
                                            <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium border border-purple-100">
                                                {{ $application->user->field_of_study }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Job Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Applied For</h3>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 font-bold shrink-0">
                                {{ substr($application->job->company, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $application->job->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $application->job->company }}</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">{{ $application->job->type }}</span>
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">{{ $application->job->location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    @if($application->cover_letter)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Cover Letter</h3>
                            <div class="prose prose-sm max-w-none text-gray-700">
                                <p class="whitespace-pre-line">{{ $application->cover_letter }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Skills -->
                    @if($application->user->skills)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Skills</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $application->user->skills) as $skill)
                                    <span class="px-3 py-1.5 bg-primary-50 text-primary-700 rounded-lg text-sm font-medium border border-primary-100">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Employer Notes -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Internal Notes</h3>
                        <form action="{{ route('employer.applications.notes', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea name="notes" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 resize-none" placeholder="Add private notes about this applicant...">{{ $application->notes }}</textarea>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-lg transition-colors">
                                    Save Notes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Application Status</h3>
                        
                        <!-- Current Status -->
                        <div class="mb-6">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-bold 
                                @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                                @elseif($application->status === 'shortlisted') bg-purple-100 text-purple-800
                                @elseif($application->status === 'interviewed') bg-indigo-100 text-indigo-800
                                @elseif($application->status === 'offered') bg-green-100 text-green-800
                                @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>

                        <!-- Update Status -->
                        <form action="{{ route('employer.applications.status', $application) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="interviewed" {{ $application->status === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                    <option value="offered" {{ $application->status === 'offered' ? 'selected' : '' }}>Offered</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-lg transition-colors">
                                Update Status
                            </button>
                        </form>

                        <!-- Application Info -->
                        <div class="mt-6 pt-6 border-t border-gray-100 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Applied</span>
                                <span class="font-medium text-gray-900">{{ $application->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Time Ago</span>
                                <span class="font-medium text-gray-900">{{ $application->created_at->diffForHumans() }}</span>
                            </div>
                            @if($application->reviewed_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Reviewed</span>
                                    <span class="font-medium text-gray-900">{{ $application->reviewed_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-6 pt-6 border-t border-gray-100 space-y-2">
                            <form action="{{ route('employer.applications.status', $application) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="shortlisted">
                                <button type="submit" class="w-full py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold rounded-lg transition-colors border border-purple-200">
                                    Shortlist
                                </button>
                            </form>
                            <form action="{{ route('employer.applications.status', $application) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="w-full py-2 bg-red-50 hover:bg-red-100 text-red-700 font-bold rounded-lg transition-colors border border-red-200" onclick="return confirm('Are you sure you want to reject this application?')">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
