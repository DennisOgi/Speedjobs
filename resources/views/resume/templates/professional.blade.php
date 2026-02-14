<div class="h-full font-sans" style="--primary: {{ $colors['primary'] }}">
    <!-- Header -->
    <div class="px-12 pt-12 pb-8 border-b-4" style="border-color: {{ $colors['primary'] }}">
        <div class="flex items-start gap-6">
            @if($resume->photo)
                <img src="{{ asset('storage/' . $resume->photo) }}" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
            @endif
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $resume->full_name ?? 'Your Name' }}</h1>
                <p class="text-lg mt-1 font-medium" style="color: {{ $colors['primary'] }}">{{ $resume->job_title ?? 'Professional Title' }}</p>
                <div class="flex flex-wrap gap-4 mt-3 text-sm text-slate-600">
                    @if($resume->email)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $resume->email }}
                        </span>
                    @endif
                    @if($resume->phone)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $resume->phone }}
                        </span>
                    @endif
                    @if($resume->location)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $resume->location }}
                        </span>
                    @endif
                    @if($resume->linkedin)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            {{ $resume->linkedin }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="px-12 py-8 space-y-6">
        <!-- Summary -->
        @if($resume->summary)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color: {{ $colors['primary'] }}">Professional Summary</h2>
                <p class="text-slate-700 leading-relaxed text-sm">{{ $resume->summary }}</p>
            </div>
        @endif

        <!-- Experience -->
        @if($resume->experience && count($resume->experience) > 0)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest mb-4" style="color: {{ $colors['primary'] }}">Work Experience</h2>
                <div class="space-y-5">
                    @foreach($resume->experience as $exp)
                        <div>
                            <div class="flex justify-between items-baseline">
                                <h3 class="font-bold text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                <span class="text-sm text-slate-500">{{ ($exp['start_date'] ?? '') }} - {{ ($exp['end_date'] ?? '') }}</span>
                            </div>
                            <p class="text-sm font-medium" style="color: {{ $colors['primary'] }}">{{ $exp['company'] ?? '' }}</p>
                            <p class="text-sm text-slate-600 mt-2 whitespace-pre-line">{{ $exp['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Education -->
        @if($resume->education && count($resume->education) > 0)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest mb-4" style="color: {{ $colors['primary'] }}">Education</h2>
                <div class="space-y-3">
                    @foreach($resume->education as $edu)
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $edu['degree'] ?? '' }}</h3>
                                <p class="text-sm text-slate-600">{{ $edu['school'] ?? '' }}</p>
                            </div>
                            <span class="text-sm text-slate-500">{{ ($edu['start_date'] ?? '') }} - {{ ($edu['end_date'] ?? '') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Skills -->
        @if($resume->skills && count($resume->skills) > 0)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color: {{ $colors['primary'] }}">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($resume->skills as $skill)
                        <span class="px-3 py-1 text-sm rounded-full border" style="border-color: {{ $colors['primary'] }}; color: {{ $colors['primary'] }}">
                            {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Languages -->
        @if($resume->languages && count($resume->languages) > 0)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color: {{ $colors['primary'] }}">Languages</h2>
                <div class="flex flex-wrap gap-4">
                    @foreach($resume->languages as $lang)
                        <span class="text-sm text-slate-700">
                            {{ $lang['name'] ?? '' }} <span class="text-slate-400">({{ ucfirst($lang['level'] ?? '') }})</span>
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Certifications -->
        @if($resume->certifications && count($resume->certifications) > 0)
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color: {{ $colors['primary'] }}">Certifications</h2>
                <div class="space-y-2">
                    @foreach($resume->certifications as $cert)
                        <div>
                            <span class="font-medium text-slate-900">{{ $cert['name'] ?? '' }}</span>
                            <span class="text-sm text-slate-500"> - {{ $cert['issuer'] ?? '' }} ({{ $cert['date'] ?? '' }})</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
