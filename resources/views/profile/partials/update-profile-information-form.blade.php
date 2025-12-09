<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information. A complete profile increases your visibility to employers.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Basic Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Contact Information -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="+234 XXX XXX XXXX" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location)" placeholder="City, Country" />
                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                </div>
            </div>
        </div>

        <!-- Education -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Education</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="university" :value="__('University/Institution')" />
                    <x-text-input id="university" name="university" type="text" class="mt-1 block w-full" :value="old('university', $user->university)" placeholder="e.g. University of Lagos" />
                    <x-input-error class="mt-2" :messages="$errors->get('university')" />
                </div>

                <div>
                    <x-input-label for="field_of_study" :value="__('Field of Study')" />
                    <x-text-input id="field_of_study" name="field_of_study" type="text" class="mt-1 block w-full" :value="old('field_of_study', $user->field_of_study)" placeholder="e.g. Computer Science" />
                    <x-input-error class="mt-2" :messages="$errors->get('field_of_study')" />
                </div>

                <div>
                    <x-input-label for="graduation_year" :value="__('Graduation Year')" />
                    <select id="graduation_year" name="graduation_year" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">Select Year</option>
                        @for($year = date('Y') + 5; $year >= date('Y') - 20; $year--)
                            <option value="{{ $year }}" {{ old('graduation_year', $user->graduation_year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('graduation_year')" />
                </div>

                <div>
                    <x-input-label for="experience_level" :value="__('Experience Level')" />
                    <select id="experience_level" name="experience_level" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">Select Level</option>
                        <option value="student" {{ old('experience_level', $user->experience_level) == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="fresh_graduate" {{ old('experience_level', $user->experience_level) == 'fresh_graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                        <option value="entry_level" {{ old('experience_level', $user->experience_level) == 'entry_level' ? 'selected' : '' }}>Entry Level (0-2 years)</option>
                        <option value="mid_level" {{ old('experience_level', $user->experience_level) == 'mid_level' ? 'selected' : '' }}>Mid Level (3-5 years)</option>
                        <option value="senior_level" {{ old('experience_level', $user->experience_level) == 'senior_level' ? 'selected' : '' }}>Senior Level (5+ years)</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('experience_level')" />
                </div>
            </div>
        </div>

        <!-- Skills -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Skills</h3>
            <div>
                <x-input-label for="skills" :value="__('Your Skills')" />
                <textarea id="skills" name="skills" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="e.g. JavaScript, Python, Project Management, Communication">{{ old('skills', $user->skills) }}</textarea>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Separate skills with commas. These help employers find you.</p>
                <x-input-error class="mt-2" :messages="$errors->get('skills')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
