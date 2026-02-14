<x-app-layout>
    <div class="min-h-screen py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">My Career Pathways</h1>
                        <p class="text-gray-600 mt-1">Track your AI-powered career development plans</p>
                    </div>
                    <a href="{{ route('career-planning.index') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Pathway
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Pathways</p>
                                <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Active</p>
                                <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Completed</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $stats['completed'] }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Avg Progress</p>
                                <p class="text-3xl font-bold text-orange-600">{{ round($stats['avg_progress']) }}%</p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($pathways->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Career Pathways Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Start your career planning journey by creating your first AI-powered career pathway.</p>
                    <a href="{{ route('career-planning.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Your First Pathway
                    </a>
                </div>
            @else
                <!-- Current Active Pathway -->
                @if($currentPathway)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Current Active Pathway</h2>
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="inline-flex items-center px-3 py-1 bg-white/20 rounded-full text-sm mb-3">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Active
                                </div>
                                <h3 class="text-2xl font-bold mb-2">{{ $currentPathway->target_role }}</h3>
                                <p class="text-blue-100">From: {{ $currentPathway->current_role }}</p>
                                <p class="text-blue-100 text-sm mt-1">Started {{ $currentPathway->ai_generated_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-5xl font-bold mb-2">{{ $currentPathway->progress_percentage }}%</div>
                                <p class="text-blue-100 text-sm">Progress</p>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-white/20 rounded-full h-3 mb-6">
                            <div class="bg-white rounded-full h-3 transition-all duration-500" style="width: {{ $currentPathway->progress_percentage }}%"></div>
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="{{ route('pathways.show', $currentPathway) }}" class="flex-1 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-all text-center">
                                View Details
                            </a>
                            <button onclick="if(confirm('Mark this pathway as completed?')) document.getElementById('complete-form-{{ $currentPathway->id }}').submit();" class="px-6 py-3 bg-white/20 text-white font-semibold rounded-lg hover:bg-white/30 transition-all">
                                Mark Complete
                            </button>
                            <form id="complete-form-{{ $currentPathway->id }}" action="{{ route('pathways.show', $currentPathway) }}" method="POST" class="hidden">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- All Pathways -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">All Career Pathways</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($pathways as $pathway)
                        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-xl transition-all">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $pathway->target_role }}</h3>
                                        @if($pathway->status === 'active')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Active</span>
                                        @elseif($pathway->status === 'completed')
                                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">Completed</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">Abandoned</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">From: {{ $pathway->current_role }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $pathway->ai_generated_at->format('M j, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-blue-600">{{ $pathway->progress_percentage }}%</div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-full h-2 transition-all" style="width: {{ $pathway->progress_percentage }}%"></div>
                            </div>
                            
                            <!-- Quick Info -->
                            @if(isset($pathway->pathway_data['milestones']) || isset($pathway->pathway_data['skills_required']))
                            <div class="flex gap-4 mb-4 text-sm text-gray-600">
                                @if(isset($pathway->pathway_data['milestones']))
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ count($pathway->pathway_data['milestones']) }} milestones
                                </div>
                                @endif
                                @if(isset($pathway->pathway_data['skills_required']))
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ count($pathway->pathway_data['skills_required']) }} skills
                                </div>
                                @endif
                            </div>
                            @endif
                            
                            <a href="{{ route('pathways.show', $pathway) }}" class="block w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all text-center">
                                View Pathway
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($pathways->hasPages())
                    <div class="mt-8">
                        {{ $pathways->links() }}
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
