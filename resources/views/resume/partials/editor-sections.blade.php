<!-- Photo Upload -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6">
        <div class="flex items-center gap-6">
            <div class="relative group">
                <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                    <template x-if="resume.photo_url">
                        <img :src="resume.photo_url" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!resume.photo_url">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </template>
                </div>
                <label class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-2xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="file" accept="image/*" @change="uploadPhoto($event)" class="hidden">
                </label>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-slate-900 mb-1">Profile Photo</h3>
                <p class="text-sm text-slate-500 mb-3">Add a professional headshot (optional)</p>
                <button x-show="resume.photo_url" @click="removePhoto()" class="text-sm text-red-500 hover:text-red-700 font-medium">Remove Photo</button>
            </div>
        </div>
    </div>
</div>

<!-- Personal Information -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('personal')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Personal Information</span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.personal}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.personal" x-transition class="px-6 pb-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" x-model="resume.full_name" @input="triggerAutosave()" placeholder="John Doe"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Job Title</label>
                <input type="text" x-model="resume.job_title" @input="triggerAutosave()" placeholder="Senior Software Engineer"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" x-model="resume.email" @input="triggerAutosave()" placeholder="john@example.com"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                <input type="text" x-model="resume.phone" @input="triggerAutosave()" placeholder="+234 800 000 0000"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Location</label>
                <input type="text" x-model="resume.location" @input="triggerAutosave()" placeholder="Lagos, Nigeria"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">LinkedIn</label>
                <input type="text" x-model="resume.linkedin" @input="triggerAutosave()" placeholder="linkedin.com/in/johndoe"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Website</label>
                <input type="text" x-model="resume.website" @input="triggerAutosave()" placeholder="johndoe.com"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            </div>
        </div>
    </div>
</div>

<!-- Professional Summary -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('summary')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Professional Summary</span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.summary}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.summary" x-transition class="px-6 pb-6">
        <textarea x-model="resume.summary" @input="triggerAutosave()" rows="5" 
                  placeholder="Write a compelling 2-3 sentence summary highlighting your experience, skills, and career goals..."
                  class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition resize-none"></textarea>
        <p class="mt-2 text-xs text-slate-400"><span x-text="(resume.summary || '').length"></span>/500 characters</p>
    </div>
</div>

<!-- Experience -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('experience')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Work Experience</span>
            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-medium rounded-full" x-text="resume.experience?.length || 0"></span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.experience}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.experience" x-transition class="px-6 pb-6 space-y-4">
        <template x-for="(exp, index) in resume.experience" :key="index">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 relative group">
                <button @click="removeExperience(index)" class="absolute top-3 right-3 p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg opacity-0 group-hover:opacity-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" x-model="exp.title" @input="triggerAutosave()" placeholder="Job Title"
                               class="col-span-2 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="exp.company" @input="triggerAutosave()" placeholder="Company"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="exp.location" @input="triggerAutosave()" placeholder="Location"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="exp.start_date" @input="triggerAutosave()" placeholder="Start Date"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="exp.end_date" @input="triggerAutosave()" placeholder="End Date (or Present)"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                    </div>
                    <textarea x-model="exp.description" @input="triggerAutosave()" rows="3" placeholder="Describe your responsibilities and achievements..."
                              class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20 resize-none"></textarea>
                </div>
            </div>
        </template>
        <button @click="addExperience()" class="w-full py-3 border-2 border-dashed border-slate-200 rounded-xl text-slate-500 hover:border-primary-400 hover:text-primary-600 hover:bg-primary-50/50 font-medium transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Experience
        </button>
    </div>
</div>

<!-- Education -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('education')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Education</span>
            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-medium rounded-full" x-text="resume.education?.length || 0"></span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.education}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.education" x-transition class="px-6 pb-6 space-y-4">
        <template x-for="(edu, index) in resume.education" :key="index">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 relative group">
                <button @click="removeEducation(index)" class="absolute top-3 right-3 p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg opacity-0 group-hover:opacity-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" x-model="edu.degree" @input="triggerAutosave()" placeholder="Degree (e.g., B.Sc. Computer Science)"
                               class="col-span-2 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="edu.school" @input="triggerAutosave()" placeholder="School/University"
                               class="col-span-2 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="edu.start_date" @input="triggerAutosave()" placeholder="Start Year"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                        <input type="text" x-model="edu.end_date" @input="triggerAutosave()" placeholder="End Year"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                    </div>
                    <input type="text" x-model="edu.gpa" @input="triggerAutosave()" placeholder="GPA/Grade (optional)"
                           class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                </div>
            </div>
        </template>
        <button @click="addEducation()" class="w-full py-3 border-2 border-dashed border-slate-200 rounded-xl text-slate-500 hover:border-primary-400 hover:text-primary-600 hover:bg-primary-50/50 font-medium transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Education
        </button>
    </div>
</div>

<!-- Skills -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('skills')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Skills</span>
            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-medium rounded-full" x-text="resume.skills?.length || 0"></span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.skills}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.skills" x-transition class="px-6 pb-6">
        <div class="flex flex-wrap gap-2 mb-4">
            <template x-for="(skill, index) in resume.skills" :key="index">
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-50 text-primary-700 rounded-lg text-sm font-medium">
                    <span x-text="skill.name || skill"></span>
                    <button @click="removeSkill(index)" class="text-primary-400 hover:text-primary-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </span>
            </template>
        </div>
        <div class="flex gap-2">
            <input type="text" x-ref="skillInput" @keydown.enter.prevent="addSkill($refs.skillInput.value); $refs.skillInput.value = ''" 
                   placeholder="Type a skill and press Enter"
                   class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition">
            <button @click="addSkill($refs.skillInput.value); $refs.skillInput.value = ''" class="px-4 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
        </div>
    </div>
</div>

<!-- Languages -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('languages')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Languages</span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.languages}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.languages" x-transition class="px-6 pb-6 space-y-3">
        <template x-for="(lang, index) in resume.languages" :key="index">
            <div class="flex items-center gap-3">
                <input type="text" x-model="lang.name" @input="triggerAutosave()" placeholder="Language"
                       class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                <select x-model="lang.level" @change="triggerAutosave()"
                        class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                    <option value="native">Native</option>
                    <option value="fluent">Fluent</option>
                    <option value="advanced">Advanced</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="basic">Basic</option>
                </select>
                <button @click="removeLanguage(index)" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </template>
        <button @click="addLanguage()" class="w-full py-2 border-2 border-dashed border-slate-200 rounded-xl text-slate-500 hover:border-primary-400 hover:text-primary-600 font-medium transition text-sm">
            + Add Language
        </button>
    </div>
</div>

<!-- Certifications -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button @click="toggleSection('certifications')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            </div>
            <span class="font-bold text-slate-900">Certifications</span>
        </div>
        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{'rotate-180': sections.certifications}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="sections.certifications" x-transition class="px-6 pb-6 space-y-3">
        <template x-for="(cert, index) in resume.certifications" :key="index">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 relative group">
                <button @click="removeCertification(index)" class="absolute top-3 right-3 p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg opacity-0 group-hover:opacity-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" x-model="cert.name" @input="triggerAutosave()" placeholder="Certification Name"
                           class="col-span-2 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                    <input type="text" x-model="cert.issuer" @input="triggerAutosave()" placeholder="Issuing Organization"
                           class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                    <input type="text" x-model="cert.date" @input="triggerAutosave()" placeholder="Date Obtained"
                           class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500/20">
                </div>
            </div>
        </template>
        <button @click="addCertification()" class="w-full py-2 border-2 border-dashed border-slate-200 rounded-xl text-slate-500 hover:border-primary-400 hover:text-primary-600 font-medium transition text-sm">
            + Add Certification
        </button>
    </div>
</div>
