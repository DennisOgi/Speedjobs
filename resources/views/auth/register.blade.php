<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Create Your Account</h2>
        <p class="mt-2 text-sm text-gray-600">Join SpeedJobs Africa and accelerate your career</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ role: '{{ old('role', 'jobseeker') }}' }">
        @csrf

        <!-- Account Type Selection -->
        <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200 pb-2">I want to</h3>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="jobseeker" x-model="role" class="sr-only peer">
                    <div class="p-4 border-2 rounded-xl text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 border-gray-200 hover:border-gray-300">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400 peer-checked:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <p class="font-bold text-gray-900">Find a Job</p>
                        <p class="text-xs text-gray-500 mt-1">I'm looking for opportunities</p>
                    </div>
                </label>
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="employer" x-model="role" class="sr-only peer">
                    <div class="p-4 border-2 rounded-xl text-center transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 border-gray-200 hover:border-gray-300">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400 peer-checked:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <p class="font-bold text-gray-900">Hire Talent</p>
                        <p class="text-xs text-gray-500 mt-1">I want to post jobs</p>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Personal Information Section -->
        <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200 pb-2">Personal Information</h3>
            
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="john@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" placeholder="+234 800 000 0000" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Location -->
            <div>
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="Lagos, Nigeria" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>
        </div>

        <!-- Education & Experience Section (Jobseekers Only) -->
        <div class="space-y-4" x-show="role === 'jobseeker'" x-transition>
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200 pb-2">Education & Experience</h3>
            
            <!-- University -->
            <div>
                <x-input-label for="university" :value="__('University/Institution')" />
                <select id="university" name="university" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 rounded-lg shadow-sm py-2.5 block mt-1 w-full">
                    <option value="">Select your university</option>
                    <option value="Abia State University" {{ old('university') == 'Abia State University' ? 'selected' : '' }}>Abia State University</option>
                    <option value="Abubakar Tafawa Balewa University" {{ old('university') == 'Abubakar Tafawa Balewa University' ? 'selected' : '' }}>Abubakar Tafawa Balewa University</option>
                    <option value="Achievers University" {{ old('university') == 'Achievers University' ? 'selected' : '' }}>Achievers University</option>
                    <option value="Adamawa State University" {{ old('university') == 'Adamawa State University' ? 'selected' : '' }}>Adamawa State University</option>
                    <option value="Adekunle Ajasin University" {{ old('university') == 'Adekunle Ajasin University' ? 'selected' : '' }}>Adekunle Ajasin University</option>
                    <option value="Adeleke University" {{ old('university') == 'Adeleke University' ? 'selected' : '' }}>Adeleke University</option>
                    <option value="Ahmadu Bello University" {{ old('university') == 'Ahmadu Bello University' ? 'selected' : '' }}>Ahmadu Bello University</option>
                    <option value="Ajayi Crowther University" {{ old('university') == 'Ajayi Crowther University' ? 'selected' : '' }}>Ajayi Crowther University</option>
                    <option value="Akwa Ibom State University" {{ old('university') == 'Akwa Ibom State University' ? 'selected' : '' }}>Akwa Ibom State University</option>
                    <option value="Ambrose Alli University" {{ old('university') == 'Ambrose Alli University' ? 'selected' : '' }}>Ambrose Alli University</option>
                    <option value="American University of Nigeria" {{ old('university') == 'American University of Nigeria' ? 'selected' : '' }}>American University of Nigeria</option>
                    <option value="Babcock University" {{ old('university') == 'Babcock University' ? 'selected' : '' }}>Babcock University</option>
                    <option value="Bayero University Kano" {{ old('university') == 'Bayero University Kano' ? 'selected' : '' }}>Bayero University Kano</option>
                    <option value="Baze University" {{ old('university') == 'Baze University' ? 'selected' : '' }}>Baze University</option>
                    <option value="Bells University of Technology" {{ old('university') == 'Bells University of Technology' ? 'selected' : '' }}>Bells University of Technology</option>
                    <option value="Benson Idahosa University" {{ old('university') == 'Benson Idahosa University' ? 'selected' : '' }}>Benson Idahosa University</option>
                    <option value="Benue State University" {{ old('university') == 'Benue State University' ? 'selected' : '' }}>Benue State University</option>
                    <option value="Bowen University" {{ old('university') == 'Bowen University' ? 'selected' : '' }}>Bowen University</option>
                    <option value="Caleb University" {{ old('university') == 'Caleb University' ? 'selected' : '' }}>Caleb University</option>
                    <option value="Caritas University" {{ old('university') == 'Caritas University' ? 'selected' : '' }}>Caritas University</option>
                    <option value="Chukwuemeka Odumegwu Ojukwu University" {{ old('university') == 'Chukwuemeka Odumegwu Ojukwu University' ? 'selected' : '' }}>Chukwuemeka Odumegwu Ojukwu University</option>
                    <option value="Covenant University" {{ old('university') == 'Covenant University' ? 'selected' : '' }}>Covenant University</option>
                    <option value="Crawford University" {{ old('university') == 'Crawford University' ? 'selected' : '' }}>Crawford University</option>
                    <option value="Delta State University" {{ old('university') == 'Delta State University' ? 'selected' : '' }}>Delta State University</option>
                    <option value="Ebonyi State University" {{ old('university') == 'Ebonyi State University' ? 'selected' : '' }}>Ebonyi State University</option>
                    <option value="Ekiti State University" {{ old('university') == 'Ekiti State University' ? 'selected' : '' }}>Ekiti State University</option>
                    <option value="Enugu State University of Science and Technology" {{ old('university') == 'Enugu State University of Science and Technology' ? 'selected' : '' }}>Enugu State University of Science and Technology</option>
                    <option value="Federal University of Agriculture, Abeokuta" {{ old('university') == 'Federal University of Agriculture, Abeokuta' ? 'selected' : '' }}>Federal University of Agriculture, Abeokuta</option>
                    <option value="Federal University of Petroleum Resources" {{ old('university') == 'Federal University of Petroleum Resources' ? 'selected' : '' }}>Federal University of Petroleum Resources</option>
                    <option value="Federal University of Technology, Akure" {{ old('university') == 'Federal University of Technology, Akure' ? 'selected' : '' }}>Federal University of Technology, Akure</option>
                    <option value="Federal University of Technology, Minna" {{ old('university') == 'Federal University of Technology, Minna' ? 'selected' : '' }}>Federal University of Technology, Minna</option>
                    <option value="Federal University of Technology, Owerri" {{ old('university') == 'Federal University of Technology, Owerri' ? 'selected' : '' }}>Federal University of Technology, Owerri</option>
                    <option value="Federal University, Dutse" {{ old('university') == 'Federal University, Dutse' ? 'selected' : '' }}>Federal University, Dutse</option>
                    <option value="Federal University, Kashere" {{ old('university') == 'Federal University, Kashere' ? 'selected' : '' }}>Federal University, Kashere</option>
                    <option value="Federal University, Lafia" {{ old('university') == 'Federal University, Lafia' ? 'selected' : '' }}>Federal University, Lafia</option>
                    <option value="Federal University, Lokoja" {{ old('university') == 'Federal University, Lokoja' ? 'selected' : '' }}>Federal University, Lokoja</option>
                    <option value="Federal University, Otuoke" {{ old('university') == 'Federal University, Otuoke' ? 'selected' : '' }}>Federal University, Otuoke</option>
                    <option value="Federal University, Oye-Ekiti" {{ old('university') == 'Federal University, Oye-Ekiti' ? 'selected' : '' }}>Federal University, Oye-Ekiti</option>
                    <option value="Federal University, Wukari" {{ old('university') == 'Federal University, Wukari' ? 'selected' : '' }}>Federal University, Wukari</option>
                    <option value="Fountain University" {{ old('university') == 'Fountain University' ? 'selected' : '' }}>Fountain University</option>
                    <option value="Godfrey Okoye University" {{ old('university') == 'Godfrey Okoye University' ? 'selected' : '' }}>Godfrey Okoye University</option>
                    <option value="Gombe State University" {{ old('university') == 'Gombe State University' ? 'selected' : '' }}>Gombe State University</option>
                    <option value="Ibrahim Badamasi Babangida University" {{ old('university') == 'Ibrahim Badamasi Babangida University' ? 'selected' : '' }}>Ibrahim Badamasi Babangida University</option>
                    <option value="Igbinedion University" {{ old('university') == 'Igbinedion University' ? 'selected' : '' }}>Igbinedion University</option>
                    <option value="Imo State University" {{ old('university') == 'Imo State University' ? 'selected' : '' }}>Imo State University</option>
                    <option value="Joseph Ayo Babalola University" {{ old('university') == 'Joseph Ayo Babalola University' ? 'selected' : '' }}>Joseph Ayo Babalola University</option>
                    <option value="Kaduna State University" {{ old('university') == 'Kaduna State University' ? 'selected' : '' }}>Kaduna State University</option>
                    <option value="Kano University of Science and Technology" {{ old('university') == 'Kano University of Science and Technology' ? 'selected' : '' }}>Kano University of Science and Technology</option>
                    <option value="Kebbi State University of Science and Technology" {{ old('university') == 'Kebbi State University of Science and Technology' ? 'selected' : '' }}>Kebbi State University of Science and Technology</option>
                    <option value="Kogi State University" {{ old('university') == 'Kogi State University' ? 'selected' : '' }}>Kogi State University</option>
                    <option value="Kwara State University" {{ old('university') == 'Kwara State University' ? 'selected' : '' }}>Kwara State University</option>
                    <option value="Ladoke Akintola University of Technology" {{ old('university') == 'Ladoke Akintola University of Technology' ? 'selected' : '' }}>Ladoke Akintola University of Technology</option>
                    <option value="Lagos State University" {{ old('university') == 'Lagos State University' ? 'selected' : '' }}>Lagos State University</option>
                    <option value="Landmark University" {{ old('university') == 'Landmark University' ? 'selected' : '' }}>Landmark University</option>
                    <option value="Lead City University" {{ old('university') == 'Lead City University' ? 'selected' : '' }}>Lead City University</option>
                    <option value="Madonna University" {{ old('university') == 'Madonna University' ? 'selected' : '' }}>Madonna University</option>
                    <option value="Michael Okpara University of Agriculture" {{ old('university') == 'Michael Okpara University of Agriculture' ? 'selected' : '' }}>Michael Okpara University of Agriculture</option>
                    <option value="Modibbo Adama University of Technology" {{ old('university') == 'Modibbo Adama University of Technology' ? 'selected' : '' }}>Modibbo Adama University of Technology</option>
                    <option value="Nasarawa State University" {{ old('university') == 'Nasarawa State University' ? 'selected' : '' }}>Nasarawa State University</option>
                    <option value="Niger Delta University" {{ old('university') == 'Niger Delta University' ? 'selected' : '' }}>Niger Delta University</option>
                    <option value="Nnamdi Azikiwe University" {{ old('university') == 'Nnamdi Azikiwe University' ? 'selected' : '' }}>Nnamdi Azikiwe University</option>
                    <option value="Northwest University" {{ old('university') == 'Northwest University' ? 'selected' : '' }}>Northwest University</option>
                    <option value="Novena University" {{ old('university') == 'Novena University' ? 'selected' : '' }}>Novena University</option>
                    <option value="Obafemi Awolowo University" {{ old('university') == 'Obafemi Awolowo University' ? 'selected' : '' }}>Obafemi Awolowo University</option>
                    <option value="Obong University" {{ old('university') == 'Obong University' ? 'selected' : '' }}>Obong University</option>
                    <option value="Oduduwa University" {{ old('university') == 'Oduduwa University' ? 'selected' : '' }}>Oduduwa University</option>
                    <option value="Olabisi Onabanjo University" {{ old('university') == 'Olabisi Onabanjo University' ? 'selected' : '' }}>Olabisi Onabanjo University</option>
                    <option value="Ondo State University of Science and Technology" {{ old('university') == 'Ondo State University of Science and Technology' ? 'selected' : '' }}>Ondo State University of Science and Technology</option>
                    <option value="Osun State University" {{ old('university') == 'Osun State University' ? 'selected' : '' }}>Osun State University</option>
                    <option value="Pan-Atlantic University" {{ old('university') == 'Pan-Atlantic University' ? 'selected' : '' }}>Pan-Atlantic University</option>
                    <option value="Paul University" {{ old('university') == 'Paul University' ? 'selected' : '' }}>Paul University</option>
                    <option value="Plateau State University" {{ old('university') == 'Plateau State University' ? 'selected' : '' }}>Plateau State University</option>
                    <option value="Redeemer's University" {{ old('university') == "Redeemer's University" ? 'selected' : '' }}>Redeemer's University</option>
                    <option value="Renaissance University" {{ old('university') == 'Renaissance University' ? 'selected' : '' }}>Renaissance University</option>
                    <option value="Rivers State University" {{ old('university') == 'Rivers State University' ? 'selected' : '' }}>Rivers State University</option>
                    <option value="Salem University" {{ old('university') == 'Salem University' ? 'selected' : '' }}>Salem University</option>
                    <option value="Sokoto State University" {{ old('university') == 'Sokoto State University' ? 'selected' : '' }}>Sokoto State University</option>
                    <option value="Tai Solarin University of Education" {{ old('university') == 'Tai Solarin University of Education' ? 'selected' : '' }}>Tai Solarin University of Education</option>
                    <option value="Taraba State University" {{ old('university') == 'Taraba State University' ? 'selected' : '' }}>Taraba State University</option>
                    <option value="University of Abuja" {{ old('university') == 'University of Abuja' ? 'selected' : '' }}>University of Abuja</option>
                    <option value="University of Agriculture, Makurdi" {{ old('university') == 'University of Agriculture, Makurdi' ? 'selected' : '' }}>University of Agriculture, Makurdi</option>
                    <option value="University of Benin" {{ old('university') == 'University of Benin' ? 'selected' : '' }}>University of Benin</option>
                    <option value="University of Calabar" {{ old('university') == 'University of Calabar' ? 'selected' : '' }}>University of Calabar</option>
                    <option value="University of Ibadan" {{ old('university') == 'University of Ibadan' ? 'selected' : '' }}>University of Ibadan</option>
                    <option value="University of Ilorin" {{ old('university') == 'University of Ilorin' ? 'selected' : '' }}>University of Ilorin</option>
                    <option value="University of Jos" {{ old('university') == 'University of Jos' ? 'selected' : '' }}>University of Jos</option>
                    <option value="University of Lagos" {{ old('university') == 'University of Lagos' ? 'selected' : '' }}>University of Lagos</option>
                    <option value="University of Maiduguri" {{ old('university') == 'University of Maiduguri' ? 'selected' : '' }}>University of Maiduguri</option>
                    <option value="University of Nigeria, Nsukka" {{ old('university') == 'University of Nigeria, Nsukka' ? 'selected' : '' }}>University of Nigeria, Nsukka</option>
                    <option value="University of Port Harcourt" {{ old('university') == 'University of Port Harcourt' ? 'selected' : '' }}>University of Port Harcourt</option>
                    <option value="University of Uyo" {{ old('university') == 'University of Uyo' ? 'selected' : '' }}>University of Uyo</option>
                    <option value="Usmanu Danfodiyo University" {{ old('university') == 'Usmanu Danfodiyo University' ? 'selected' : '' }}>Usmanu Danfodiyo University</option>
                    <option value="Veritas University" {{ old('university') == 'Veritas University' ? 'selected' : '' }}>Veritas University</option>
                    <option value="Wellspring University" {{ old('university') == 'Wellspring University' ? 'selected' : '' }}>Wellspring University</option>
                    <option value="Wesley University of Science and Technology" {{ old('university') == 'Wesley University of Science and Technology' ? 'selected' : '' }}>Wesley University of Science and Technology</option>
                    <option value="Western Delta University" {{ old('university') == 'Western Delta University' ? 'selected' : '' }}>Western Delta University</option>
                    <option value="Yaba College of Technology" {{ old('university') == 'Yaba College of Technology' ? 'selected' : '' }}>Yaba College of Technology</option>
                    <option value="Yusuf Maitama Sule University" {{ old('university') == 'Yusuf Maitama Sule University' ? 'selected' : '' }}>Yusuf Maitama Sule University</option>
                    <option value="Other" {{ old('university') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-input-error :messages="$errors->get('university')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">This helps us match you with relevant opportunities</p>
            </div>

            <!-- Field of Study -->
            <div>
                <x-input-label for="field_of_study" :value="__('Field of Study')" />
                <select id="field_of_study" name="field_of_study" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Select your field</option>
                    <option value="Computer Science" {{ old('field_of_study') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Engineering" {{ old('field_of_study') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="Business Administration" {{ old('field_of_study') == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                    <option value="Economics" {{ old('field_of_study') == 'Economics' ? 'selected' : '' }}>Economics</option>
                    <option value="Accounting" {{ old('field_of_study') == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                    <option value="Marketing" {{ old('field_of_study') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Law" {{ old('field_of_study') == 'Law' ? 'selected' : '' }}>Law</option>
                    <option value="Medicine" {{ old('field_of_study') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                    <option value="Education" {{ old('field_of_study') == 'Education' ? 'selected' : '' }}>Education</option>
                    <option value="Arts & Humanities" {{ old('field_of_study') == 'Arts & Humanities' ? 'selected' : '' }}>Arts & Humanities</option>
                    <option value="Social Sciences" {{ old('field_of_study') == 'Social Sciences' ? 'selected' : '' }}>Social Sciences</option>
                    <option value="Other" {{ old('field_of_study') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <x-input-error :messages="$errors->get('field_of_study')" class="mt-2" />
            </div>

            <!-- Graduation Year -->
            <div>
                <x-input-label for="graduation_year" :value="__('Graduation Year')" />
                <select id="graduation_year" name="graduation_year" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Select year</option>
                    <option value="0" {{ old('graduation_year') == '0' ? 'selected' : '' }}>Final Year (Current)</option>
                    @for ($year = date('Y') + 4; $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
                <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Select "Final Year" if you're currently in your final year</p>
            </div>

            <!-- Experience Level -->
            <div>
                <x-input-label for="experience_level" :value="__('Experience Level')" />
                <select id="experience_level" name="experience_level" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm block mt-1 w-full">
                    <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level (0-2 years)</option>
                    <option value="intermediate" {{ old('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate (3-5 years)</option>
                    <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior (5+ years)</option>
                </select>
                <x-input-error :messages="$errors->get('experience_level')" class="mt-2" />
            </div>

            <!-- Skills -->
            <div>
                <x-input-label for="skills" :value="__('Key Skills')" />
                <textarea id="skills" name="skills" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm block mt-1 w-full" placeholder="e.g., JavaScript, Project Management, Data Analysis">{{ old('skills') }}</textarea>
                <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Separate skills with commas</p>
            </div>
        </div>

        <!-- Security Section -->
        <div class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200 pb-2">Security</h3>
            
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <a class="text-sm text-primary-600 hover:text-primary-700 font-medium" href="{{ route('login') }}">
                Already have an account?
            </a>

            <x-primary-button class="px-8">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
