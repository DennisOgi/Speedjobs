<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 items-center h-20">
            <!-- Logo (Left) -->
            <div class="flex items-center justify-start">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>

            <!-- Centered Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:justify-center">
                <div class="flex space-x-8">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                        {{ __('Find a Job') }}
                    </x-nav-link>
                    <x-nav-link :href="route('career-services')" :active="request()->routeIs('career-services')">
                        {{ __('Career Services') }}
                    </x-nav-link>
                    <x-nav-link :href="route('skill-up')" :active="request()->routeIs('skill-up')">
                        {{ __('Skill Up') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- User Dropdown (Right) -->
            <div class="flex items-center justify-end">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('courses.my-courses')">
                                {{ __('My Learning') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('counseling.index')">
                                {{ __('My Requests') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('counselors.my-bookings')">
                                {{ __('My Bookings') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('banner-applications.index')">
                                {{ __('My Applications') }}
                            </x-dropdown-link>

                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        {{ __('Admin Dashboard') }}
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.counseling.index')">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        {{ __('Manage Requests') }}
                                    </span>
                                </x-dropdown-link>
                            @endif

                            @if(Auth::user()->role === 'employer')
                                <x-dropdown-link :href="route('employer.dashboard')">
                                    {{ __('Employer Dashboard') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Edit Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                {{ __('Find a Job') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.index')">
                {{ __('Courses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('counselors.index')" :active="request()->routeIs('counselors.index')">
                {{ __('Career Counseling') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('career-services')" :active="request()->routeIs('career-services')">
                {{ __('Career Services') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('skill-up')" :active="request()->routeIs('skill-up')">
                {{ __('Skill Up') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
