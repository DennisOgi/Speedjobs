<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create your account</h1>
        <p class="mt-3 text-slate-500">Join thousands of professionals across Africa</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ role: '{{ old('role', 'jobseeker') }}', step: 1 }">
        @csrf

        <!-- Account Type Selection -->
        <div class="space-y-4">
            <label class="block text-sm font-semibold text-slate-700">I want to</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative cursor-pointer group">
                    <input type="radio" name="role" value="jobseeker" x-model="role" class="sr-only peer">
                    <div class="p-5 border-2 rounded-2xl text-center transition-all duration-300 peer-checked:border-primary-500 peer-checked:bg-gradient-to-br peer-checked:from-primary-50 peer-checked:to-primary-100 border-slate-200 hover:border-slate-300 hover:bg-slate-50 group-hover:shadow-md">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 peer-checked:from-primary-500 peer-checked:to-primary-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-900">Find a Job</p>
                        <p class="text-xs text-slate-500 mt-1">Discover opportunities</p>
                    </div>
                </label>
                <label class="relative cursor-pointer group">
                    <input type="radio" name="role" value="employer" x-model="role" class="sr-only peer">
                    <div class="p-5 border-2 rounded-2xl text-center transition-all duration-300 peer-checked:border-primary-500 peer-checked:bg-gradient-to-br peer-checked:from-primary-50 peer-checked:to-primary-100 border-slate-200 hover:border-slate-300 hover:bg-slate-50 group-hover:shadow-md">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <p class="font-bold text-slate-900">Hire Talent</p>
                        <p class="text-xs text-slate-500 mt-1">Post job openings</p>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Personal Information Section -->
        <div class="space-y-5">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200"
                           placeholder="John Doe">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200"
                           placeholder="you@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone & Location Row -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Phone</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200"
                           placeholder="+234 800 000 0000">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <div>
                    <label for="location" class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}"
                           class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200"
                           placeholder="Lagos, Nigeria">
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Education & Experience Section (Jobseekers Only) -->
        <div class="space-y-5 p-5 bg-slate-50 rounded-2xl border border-slate-100" x-show="role === 'jobseeker'" x-transition>
            <div class="flex items-center gap-3 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Education & Experience</h3>
                    <p class="text-xs text-slate-500">Help us match you with relevant opportunities</p>
                </div>
            </div>
            
            <!-- University -->
            <div>
                <label for="university" class="block text-sm font-semibold text-slate-700 mb-2">University/Institution</label>
                <select id="university" name="university" class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl text-slate-900 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200 appearance-none cursor-pointer">
                    <option value="">Select your university</option>
                    <option value="University of Lagos" {{ old('university') == 'University of Lagos' ? 'selected' : '' }}>University of Lagos</option>
                    <option value="University of Ibadan" {{ old('university') == 'University of Ibadan' ? 'selected' : '' }}>University of Ibadan</option>
                    <option value="Obafemi Awolowo University" {{ old('university') == 'Obafemi Awolowo University' ? 'selected' : '' }}>Obafemi Awolowo University</option>
                    <option value="University of Nigeria, Nsukka" {{ old('university') == 'University of Nigeria, Nsukka' ? 'selected' : '' }}>University of Nigeria, Nsukka</option>
                    <option value="Ahmadu Bello University" {{ old('university') == 'Ahmadu Bello University' ? 'selected' : '' }}>Ahmadu Bello University</option>
                    <option value="Covenant University" {{ old('university') == 'Covenant University' ? 'selected' : '' }}>Covenant University</option>
                    <option value="Lagos State University" {{ old('university') == 'Lagos State University' ? 'selected' : '' }}>Lagos State University</option>
                    <option value="University of Benin" {{ old('university') == 'University of Benin' ? 'selected' : '' }}>University of Benin</option>
                    <option value="University of Port Harcourt" {{ old('university') == 'University of Port Harcourt' ? 'selected' : '' }}>University of Port Harcourt</option>
                    <option value="Federal University of Technology, Akure" {{ old('university') == 'Federal University of Technology, Akure' ? 'selected' : '' }}>Federal University of Technology, Akure</option>
                    <option value="Other" {{ old('university') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-input-error :messages="$errors->get('university')" class="mt-2" />
            </div>

            <!-- Field of Study & Experience Level Row -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="field_of_study" class="block text-sm font-semibold text-slate-700 mb-2">Field of Study</label>
                    <select id="field_of_study" name="field_of_study" class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl text-slate-900 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200 appearance-none cursor-pointer">
                        <option value="">Select field</option>
                        <option value="Computer Science" {{ old('field_of_study') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                        <option value="Engineering" {{ old('field_of_study') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                        <option value="Business Administration" {{ old('field_of_study') == 'Business Administration' ? 'selected' : '' }}>Business</option>
                        <option value="Economics" {{ old('field_of_study') == 'Economics' ? 'selected' : '' }}>Economics</option>
                        <option value="Law" {{ old('field_of_study') == 'Law' ? 'selected' : '' }}>Law</option>
                        <option value="Medicine" {{ old('field_of_study') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                        <option value="Other" {{ old('field_of_study') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('field_of_study')" class="mt-2" />
                </div>
                <div>
                    <label for="experience_level" class="block text-sm font-semibold text-slate-700 mb-2">Experience</label>
                    <select id="experience_level" name="experience_level" class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl text-slate-900 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200 appearance-none cursor-pointer">
                        <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry (0-2 yrs)</option>
                        <option value="intermediate" {{ old('experience_level') == 'intermediate' ? 'selected' : '' }}>Mid (3-5 yrs)</option>
                        <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior (5+ yrs)</option>
                    </select>
                    <x-input-error :messages="$errors->get('experience_level')" class="mt-2" />
                </div>
            </div>

            <!-- Graduation Year (hidden input) -->
            <input type="hidden" name="graduation_year" value="{{ old('graduation_year', date('Y')) }}">
            <input type="hidden" name="skills" value="{{ old('skills', '') }}">
        </div>

        <!-- Password Section -->
        <div class="space-y-5">
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <div class="relative" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                           class="w-full pl-12 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200"
                           placeholder="Create a strong password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="mt-2 text-xs text-slate-500">Minimum 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-200"
                           placeholder="Confirm your password">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Terms -->
        <div class="flex items-start gap-3">
            <div class="relative mt-0.5">
                <input id="terms" type="checkbox" name="terms" required class="sr-only peer">
                <div class="w-5 h-5 bg-slate-100 border-2 border-slate-300 rounded-md peer-checked:bg-primary-600 peer-checked:border-primary-600 transition-all duration-200 cursor-pointer" onclick="document.getElementById('terms').click()"></div>
                <svg class="absolute top-0.5 left-0.5 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <label for="terms" class="text-sm text-slate-600 cursor-pointer">
                I agree to the <a href="#" class="text-primary-600 hover:text-primary-700 font-semibold">Terms of Service</a> and <a href="#" class="text-primary-600 hover:text-primary-700 font-semibold">Privacy Policy</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
            <span>Create Account</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </button>

        <!-- Sign In Link -->
        <p class="text-center text-slate-500">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-primary-600 hover:text-primary-700 transition-colors">
                Sign in
            </a>
        </p>
    </form>
</x-guest-layout>
