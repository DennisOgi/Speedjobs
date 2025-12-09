<x-app-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <!-- Hero Section -->
        <div class="relative py-24 sm:py-32 overflow-hidden isolate">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-indigo-900/80 via-indigo-900/60 to-indigo-900/80"></div>
            
            <!-- Decorative Elements -->
            <div class="absolute inset-y-0 left-1/2 -z-10 ml-16 w-[200%] origin-bottom-right skew-x-[30deg] bg-white/5 shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:ml-28 lg:ml-0 xl:ml-16 xl:origin-center"></div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-heading font-bold tracking-tight text-white sm:text-6xl drop-shadow-sm">{{ __('content.learning_hub.header.title') }}</h1>
                <p class="mt-6 text-lg leading-8 text-gray-200 max-w-2xl mx-auto drop-shadow-sm">{{ __('content.learning_hub.header.description') }}</p>
            </div>
        </div>

        <div class="bg-gray-50 min-h-screen py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Featured Courses -->
                <div class="mb-12">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Featured Courses</h2>
                        <a href="{{ route('courses.index') }}" class="text-primary-600 font-medium hover:text-primary-700">View All Courses</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Course Card 1 -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                            <div class="relative h-48 bg-gray-200">
                                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80" alt="Web Development" class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded text-xs font-bold text-gray-900 shadow-sm">
                                    $49.99
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded uppercase">Tech</span>
                                    <span class="text-xs text-gray-500">4.8 (1.2k reviews)</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">Full Stack Web Development Bootcamp</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">Learn HTML, CSS, JavaScript, React, and Node.js from scratch. Build real-world projects.</p>
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-200"></div>
                                        <span class="text-sm font-medium text-gray-900">John Doe</span>
                                    </div>
                                    <a href="{{ route('courses.index') }}" class="text-primary-600 font-bold text-sm hover:text-primary-700">View Course</a>
                                </div>
                            </div>
                        </div>

                        <!-- Course Card 2 -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                            <div class="relative h-48 bg-gray-200">
                                <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Digital Marketing" class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded text-xs font-bold text-gray-900 shadow-sm">
                                    $29.99
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs font-bold rounded uppercase">Marketing</span>
                                    <span class="text-xs text-gray-500">4.6 (850 reviews)</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">Digital Marketing Masterclass</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">Master SEO, Social Media Marketing, Email Marketing, and Analytics.</p>
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-200"></div>
                                        <span class="text-sm font-medium text-gray-900">Jane Smith</span>
                                    </div>
                                    <a href="{{ route('courses.index') }}" class="text-primary-600 font-bold text-sm hover:text-primary-700">View Course</a>
                                </div>
                            </div>
                        </div>

                        <!-- Course Card 3 -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                            <div class="relative h-48 bg-gray-200">
                                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Data Science" class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded text-xs font-bold text-gray-900 shadow-sm">
                                    $59.99
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded uppercase">Data</span>
                                    <span class="text-xs text-gray-500">4.9 (2.1k reviews)</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">Data Science & Machine Learning</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">Learn Python, Pandas, Scikit-Learn, and build predictive models.</p>
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-200"></div>
                                        <span class="text-sm font-medium text-gray-900">Alex Johnson</span>
                                    </div>
                                    <a href="{{ route('courses.index') }}" class="text-primary-600 font-bold text-sm hover:text-primary-700">View Course</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Browse by Category</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('courses.index') }}" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all text-center group">
                            <div class="w-12 h-12 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Development</h3>
                            <p class="text-xs text-gray-500 mt-1">Browse Courses</p>
                        </a>
                        <a href="{{ route('courses.index') }}" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all text-center group">
                            <div class="w-12 h-12 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Business</h3>
                            <p class="text-xs text-gray-500 mt-1">Browse Courses</p>
                        </a>
                        <a href="{{ route('courses.index') }}" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all text-center group">
                            <div class="w-12 h-12 mx-auto bg-pink-50 text-pink-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Design</h3>
                            <p class="text-xs text-gray-500 mt-1">Browse Courses</p>
                        </a>
                        <a href="{{ route('courses.index') }}" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all text-center group">
                            <div class="w-12 h-12 mx-auto bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Finance</h3>
                            <p class="text-xs text-gray-500 mt-1">Browse Courses</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
