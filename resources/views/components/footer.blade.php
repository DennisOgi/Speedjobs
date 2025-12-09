<footer class="bg-gray-900 text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Brand Column -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="SpeedJobs Africa" class="h-28 w-auto">
                    </a>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Connecting African talent with global opportunities. Build your career, find your dream job, and grow your skills with SpeedJobs Africa.
                </p>
                <div class="flex space-x-4">
                    <!-- Social Icons -->
                    <a href="https://twitter.com/speedjobsafrica" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                    </a>
                </div>
            </div>

            <!-- Links Column 1 -->
            <div>
                <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase mb-4">For Jobseekers</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('jobs.index') }}" class="text-gray-400 hover:text-primary-400 transition-colors">Browse Jobs</a></li>
                    <li><a href="{{ route('resume.create') }}" class="text-gray-400 hover:text-primary-400 transition-colors">Resume Builder</a></li>
                    <li><a href="{{ route('career-advice') }}" class="text-gray-400 hover:text-primary-400 transition-colors">Career Advice</a></li>
                    <li><a href="{{ route('skill-assessments') }}" class="text-gray-400 hover:text-primary-400 transition-colors">Skill Assessments</a></li>
                </ul>
            </div>

            <!-- Links Column 2 -->
            <div>
                <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase mb-4">For Employers</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('jobs.create') }}" class="text-gray-400 hover:text-primary-400 transition-colors">Post a Job</a></li>
                    <li><a href="{{ route('browse-candidates') }}" class="text-gray-400 hover:text-primary-400 transition-colors">Browse Candidates</a></li>
                </ul>
            </div>

            <!-- Newsletter Column -->
            <div>
                <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase mb-4">Stay Updated</h3>
                <p class="text-gray-400 text-sm mb-4">Get the latest job alerts and career tips directly in your inbox.</p>
                <form class="flex flex-col gap-2">
                    <input type="email" placeholder="Enter your email" class="bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-gray-500">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} SpeedJobs Africa. All rights reserved.
            </p>
            <div class="flex space-x-6 text-sm text-gray-500">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
