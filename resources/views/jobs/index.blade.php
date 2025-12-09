<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="w-full lg:w-1/4" x-data="{ showFilters: false }">
                    <!-- Mobile Filter Toggle -->
                    <button @click="showFilters = !showFilters" class="lg:hidden w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm mb-4 text-gray-700 font-medium">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            Filters
                        </span>
                        <svg class="w-5 h-5 transform transition-transform" :class="{'rotate-180': showFilters}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6 lg:sticky lg:top-24 transition-all hover:shadow-xl hidden lg:block" :class="{'!block': showFilters}">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="font-heading font-bold text-xl text-gray-900">Filters</h2>
                            <a href="{{ route('jobs.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors">Reset</a>
                        </div>

                        <form action="{{ route('jobs.index') }}" method="GET" id="filter-form">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <!-- Category Filter -->
                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Category</h3>
                                <div class="space-y-3">
                                    @foreach($categories as $category)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="category" value="{{ $category }}" {{ request('category') == $category ? 'checked' : '' }} class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 cursor-pointer" onchange="this.form.submit()">
                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ $category }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Job Type Filter -->
                            <div class="mb-8">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Job Type</h3>
                                <div class="space-y-3">
                                    @foreach($types as $type)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="type" value="{{ $type }}" {{ request('type') == $type ? 'checked' : '' }} class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 cursor-pointer" onchange="this.form.submit()">
                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ $type }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div class="mb-6">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Location</h3>
                                <div class="relative">
                                    <input type="text" name="location" value="{{ request('location') }}" placeholder="e.g. Lagos" class="w-full rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm transition-all">
                                    <button type="submit" class="absolute right-2 top-1.5 p-1 text-gray-400 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Job Listings -->
                <div class="w-full lg:w-3/4">
                    <!-- Search Bar -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-2 mb-8">
                        <form action="{{ route('jobs.index') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                            <div class="flex-1 relative">
                                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by job title, company, or keywords..." class="w-full pl-12 rounded-xl border-transparent bg-transparent focus:border-transparent focus:ring-0 text-gray-900 placeholder-gray-400 h-12">
                            </div>
                            <button type="submit" class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Results Count -->
                    <div class="flex justify-between items-center mb-6 px-2">
                        <p class="text-gray-600">Showing <span class="font-bold text-gray-900">{{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }}</span> of <span class="font-bold text-gray-900">{{ $jobs->total() }}</span> jobs</p>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">Sort by:</span>
                            <select class="text-sm border-none bg-transparent font-medium text-gray-900 focus:ring-0 cursor-pointer hover:text-primary-600 transition-colors">
                                <option>Newest</option>
                                <option>Relevant</option>
                            </select>
                        </div>
                    </div>

                    <!-- Job Cards -->
                    <div class="space-y-5">
                        @forelse($jobs as $job)
                        <div class="group bg-white/90 backdrop-blur-sm rounded-2xl shadow-sm hover:shadow-xl border border-white/20 p-6 transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                            @if($job->is_featured)
                                <div class="absolute top-0 right-0">
                                    <div class="bg-gradient-to-bl from-accent to-accent-hover text-white text-[10px] font-bold px-4 py-1 rounded-bl-xl shadow-sm uppercase tracking-wider">Featured</div>
                                </div>
                            @endif
                            
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Company Logo Placeholder -->
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl flex items-center justify-center text-2xl font-bold text-gray-400 shrink-0 shadow-inner border border-gray-100 group-hover:scale-105 transition-transform duration-300">
                                    {{ substr($job->company, 0, 1) }}
                                </div>

                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
                                        <div>
                                            <h3 class="text-xl font-heading font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                                                <a href="{{ route('jobs.show', $job) }}" class="focus:outline-none">
                                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                                    {{ $job->title }}
                                                </a>
                                            </h3>
                                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2 text-sm text-gray-500">
                                                <span class="font-medium text-gray-900 flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    {{ $job->company }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $job->location }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary-50 text-primary-700 border border-primary-100">
                                                {{ $job->type }}
                                            </span>
                                            <span class="text-sm font-bold text-gray-900">{{ $job->salary_range }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                                        <div class="flex gap-2">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                                                {{ $job->category }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                                                {{ $job->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <span class="text-sm font-bold text-primary-600 group-hover:translate-x-1 transition-transform flex items-center gap-1">
                                            Apply Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-16 bg-white/80 backdrop-blur-lg rounded-2xl border border-white/20 shadow-sm">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="mt-2 text-lg font-bold text-gray-900">No jobs found</h3>
                            <p class="mt-1 text-gray-500">Try adjusting your search or filters to find what you're looking for.</p>
                            <a href="{{ route('jobs.index') }}" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Clear Filters
                            </a>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
