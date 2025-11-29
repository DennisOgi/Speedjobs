<x-app-layout>
    <div class="min-h-screen bg-gray-100" x-data="resumeBuilder()">
        <!-- Toolbar -->
        <div class="bg-white border-b border-gray-200 sticky top-20 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-heading font-bold text-gray-900">Resume Builder</h1>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Template:</label>
                        <select x-model="selectedTemplate" class="rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            <option value="executive">The Executive</option>
                            <option value="modern">The Modern</option>
                            <option value="creative">The Creative</option>
                        </select>
                    </div>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Save Draft
                    </button>
                    <button @click="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium shadow-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Editor Column (Left) -->
                <div class="w-full lg:w-1/2 space-y-6 h-[calc(100vh-12rem)] overflow-y-auto pr-2 custom-scrollbar">
                    
                    <!-- Personal Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center cursor-pointer" @click="toggleSection('personal')">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Personal Details
                            </h3>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': sections.personal}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div x-show="sections.personal" x-collapse class="p-6 grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" x-model="resume.personal.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Job Title</label>
                                <input type="text" x-model="resume.personal.title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" x-model="resume.personal.email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" x-model="resume.personal.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" x-model="resume.personal.location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Professional Summary</label>
                                <textarea x-model="resume.personal.summary" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Experience -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center cursor-pointer" @click="toggleSection('experience')">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Experience
                            </h3>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': sections.experience}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div x-show="sections.experience" x-collapse class="p-6 space-y-6">
                            <template x-for="(job, index) in resume.experience" :key="index">
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 relative group">
                                    <button @click="removeExperience(index)" class="absolute top-2 right-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase">Job Title</label>
                                            <input type="text" x-model="job.title" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase">Company</label>
                                                <input type="text" x-model="job.company" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase">Date Range</label>
                                                <input type="text" x-model="job.date" placeholder="e.g. Jan 2020 - Present" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase">Description</label>
                                            <textarea x-model="job.description" rows="3" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <button @click="addExperience()" class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-primary-500 hover:text-primary-600 font-medium transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Position
                            </button>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center cursor-pointer" @click="toggleSection('education')">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                Education
                            </h3>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': sections.education}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div x-show="sections.education" x-collapse class="p-6 space-y-6">
                            <template x-for="(edu, index) in resume.education" :key="index">
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 relative group">
                                    <button @click="removeEducation(index)" class="absolute top-2 right-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase">School / University</label>
                                            <input type="text" x-model="edu.school" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase">Degree</label>
                                                <input type="text" x-model="edu.degree" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 uppercase">Year</label>
                                                <input type="text" x-model="edu.date" placeholder="e.g. 2018 - 2022" class="mt-1 block w-full rounded border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <button @click="addEducation()" class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-primary-500 hover:text-primary-600 font-medium transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Education
                            </button>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center cursor-pointer" @click="toggleSection('skills')">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Skills
                            </h3>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': sections.skills}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div x-show="sections.skills" x-collapse class="p-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Add Skills (comma separated)</label>
                            <input type="text" @keydown.enter.prevent="addSkill($event.target.value); $event.target.value = ''" placeholder="Type a skill and press Enter" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            
                            <div class="flex flex-wrap gap-2 mt-4">
                                <template x-for="(skill, index) in resume.skills" :key="index">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-50 text-primary-700">
                                        <span x-text="skill"></span>
                                        <button @click="removeSkill(index)" class="ml-2 text-primary-500 hover:text-primary-900 focus:outline-none">×</button>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Column (Right) -->
                <div class="w-full lg:w-1/2 bg-gray-200 rounded-xl p-8 overflow-y-auto h-[calc(100vh-12rem)] shadow-inner flex justify-center">
                    <!-- A4 Resume Page -->
                    <div class="bg-white w-[210mm] min-h-[297mm] shadow-2xl text-gray-800 transform scale-90 origin-top" id="resume-preview">
                        
                        <!-- THE EXECUTIVE TEMPLATE -->
                        <template x-if="selectedTemplate === 'executive'">
                            <div class="p-[25mm] font-serif text-gray-900 h-full">
                                <!-- Header -->
                                <div class="text-center border-b-2 border-gray-900 pb-6 mb-6">
                                    <h1 class="text-4xl font-bold tracking-wide uppercase mb-2" x-text="resume.personal.name || 'YOUR NAME'"></h1>
                                    <p class="text-lg font-medium italic mb-3" x-text="resume.personal.title || 'Professional Title'"></p>
                                    
                                    <div class="flex justify-center flex-wrap gap-4 text-sm">
                                        <template x-if="resume.personal.email">
                                            <span class="flex items-center gap-1">
                                                <span x-text="resume.personal.email"></span>
                                            </span>
                                        </template>
                                        <template x-if="resume.personal.phone">
                                            <span class="flex items-center gap-1">
                                                <span>•</span>
                                                <span x-text="resume.personal.phone"></span>
                                            </span>
                                        </template>
                                        <template x-if="resume.personal.location">
                                            <span class="flex items-center gap-1">
                                                <span>•</span>
                                                <span x-text="resume.personal.location"></span>
                                            </span>
                                        </template>
                                    </div>
                                </div>

                                <!-- Summary -->
                                <template x-if="resume.personal.summary">
                                    <div class="mb-6">
                                        <h2 class="text-sm font-bold uppercase tracking-widest border-b border-gray-300 mb-3 pb-1">Professional Summary</h2>
                                        <p class="text-sm leading-relaxed text-justify" x-text="resume.personal.summary"></p>
                                    </div>
                                </template>

                                <!-- Experience -->
                                <template x-if="resume.experience.length > 0">
                                    <div class="mb-6">
                                        <h2 class="text-sm font-bold uppercase tracking-widest border-b border-gray-300 mb-4 pb-1">Experience</h2>
                                        <div class="space-y-5">
                                            <template x-for="job in resume.experience">
                                                <div>
                                                    <div class="flex justify-between items-baseline mb-1">
                                                        <h3 class="font-bold text-lg" x-text="job.title"></h3>
                                                        <span class="text-sm font-medium" x-text="job.date"></span>
                                                    </div>
                                                    <div class="text-base italic mb-2" x-text="job.company"></div>
                                                    <p class="text-sm leading-relaxed text-justify whitespace-pre-line" x-text="job.description"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <!-- Education -->
                                <template x-if="resume.education.length > 0">
                                    <div class="mb-6">
                                        <h2 class="text-sm font-bold uppercase tracking-widest border-b border-gray-300 mb-4 pb-1">Education</h2>
                                        <div class="space-y-3">
                                            <template x-for="edu in resume.education">
                                                <div class="flex justify-between items-baseline">
                                                    <div>
                                                        <h3 class="font-bold" x-text="edu.school"></h3>
                                                        <div class="text-sm italic" x-text="edu.degree"></div>
                                                    </div>
                                                    <span class="text-sm" x-text="edu.date"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <!-- Skills -->
                                <template x-if="resume.skills.length > 0">
                                    <div>
                                        <h2 class="text-sm font-bold uppercase tracking-widest border-b border-gray-300 mb-3 pb-1">Core Competencies</h2>
                                        <div class="flex flex-wrap gap-x-6 gap-y-2">
                                            <template x-for="skill in resume.skills">
                                                <span class="text-sm relative pl-4 before:content-['•'] before:absolute before:left-0 before:text-gray-500" x-text="skill"></span>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- THE MODERN TEMPLATE -->
                        <template x-if="selectedTemplate === 'modern'">
                            <div class="grid grid-cols-12 h-full min-h-[297mm]">
                                <!-- Sidebar -->
                                <div class="col-span-4 bg-slate-100 p-8 pt-12 border-r border-slate-200">
                                    <!-- Contact Info -->
                                    <div class="mb-10">
                                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Contact</h3>
                                        <div class="space-y-3 text-sm text-slate-700">
                                            <template x-if="resume.personal.email">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-slate-500">Email</span>
                                                    <span class="font-medium break-words" x-text="resume.personal.email"></span>
                                                </div>
                                            </template>
                                            <template x-if="resume.personal.phone">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-slate-500">Phone</span>
                                                    <span class="font-medium" x-text="resume.personal.phone"></span>
                                                </div>
                                            </template>
                                            <template x-if="resume.personal.location">
                                                <div class="flex flex-col">
                                                    <span class="text-xs text-slate-500">Location</span>
                                                    <span class="font-medium" x-text="resume.personal.location"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Education (Sidebar) -->
                                    <template x-if="resume.education.length > 0">
                                        <div class="mb-10">
                                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Education</h3>
                                            <div class="space-y-4">
                                                <template x-for="edu in resume.education">
                                                    <div>
                                                        <div class="font-bold text-slate-800 text-sm" x-text="edu.degree"></div>
                                                        <div class="text-xs text-slate-600" x-text="edu.school"></div>
                                                        <div class="text-xs text-slate-500 mt-1" x-text="edu.date"></div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Skills (Sidebar) -->
                                    <template x-if="resume.skills.length > 0">
                                        <div>
                                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Skills</h3>
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="skill in resume.skills">
                                                    <span class="px-2 py-1 bg-white border border-slate-200 rounded text-xs font-medium text-slate-700" x-text="skill"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Main Content -->
                                <div class="col-span-8 p-8 pt-12">
                                    <!-- Header -->
                                    <div class="mb-10">
                                        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-2" x-text="resume.personal.name || 'Your Name'"></h1>
                                        <p class="text-xl text-primary-600 font-medium" x-text="resume.personal.title || 'Professional Title'"></p>
                                    </div>

                                    <!-- Summary -->
                                    <template x-if="resume.personal.summary">
                                        <div class="mb-8">
                                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                <span class="w-8 h-0.5 bg-primary-600"></span>
                                                Profile
                                            </h2>
                                            <p class="text-sm text-slate-600 leading-relaxed" x-text="resume.personal.summary"></p>
                                        </div>
                                    </template>

                                    <!-- Experience -->
                                    <template x-if="resume.experience.length > 0">
                                        <div>
                                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 flex items-center gap-2">
                                                <span class="w-8 h-0.5 bg-primary-600"></span>
                                                Experience
                                            </h2>
                                            <div class="space-y-8 border-l-2 border-slate-100 ml-3 pl-8 relative">
                                                <template x-for="job in resume.experience">
                                                    <div class="relative">
                                                        <!-- Timeline Dot -->
                                                        <span class="absolute -left-[39px] top-1.5 w-4 h-4 rounded-full border-2 border-primary-600 bg-white"></span>
                                                        
                                                        <div class="flex justify-between items-baseline mb-1">
                                                            <h3 class="font-bold text-lg text-slate-900" x-text="job.title"></h3>
                                                            <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2 py-1 rounded" x-text="job.date"></span>
                                                        </div>
                                                        <div class="text-sm font-medium text-slate-500 mb-3" x-text="job.company"></div>
                                                        <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line" x-text="job.description"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- THE CREATIVE TEMPLATE -->
                        <template x-if="selectedTemplate === 'creative'">
                            <div class="h-full min-h-[297mm] bg-white">
                                <!-- Header Block -->
                                <div class="bg-gray-900 text-white p-10 flex justify-between items-end">
                                    <div>
                                        <h1 class="text-5xl font-black tracking-tighter leading-none mb-2" x-text="resume.personal.name || 'YOUR NAME'"></h1>
                                        <p class="text-xl font-light tracking-widest text-gray-400" x-text="resume.personal.title || 'PROFESSIONAL TITLE'"></p>
                                    </div>
                                    <div class="text-right text-sm font-light text-gray-400 space-y-1">
                                        <template x-if="resume.personal.email"><div x-text="resume.personal.email"></div></template>
                                        <template x-if="resume.personal.phone"><div x-text="resume.personal.phone"></div></template>
                                        <template x-if="resume.personal.location"><div x-text="resume.personal.location"></div></template>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-8 p-10">
                                    <!-- Left Column -->
                                    <div class="col-span-2 space-y-8">
                                        <!-- Summary -->
                                        <template x-if="resume.personal.summary">
                                            <div>
                                                <h2 class="text-2xl font-black text-gray-900 mb-4">HELLO.</h2>
                                                <p class="text-gray-600 leading-relaxed" x-text="resume.personal.summary"></p>
                                            </div>
                                        </template>

                                        <!-- Experience -->
                                        <template x-if="resume.experience.length > 0">
                                            <div>
                                                <h2 class="text-2xl font-black text-gray-900 mb-6 border-b-4 border-gray-900 pb-2 inline-block">EXPERIENCE</h2>
                                                <div class="space-y-8">
                                                    <template x-for="job in resume.experience">
                                                        <div>
                                                            <div class="flex items-baseline gap-3 mb-1">
                                                                <h3 class="text-xl font-bold text-gray-900" x-text="job.title"></h3>
                                                                <span class="text-sm font-bold text-gray-400" x-text="job.date"></span>
                                                            </div>
                                                            <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2" x-text="job.company"></div>
                                                            <p class="text-gray-600 leading-relaxed whitespace-pre-line" x-text="job.description"></p>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="space-y-8">
                                        <!-- Education -->
                                        <template x-if="resume.education.length > 0">
                                            <div>
                                                <h2 class="text-lg font-black text-gray-900 mb-4 border-b-2 border-gray-900 pb-1">EDUCATION</h2>
                                                <div class="space-y-4">
                                                    <template x-for="edu in resume.education">
                                                        <div>
                                                            <div class="font-bold text-gray-900" x-text="edu.degree"></div>
                                                            <div class="text-sm text-gray-500" x-text="edu.school"></div>
                                                            <div class="text-xs text-gray-400 mt-1" x-text="edu.date"></div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Skills -->
                                        <template x-if="resume.skills.length > 0">
                                            <div>
                                                <h2 class="text-lg font-black text-gray-900 mb-4 border-b-2 border-gray-900 pb-1">SKILLS</h2>
                                                <div class="flex flex-col gap-2">
                                                    <template x-for="skill in resume.skills">
                                                        <span class="text-sm font-medium text-gray-600 border-l-4 border-gray-200 pl-3 py-1" x-text="skill"></span>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resumeBuilder() {
            return {
                selectedTemplate: 'modern',
                sections: {
                    personal: true,
                    experience: true,
                    education: true,
                    skills: true
                },
                resume: {
                    personal: {
                        name: 'John Doe',
                        title: 'Senior Software Engineer',
                        email: 'john.doe@example.com',
                        phone: '+234 800 123 4567',
                        location: 'Lagos, Nigeria',
                        summary: 'Experienced software engineer with a passion for building scalable web applications. Proven track record of delivering high-quality code and leading teams.'
                    },
                    experience: [
                        {
                            title: 'Senior Developer',
                            company: 'Tech Solutions Ltd',
                            date: '2021 - Present',
                            description: 'Leading the frontend team in rebuilding the core product using React and TypeScript.'
                        }
                    ],
                    education: [
                        {
                            school: 'University of Lagos',
                            degree: 'B.Sc. Computer Science',
                            date: '2016 - 2020'
                        }
                    ],
                    skills: ['JavaScript', 'Laravel', 'TailwindCSS', 'React', 'Project Management']
                },
                toggleSection(section) {
                    this.sections[section] = !this.sections[section];
                },
                addExperience() {
                    this.resume.experience.push({ title: '', company: '', date: '', description: '' });
                },
                removeExperience(index) {
                    this.resume.experience.splice(index, 1);
                },
                addEducation() {
                    this.resume.education.push({ school: '', degree: '', date: '' });
                },
                removeEducation(index) {
                    this.resume.education.splice(index, 1);
                },
                addSkill(skill) {
                    if (skill.trim() !== '') {
                        this.resume.skills.push(skill.trim());
                    }
                },
                removeSkill(index) {
                    this.resume.skills.splice(index, 1);
                }
            }
        }
    </script>
    
    <style>
        /* Custom Scrollbar for Editor */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        
        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body * {
                visibility: hidden;
            }
            #resume-preview, #resume-preview * {
                visibility: visible;
            }
            #resume-preview {
                position: absolute;
                left: 0;
                top: 0;
                width: 210mm;
                max-width: 210mm;
                margin: 0;
                padding: 0;
                box-shadow: none;
                transform: none !important;
                scale: 1 !important;
            }
            /* Ensure proper scaling for all templates */
            .bg-white {
                background-color: white !important;
            }
            /* Classic template print adjustment */
            .bg-gray-800 {
                background-color: #1f2937 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>
