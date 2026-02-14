<div class="h-full font-sans grid grid-cols-12 min-h-[297mm]">
    <!-- Sidebar -->
    <div class="col-span-4 p-8 text-white" style="background-color: {{ $colors['primary'] }}">
        @if($resume->photo)
            <img src="{{ asset('storage/' . $resume->photo) }}" class="w-32 h-32 rounded-full object-cover mx-auto mb-6 border-4 border-white/20">
        @endif
        
        <div class="space-y-6">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Contact</h3>
                <div class="space-y-2 text-sm">
                    @if($resume->email)
                        <p class="flex items-center gap-2 text-white/90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="break-all">{{ $resume->email }}</span>
                        </p>
                    @endif
                    @if($resume->phone)
                        <p class="flex items-center gap-2 text-white/90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $resume->phone }}
                        </p>
                    @endif
                    @if($resume->location)
                        <p class="flex items-center gap-2 text-white/90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $resume->location }}
                        </p>
                    @endif
                </div>
            </div>

            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($resume->skills as $skill)
                            <span class="px-2 py-1 bg-white/10 rounded text-xs">
                                {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->languages && count($resume->languages) > 0)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Languages</h3>
                    <div class="space-y-2">
                        @foreach($resume->languages as $lang)
                            <div class="flex justify-between text-sm">
                                <span>{{ $lang['name'] ?? '' }}</span>
                                <span class="text-white/60 capitalize">{{ $lang['level'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Education</h3>
                    <div class="space-y-3">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="font-semibold text-sm">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-xs text-white/70">{{ $edu['school'] ?? '' }}</p>
                                <p class="text-xs text-white/50">{{ ($edu['start_date'] ?? '') }} - {{ ($edu['end_date'] ?? '') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->certifications && count($resume->certifications) > 0)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Certifications</h3>
                    <div class="space-y-2">
                        @foreach($resume->certifications as $cert)
                            <div>
                                <p class="text-sm font-medium">{{ $cert['name'] ?? '' }}</p>
                                <p class="text-xs text-white/60">{{ $cert['issuer'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-span-8 p-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">{{ $resume->full_name ?? 'Your Name' }}</h1>
            <p class="text-lg mt-1" style="color: {{ $colors['primary'] }}">{{ $resume->job_title ?? 'Professional Title' }}</p>
        </div>

        @if($resume->summary)
            <div class="mb-8">
                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                    <span class="w-8 h-0.5" style="background-color: {{ $colors['primary'] }}"></span>
                    About Me
                </h2>
                <p class="text-slate-600 leading-relaxed text-sm">{{ $resume->summary }}</p>
            </div>
        @endif

        @if($resume->experience && count($resume->experience) > 0)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                    <span class="w-8 h-0.5" style="background-color: {{ $colors['primary'] }}"></span>
                    Experience
                </h2>
                <div class="space-y-6 border-l-2 border-slate-100 ml-3 pl-6">
                    @foreach($resume->experience as $exp)
                        <div class="relative">
                            <span class="absolute -left-[29px] top-1.5 w-3 h-3 rounded-full" style="background-color: {{ $colors['primary'] }}"></span>
                            <div class="flex justify-between items-baseline mb-1">
                                <h3 class="font-bold text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                <span class="text-xs px-2 py-1 rounded text-white" style="background-color: {{ $colors['primary'] }}">{{ ($exp['start_date'] ?? '') }} - {{ ($exp['end_date'] ?? '') }}</span>
                            </div>
                            <p class="text-sm font-medium text-slate-500 mb-2">{{ $exp['company'] ?? '' }}</p>
                            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $exp['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
