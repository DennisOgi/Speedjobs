@props(['resume' => null, 'templates', 'colorSchemes', 'defaultData' => []])

<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100" 
         x-data="resumeBuilder(@js($resume), @js($defaultData), @js($colorSchemes))"
         x-init="init()">
        
        <!-- Premium Toolbar -->
        <div class="bg-white/80 backdrop-blur-xl border-b border-slate-200/50 sticky top-16 z-40 shadow-sm">
            <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Left: Back & Title -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('resume.index') }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div>
                            <input type="text" x-model="resume.name" 
                                   class="text-lg font-bold text-slate-900 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none w-48"
                                   placeholder="Resume Name">
                            <p class="text-xs text-slate-400" x-show="lastSaved">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Saved <span x-text="lastSaved"></span>
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Center: Template & Color -->
                    <div class="hidden lg:flex items-center gap-4">
                        <!-- Template Selector -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-xl text-sm font-medium text-slate-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                                <span x-text="templates[resume.template]?.name || 'Template'"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute top-full left-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-slate-200 p-2 z-50">
                                <template x-for="(template, key) in templates" :key="key">
                                    <button @click="resume.template = key; open = false; triggerAutosave()"
                                            :class="{'bg-primary-50 border-primary-200': resume.template === key, 'hover:bg-slate-50': resume.template !== key}"
                                            class="w-full flex items-center gap-3 p-3 rounded-xl border border-transparent transition text-left">
                                        <div class="w-12 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900" x-text="template.name"></p>
                                            <p class="text-xs text-slate-500" x-text="template.description"></p>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Color Scheme -->
                        <div class="flex items-center gap-2 px-3 py-2 bg-slate-100 rounded-xl">
                            <span class="text-xs font-medium text-slate-500 uppercase">Color</span>
                            <div class="flex gap-1">
                                <template x-for="(colors, name) in colorSchemes" :key="name">
                                    <button @click="resume.color_scheme = name; triggerAutosave()"
                                            :style="`background-color: ${colors.primary}`"
                                            :class="{'ring-2 ring-offset-2 ring-slate-400': resume.color_scheme === name}"
                                            class="w-5 h-5 rounded-full transition-all hover:scale-110">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-3">
                        <button @click="saveResume()" 
                                :disabled="saving"
                                class="hidden sm:flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl font-medium transition">
                            <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Save
                        </button>
                        <button @click="downloadPDF()" 
                                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-semibold shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Mobile Tabs -->
            <div class="lg:hidden flex bg-white rounded-2xl p-1 shadow-sm mb-6">
                <button @click="mobileView = 'editor'" 
                        :class="{'bg-primary-600 text-white shadow-lg': mobileView === 'editor', 'text-slate-600': mobileView !== 'editor'}"
                        class="flex-1 py-3 rounded-xl font-semibold transition-all">
                    Editor
                </button>
                <button @click="mobileView = 'preview'" 
                        :class="{'bg-primary-600 text-white shadow-lg': mobileView === 'preview', 'text-slate-600': mobileView !== 'preview'}"
                        class="flex-1 py-3 rounded-xl font-semibold transition-all">
                    Preview
                </button>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Editor Panel -->
                <div class="w-full lg:w-[480px] xl:w-[520px] flex-shrink-0 space-y-4 lg:h-[calc(100vh-10rem)] lg:overflow-y-auto lg:pr-4 custom-scrollbar"
                     :class="{'hidden lg:block': mobileView !== 'editor'}">
                    
                    @include('resume.partials.editor-sections')
                    
                </div>

                <!-- Preview Panel -->
                <div class="flex-1 lg:h-[calc(100vh-10rem)] lg:overflow-y-auto"
                     :class="{'hidden lg:block': mobileView !== 'preview'}">
                    <div class="bg-slate-200/50 rounded-2xl p-4 lg:p-8 min-h-full flex justify-center">
                        <!-- A4 Resume Preview -->
                        <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform origin-top"
                             :style="`transform: scale(${previewScale})`"
                             style="width: 210mm; min-height: 297mm;"
                             id="resume-preview">
                            
                            @include('resume.partials.templates')
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('resume.partials.builder-script')
    @include('resume.partials.builder-styles')
</x-app-layout>
