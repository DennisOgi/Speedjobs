<!-- Professional Template -->
<template x-if="resume.template === 'professional'">
    <div class="h-full font-sans" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Header -->
        <div class="px-12 pt-12 pb-8 border-b-4" :style="`border-color: var(--primary)`">
            <div class="flex items-start gap-6">
                <template x-if="resume.photo_url">
                    <img :src="resume.photo_url" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                </template>
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-slate-900 tracking-tight" x-text="resume.full_name || 'Your Name'"></h1>
                    <p class="text-xl mt-1 font-medium" :style="`color: var(--primary)`" x-text="resume.job_title || 'Professional Title'"></p>
                    <div class="flex flex-wrap gap-4 mt-4 text-sm text-slate-600">
                        <template x-if="resume.email">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span x-text="resume.email"></span>
                            </span>
                        </template>
                        <template x-if="resume.phone">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span x-text="resume.phone"></span>
                            </span>
                        </template>
                        <template x-if="resume.location">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span x-text="resume.location"></span>
                            </span>
                        </template>
                        <template x-if="resume.linkedin">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                <span x-text="resume.linkedin"></span>
                            </span>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-12 py-8 space-y-6">
            <!-- Summary -->
            <template x-if="resume.summary">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-3" :style="`color: var(--primary)`">Professional Summary</h2>
                    <p class="text-slate-700 leading-relaxed text-sm" x-text="resume.summary"></p>
                </div>
            </template>

            <!-- Experience -->
            <template x-if="resume.experience?.length > 0">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-4" :style="`color: var(--primary)`">Work Experience</h2>
                    <div class="space-y-5">
                        <template x-for="exp in resume.experience" :key="exp.title">
                            <div>
                                <div class="flex justify-between items-baseline">
                                    <h3 class="font-bold text-slate-900" x-text="exp.title"></h3>
                                    <span class="text-sm text-slate-500" x-text="`${exp.start_date} - ${exp.end_date}`"></span>
                                </div>
                                <p class="text-sm font-medium" :style="`color: var(--primary)`" x-text="exp.company"></p>
                                <p class="text-sm text-slate-600 mt-2 whitespace-pre-line" x-text="exp.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Education -->
            <template x-if="resume.education?.length > 0">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-4" :style="`color: var(--primary)`">Education</h2>
                    <div class="space-y-3">
                        <template x-for="edu in resume.education" :key="edu.school">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-900" x-text="edu.degree"></h3>
                                    <p class="text-sm text-slate-600" x-text="edu.school"></p>
                                </div>
                                <span class="text-sm text-slate-500" x-text="`${edu.start_date} - ${edu.end_date}`"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Skills -->
            <template x-if="resume.skills?.length > 0">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest mb-3" :style="`color: var(--primary)`">Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="skill in resume.skills" :key="skill.name || skill">
                            <span class="px-3 py-1 text-sm rounded-full border" :style="`border-color: var(--primary); color: var(--primary)`" x-text="skill.name || skill"></span>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<!-- Modern Template -->
<template x-if="resume.template === 'modern'">
    <div class="h-full font-sans grid grid-cols-12" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Sidebar -->
        <div class="col-span-4 p-8 text-white" :style="`background-color: var(--primary)`">
            <template x-if="resume.photo_url">
                <img :src="resume.photo_url" class="w-32 h-32 rounded-full object-cover mx-auto mb-6 border-4 border-white/20">
            </template>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Contact</h3>
                    <div class="space-y-2 text-sm">
                        <template x-if="resume.email">
                            <p class="flex items-center gap-2 text-white/90">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span x-text="resume.email" class="break-all"></span>
                            </p>
                        </template>
                        <template x-if="resume.phone">
                            <p class="flex items-center gap-2 text-white/90">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span x-text="resume.phone"></span>
                            </p>
                        </template>
                        <template x-if="resume.location">
                            <p class="flex items-center gap-2 text-white/90">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span x-text="resume.location"></span>
                            </p>
                        </template>
                    </div>
                </div>

                <template x-if="resume.skills?.length > 0">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="skill in resume.skills" :key="skill.name || skill">
                                <span class="px-2 py-1 bg-white/10 rounded text-xs" x-text="skill.name || skill"></span>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.languages?.length > 0">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Languages</h3>
                        <div class="space-y-2">
                            <template x-for="lang in resume.languages" :key="lang.name">
                                <div class="flex justify-between text-sm">
                                    <span x-text="lang.name"></span>
                                    <span class="text-white/60 capitalize" x-text="lang.level"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.education?.length > 0">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Education</h3>
                        <div class="space-y-3">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="font-semibold text-sm" x-text="edu.degree"></p>
                                    <p class="text-xs text-white/70" x-text="edu.school"></p>
                                    <p class="text-xs text-white/50" x-text="`${edu.start_date} - ${edu.end_date}`"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-8 p-10">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-slate-900" x-text="resume.full_name || 'Your Name'"></h1>
                <p class="text-xl mt-1" :style="`color: var(--primary)`" x-text="resume.job_title || 'Professional Title'"></p>
            </div>

            <template x-if="resume.summary">
                <div class="mb-8">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                        <span class="w-8 h-0.5" :style="`background-color: var(--primary)`"></span>
                        About Me
                    </h2>
                    <p class="text-slate-600 leading-relaxed text-sm" x-text="resume.summary"></p>
                </div>
            </template>

            <template x-if="resume.experience?.length > 0">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                        <span class="w-8 h-0.5" :style="`background-color: var(--primary)`"></span>
                        Experience
                    </h2>
                    <div class="space-y-6 border-l-2 border-slate-100 ml-3 pl-6">
                        <template x-for="exp in resume.experience" :key="exp.title">
                            <div class="relative">
                                <span class="absolute -left-[29px] top-1.5 w-3 h-3 rounded-full" :style="`background-color: var(--primary)`"></span>
                                <div class="flex justify-between items-baseline mb-1">
                                    <h3 class="font-bold text-slate-900" x-text="exp.title"></h3>
                                    <span class="text-xs px-2 py-1 rounded" :style="`background-color: var(--primary); color: white`" x-text="`${exp.start_date} - ${exp.end_date}`"></span>
                                </div>
                                <p class="text-sm font-medium text-slate-500 mb-2" x-text="exp.company"></p>
                                <p class="text-sm text-slate-600 whitespace-pre-line" x-text="exp.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<!-- Executive Template -->
<template x-if="resume.template === 'executive'">
    <div class="h-full p-12" style="font-family: 'Georgia', serif;" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Header -->
        <div class="text-center border-b-2 border-slate-200 pb-8 mb-8">
            <h1 class="text-5xl font-normal tracking-wide text-slate-900" x-text="resume.full_name || 'Your Name'"></h1>
            <p class="text-xl mt-2 tracking-widest uppercase" :style="`color: var(--primary)`" x-text="resume.job_title || 'Professional Title'"></p>
            <div class="flex justify-center flex-wrap gap-6 mt-4 text-sm text-slate-600">
                <template x-if="resume.email"><span x-text="resume.email"></span></template>
                <template x-if="resume.phone"><span>• <span x-text="resume.phone"></span></span></template>
                <template x-if="resume.location"><span>• <span x-text="resume.location"></span></span></template>
            </div>
        </div>

        <!-- Summary -->
        <template x-if="resume.summary">
            <div class="mb-8">
                <h2 class="text-center text-sm font-bold uppercase tracking-[0.3em] mb-4" :style="`color: var(--primary)`">Executive Summary</h2>
                <p class="text-slate-700 leading-relaxed text-center max-w-3xl mx-auto italic" x-text="resume.summary"></p>
            </div>
        </template>

        <div class="grid grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="col-span-2 space-y-8">
                <template x-if="resume.experience?.length > 0">
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-6" :style="`color: var(--primary)`">Professional Experience</h2>
                        <div class="space-y-6">
                            <template x-for="exp in resume.experience" :key="exp.title">
                                <div>
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="text-lg font-semibold text-slate-900" x-text="exp.title"></h3>
                                        <span class="text-sm text-slate-500 italic" x-text="`${exp.start_date} – ${exp.end_date}`"></span>
                                    </div>
                                    <p class="text-sm font-medium" :style="`color: var(--primary)`" x-text="exp.company"></p>
                                    <p class="text-sm text-slate-600 mt-2 whitespace-pre-line leading-relaxed" x-text="exp.description"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <template x-if="resume.education?.length > 0">
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" :style="`color: var(--primary)`">Education</h2>
                        <div class="space-y-4">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="font-semibold text-slate-900" x-text="edu.degree"></p>
                                    <p class="text-sm text-slate-600" x-text="edu.school"></p>
                                    <p class="text-xs text-slate-500 italic" x-text="`${edu.start_date} – ${edu.end_date}`"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.skills?.length > 0">
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" :style="`color: var(--primary)`">Core Competencies</h2>
                        <ul class="space-y-1">
                            <template x-for="skill in resume.skills" :key="skill.name || skill">
                                <li class="text-sm text-slate-700 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full" :style="`background-color: var(--primary)`"></span>
                                    <span x-text="skill.name || skill"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                <template x-if="resume.certifications?.length > 0">
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" :style="`color: var(--primary)`">Certifications</h2>
                        <div class="space-y-2">
                            <template x-for="cert in resume.certifications" :key="cert.name">
                                <div>
                                    <p class="text-sm font-medium text-slate-900" x-text="cert.name"></p>
                                    <p class="text-xs text-slate-500" x-text="`${cert.issuer} • ${cert.date}`"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<!-- Minimal Template -->
<template x-if="resume.template === 'minimal'">
    <div class="h-full p-12 font-sans" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-light text-slate-900" x-text="resume.full_name || 'Your Name'"></h1>
                <p class="text-lg text-slate-500 mt-1" x-text="resume.job_title || 'Professional Title'"></p>
                <div class="flex flex-wrap gap-4 mt-4 text-sm text-slate-400">
                    <template x-if="resume.email"><span x-text="resume.email"></span></template>
                    <template x-if="resume.phone"><span x-text="resume.phone"></span></template>
                    <template x-if="resume.location"><span x-text="resume.location"></span></template>
                </div>
            </div>

            <template x-if="resume.summary">
                <div class="mb-10">
                    <p class="text-slate-600 leading-relaxed" x-text="resume.summary"></p>
                </div>
            </template>

            <template x-if="resume.experience?.length > 0">
                <div class="mb-10">
                    <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-6">Experience</h2>
                    <div class="space-y-8">
                        <template x-for="exp in resume.experience" :key="exp.title">
                            <div>
                                <div class="flex justify-between items-baseline">
                                    <h3 class="font-medium text-slate-900" x-text="exp.title"></h3>
                                    <span class="text-sm text-slate-400" x-text="`${exp.start_date} — ${exp.end_date}`"></span>
                                </div>
                                <p class="text-sm" :style="`color: var(--primary)`" x-text="exp.company"></p>
                                <p class="text-sm text-slate-500 mt-2 whitespace-pre-line" x-text="exp.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-2 gap-10">
                <template x-if="resume.education?.length > 0">
                    <div>
                        <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-4">Education</h2>
                        <div class="space-y-4">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="font-medium text-slate-900" x-text="edu.degree"></p>
                                    <p class="text-sm text-slate-500" x-text="edu.school"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.skills?.length > 0">
                    <div>
                        <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-4">Skills</h2>
                        <p class="text-sm text-slate-600">
                            <template x-for="(skill, index) in resume.skills" :key="skill.name || skill">
                                <span><span x-text="skill.name || skill"></span><span x-show="index < resume.skills.length - 1">, </span></span>
                            </template>
                        </p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<!-- Creative Template -->
<template x-if="resume.template === 'creative'">
    <div class="h-full font-sans" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Bold Header -->
        <div class="p-10 text-white relative overflow-hidden" :style="`background-color: var(--primary)`">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-white transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full bg-white transform -translate-x-1/2 translate-y-1/2"></div>
            </div>
            <div class="relative flex items-center gap-8">
                <template x-if="resume.photo_url">
                    <img :src="resume.photo_url" class="w-32 h-32 rounded-2xl object-cover border-4 border-white/20 shadow-2xl">
                </template>
                <div>
                    <h1 class="text-5xl font-black tracking-tight" x-text="resume.full_name || 'YOUR NAME'"></h1>
                    <p class="text-xl font-light tracking-widest text-white/80 mt-2 uppercase" x-text="resume.job_title || 'Professional Title'"></p>
                </div>
            </div>
        </div>

        <!-- Contact Bar -->
        <div class="px-10 py-4 bg-slate-900 text-white/80 flex flex-wrap gap-6 text-sm">
            <template x-if="resume.email"><span x-text="resume.email"></span></template>
            <template x-if="resume.phone"><span x-text="resume.phone"></span></template>
            <template x-if="resume.location"><span x-text="resume.location"></span></template>
            <template x-if="resume.linkedin"><span x-text="resume.linkedin"></span></template>
        </div>

        <div class="grid grid-cols-3 gap-8 p-10">
            <!-- Main Content -->
            <div class="col-span-2 space-y-8">
                <template x-if="resume.summary">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 mb-4">ABOUT ME</h2>
                        <p class="text-slate-600 leading-relaxed" x-text="resume.summary"></p>
                    </div>
                </template>

                <template x-if="resume.experience?.length > 0">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 mb-6 inline-block border-b-4 pb-2" :style="`border-color: var(--primary)`">EXPERIENCE</h2>
                        <div class="space-y-6">
                            <template x-for="exp in resume.experience" :key="exp.title">
                                <div class="relative pl-6 border-l-4" :style="`border-color: var(--primary)`">
                                    <h3 class="text-xl font-bold text-slate-900" x-text="exp.title"></h3>
                                    <p class="text-sm font-bold uppercase tracking-wider text-slate-400" x-text="exp.company"></p>
                                    <p class="text-sm font-bold mt-1" :style="`color: var(--primary)`" x-text="`${exp.start_date} - ${exp.end_date}`"></p>
                                    <p class="text-slate-600 mt-3 whitespace-pre-line" x-text="exp.description"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <template x-if="resume.education?.length > 0">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 mb-4 border-b-2 border-slate-900 pb-1">EDUCATION</h2>
                        <div class="space-y-4">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="font-bold text-slate-900" x-text="edu.degree"></p>
                                    <p class="text-sm text-slate-500" x-text="edu.school"></p>
                                    <p class="text-xs text-slate-400" x-text="`${edu.start_date} - ${edu.end_date}`"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.skills?.length > 0">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 mb-4 border-b-2 border-slate-900 pb-1">SKILLS</h2>
                        <div class="space-y-2">
                            <template x-for="skill in resume.skills" :key="skill.name || skill">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full" :style="`background-color: var(--primary)`"></div>
                                    <span class="text-sm text-slate-700" x-text="skill.name || skill"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<!-- Tech Template -->
<template x-if="resume.template === 'tech'">
    <div class="h-full font-mono bg-slate-900 text-slate-300" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Terminal Header -->
        <div class="p-6 border-b border-slate-700">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="ml-4 text-xs text-slate-500">resume.json</span>
            </div>
            <div class="flex items-center gap-6">
                <template x-if="resume.photo_url">
                    <img :src="resume.photo_url" class="w-24 h-24 rounded-lg object-cover border-2" :style="`border-color: var(--primary)`">
                </template>
                <div>
                    <p class="text-slate-500 text-sm">// Developer Profile</p>
                    <h1 class="text-3xl font-bold text-white" x-text="resume.full_name || 'Your Name'"></h1>
                    <p class="text-lg" :style="`color: var(--primary)`" x-text="resume.job_title || 'Software Engineer'"></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 p-6">
            <!-- Main -->
            <div class="col-span-2 space-y-6">
                <template x-if="resume.summary">
                    <div class="bg-slate-800/50 rounded-lg p-4">
                        <p class="text-green-400 text-sm mb-2">/** About */</p>
                        <p class="text-slate-400 text-sm leading-relaxed" x-text="resume.summary"></p>
                    </div>
                </template>

                <template x-if="resume.experience?.length > 0">
                    <div>
                        <p class="text-green-400 text-sm mb-4">/** Work Experience */</p>
                        <div class="space-y-4">
                            <template x-for="exp in resume.experience" :key="exp.title">
                                <div class="bg-slate-800/50 rounded-lg p-4 border-l-2" :style="`border-color: var(--primary)`">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-white font-bold" x-text="exp.title"></h3>
                                            <p class="text-sm" :style="`color: var(--primary)`" x-text="exp.company"></p>
                                        </div>
                                        <span class="text-xs text-slate-500 bg-slate-800 px-2 py-1 rounded" x-text="`${exp.start_date} - ${exp.end_date}`"></span>
                                    </div>
                                    <p class="text-sm text-slate-400 mt-3 whitespace-pre-line" x-text="exp.description"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-green-400 text-sm mb-3">/** Contact */</p>
                    <div class="space-y-2 text-sm">
                        <template x-if="resume.email"><p class="text-slate-400"><span class="text-purple-400">email:</span> "<span x-text="resume.email"></span>"</p></template>
                        <template x-if="resume.phone"><p class="text-slate-400"><span class="text-purple-400">phone:</span> "<span x-text="resume.phone"></span>"</p></template>
                        <template x-if="resume.location"><p class="text-slate-400"><span class="text-purple-400">location:</span> "<span x-text="resume.location"></span>"</p></template>
                        <template x-if="resume.github"><p class="text-slate-400"><span class="text-purple-400">github:</span> "<span x-text="resume.github"></span>"</p></template>
                    </div>
                </div>

                <template x-if="resume.skills?.length > 0">
                    <div class="bg-slate-800/50 rounded-lg p-4">
                        <p class="text-green-400 text-sm mb-3">/** Tech Stack */</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="skill in resume.skills" :key="skill.name || skill">
                                <span class="px-2 py-1 text-xs rounded" :style="`background-color: var(--primary); color: white`" x-text="skill.name || skill"></span>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.education?.length > 0">
                    <div class="bg-slate-800/50 rounded-lg p-4">
                        <p class="text-green-400 text-sm mb-3">/** Education */</p>
                        <div class="space-y-3">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="text-white text-sm font-medium" x-text="edu.degree"></p>
                                    <p class="text-xs text-slate-500" x-text="edu.school"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<!-- Elegant Template -->
<template x-if="resume.template === 'elegant'">
    <div class="h-full p-12" style="font-family: 'Playfair Display', Georgia, serif;" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Elegant Header -->
        <div class="text-center mb-12">
            <template x-if="resume.photo_url">
                <img :src="resume.photo_url" class="w-28 h-28 rounded-full object-cover mx-auto mb-6 border-4" :style="`border-color: var(--primary)`">
            </template>
            <h1 class="text-4xl font-normal text-slate-900 tracking-wide" x-text="resume.full_name || 'Your Name'"></h1>
            <div class="flex items-center justify-center gap-4 mt-2">
                <span class="w-12 h-px bg-slate-300"></span>
                <p class="text-lg tracking-widest uppercase" :style="`color: var(--primary)`" x-text="resume.job_title || 'Professional Title'"></p>
                <span class="w-12 h-px bg-slate-300"></span>
            </div>
            <div class="flex justify-center flex-wrap gap-6 mt-6 text-sm text-slate-500" style="font-family: sans-serif;">
                <template x-if="resume.email"><span x-text="resume.email"></span></template>
                <template x-if="resume.phone"><span x-text="resume.phone"></span></template>
                <template x-if="resume.location"><span x-text="resume.location"></span></template>
            </div>
        </div>

        <template x-if="resume.summary">
            <div class="max-w-2xl mx-auto text-center mb-12">
                <p class="text-slate-600 leading-relaxed italic" x-text="resume.summary"></p>
            </div>
        </template>

        <div class="grid grid-cols-12 gap-12">
            <!-- Main Content -->
            <div class="col-span-8">
                <template x-if="resume.experience?.length > 0">
                    <div>
                        <h2 class="text-sm uppercase tracking-[0.3em] mb-6 flex items-center gap-4" :style="`color: var(--primary)`">
                            <span class="flex-1 h-px bg-slate-200"></span>
                            Experience
                            <span class="flex-1 h-px bg-slate-200"></span>
                        </h2>
                        <div class="space-y-8">
                            <template x-for="exp in resume.experience" :key="exp.title">
                                <div>
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="text-xl text-slate-900" x-text="exp.title"></h3>
                                        <span class="text-sm text-slate-400 italic" x-text="`${exp.start_date} — ${exp.end_date}`"></span>
                                    </div>
                                    <p class="text-sm tracking-wider uppercase" :style="`color: var(--primary)`" x-text="exp.company"></p>
                                    <p class="text-sm text-slate-600 mt-3 whitespace-pre-line leading-relaxed" style="font-family: sans-serif;" x-text="exp.description"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Sidebar -->
            <div class="col-span-4 space-y-8">
                <template x-if="resume.education?.length > 0">
                    <div>
                        <h2 class="text-sm uppercase tracking-[0.3em] mb-4" :style="`color: var(--primary)`">Education</h2>
                        <div class="space-y-4">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="text-slate-900" x-text="edu.degree"></p>
                                    <p class="text-sm text-slate-500" style="font-family: sans-serif;" x-text="edu.school"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.skills?.length > 0">
                    <div>
                        <h2 class="text-sm uppercase tracking-[0.3em] mb-4" :style="`color: var(--primary)`">Expertise</h2>
                        <div class="space-y-2" style="font-family: sans-serif;">
                            <template x-for="skill in resume.skills" :key="skill.name || skill">
                                <p class="text-sm text-slate-600" x-text="skill.name || skill"></p>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.languages?.length > 0">
                    <div>
                        <h2 class="text-sm uppercase tracking-[0.3em] mb-4" :style="`color: var(--primary)`">Languages</h2>
                        <div class="space-y-2" style="font-family: sans-serif;">
                            <template x-for="lang in resume.languages" :key="lang.name">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600" x-text="lang.name"></span>
                                    <span class="text-slate-400 capitalize" x-text="lang.level"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<!-- Bold Template -->
<template x-if="resume.template === 'bold'">
    <div class="h-full font-sans" :style="`--primary: ${colorSchemes[resume.color_scheme]?.primary || '#2563eb'}`">
        <!-- Giant Header -->
        <div class="p-10 pb-6">
            <div class="flex items-end gap-8">
                <template x-if="resume.photo_url">
                    <img :src="resume.photo_url" class="w-36 h-36 rounded-3xl object-cover shadow-2xl">
                </template>
                <div class="flex-1">
                    <h1 class="text-6xl font-black text-slate-900 leading-none tracking-tight" x-text="resume.full_name || 'YOUR NAME'"></h1>
                    <p class="text-2xl font-bold mt-2" :style="`color: var(--primary)`" x-text="resume.job_title || 'PROFESSIONAL TITLE'"></p>
                </div>
            </div>
        </div>

        <!-- Contact Strip -->
        <div class="px-10 py-4 flex flex-wrap gap-6 text-sm border-y-4" :style="`border-color: var(--primary)`">
            <template x-if="resume.email">
                <span class="font-bold" x-text="resume.email"></span>
            </template>
            <template x-if="resume.phone">
                <span class="font-bold" x-text="resume.phone"></span>
            </template>
            <template x-if="resume.location">
                <span class="font-bold" x-text="resume.location"></span>
            </template>
            <template x-if="resume.linkedin">
                <span class="font-bold" x-text="resume.linkedin"></span>
            </template>
        </div>

        <div class="p-10 grid grid-cols-3 gap-10">
            <!-- Main Content -->
            <div class="col-span-2 space-y-8">
                <template x-if="resume.summary">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 mb-4">PROFILE</h2>
                        <p class="text-slate-600 leading-relaxed text-lg" x-text="resume.summary"></p>
                    </div>
                </template>

                <template x-if="resume.experience?.length > 0">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 mb-6">EXPERIENCE</h2>
                        <div class="space-y-6">
                            <template x-for="exp in resume.experience" :key="exp.title">
                                <div class="p-6 rounded-2xl" :style="`background: linear-gradient(135deg, ${colorSchemes[resume.color_scheme]?.primary}10, ${colorSchemes[resume.color_scheme]?.primary}05)`">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-xl font-black text-slate-900" x-text="exp.title"></h3>
                                            <p class="font-bold" :style="`color: var(--primary)`" x-text="exp.company"></p>
                                        </div>
                                        <span class="text-sm font-bold px-3 py-1 rounded-full text-white" :style="`background-color: var(--primary)`" x-text="`${exp.start_date} - ${exp.end_date}`"></span>
                                    </div>
                                    <p class="text-slate-600 mt-3 whitespace-pre-line" x-text="exp.description"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <template x-if="resume.skills?.length > 0">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 mb-4">SKILLS</h2>
                        <div class="space-y-2">
                            <template x-for="skill in resume.skills" :key="skill.name || skill">
                                <div class="px-4 py-2 rounded-lg font-bold text-white text-sm" :style="`background-color: var(--primary)`" x-text="skill.name || skill"></div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.education?.length > 0">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 mb-4">EDUCATION</h2>
                        <div class="space-y-4">
                            <template x-for="edu in resume.education" :key="edu.school">
                                <div>
                                    <p class="font-black text-slate-900" x-text="edu.degree"></p>
                                    <p class="text-sm font-medium text-slate-500" x-text="edu.school"></p>
                                    <p class="text-xs font-bold" :style="`color: var(--primary)`" x-text="`${edu.start_date} - ${edu.end_date}`"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="resume.certifications?.length > 0">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 mb-4">CERTIFICATIONS</h2>
                        <div class="space-y-3">
                            <template x-for="cert in resume.certifications" :key="cert.name">
                                <div class="p-3 border-l-4 bg-slate-50" :style="`border-color: var(--primary)`">
                                    <p class="font-bold text-slate-900 text-sm" x-text="cert.name"></p>
                                    <p class="text-xs text-slate-500" x-text="cert.issuer"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
