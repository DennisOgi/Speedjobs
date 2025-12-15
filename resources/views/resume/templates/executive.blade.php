<div class="h-full p-12 min-h-[297mm]" style="font-family: 'Georgia', serif;">
    <!-- Header -->
    <div class="text-center border-b-2 border-slate-200 pb-8 mb-8">
        <h1 class="text-5xl font-normal tracking-wide text-slate-900">{{ $resume->full_name ?? 'Your Name' }}</h1>
        <p class="text-xl mt-2 tracking-widest uppercase" style="color: {{ $colors['primary'] }}">{{ $resume->job_title ?? 'Professional Title' }}</p>
        <div class="flex justify-center flex-wrap gap-6 mt-4 text-sm text-slate-600">
            @if($resume->email)<span>{{ $resume->email }}</span>@endif
            @if($resume->phone)<span>• {{ $resume->phone }}</span>@endif
            @if($resume->location)<span>• {{ $resume->location }}</span>@endif
        </div>
    </div>

    <!-- Summary -->
    @if($resume->summary)
        <div class="mb-8">
            <h2 class="text-center text-sm font-bold uppercase tracking-[0.3em] mb-4" style="color: {{ $colors['primary'] }}">Executive Summary</h2>
            <p class="text-slate-700 leading-relaxed text-center max-w-3xl mx-auto italic">{{ $resume->summary }}</p>
        </div>
    @endif

    <div class="grid grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="col-span-2 space-y-8">
            @if($resume->experience && count($resume->experience) > 0)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-6" style="color: {{ $colors['primary'] }}">Professional Experience</h2>
                    <div class="space-y-6">
                        @foreach($resume->experience as $exp)
                            <div>
                                <div class="flex justify-between items-baseline">
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                    <span class="text-sm text-slate-500 italic">{{ ($exp['start_date'] ?? '') }} – {{ ($exp['end_date'] ?? '') }}</span>
                                </div>
                                <p class="text-sm font-medium" style="color: {{ $colors['primary'] }}">{{ $exp['company'] ?? '' }}</p>
                                <p class="text-sm text-slate-600 mt-2 whitespace-pre-line leading-relaxed">{{ $exp['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" style="color: {{ $colors['primary'] }}">Education</h2>
                    <div class="space-y-4">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="font-semibold text-slate-900">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-sm text-slate-600">{{ $edu['school'] ?? '' }}</p>
                                <p class="text-xs text-slate-500 italic">{{ ($edu['start_date'] ?? '') }} – {{ ($edu['end_date'] ?? '') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" style="color: {{ $colors['primary'] }}">Core Competencies</h2>
                    <ul class="space-y-1">
                        @foreach($resume->skills as $skill)
                            <li class="text-sm text-slate-700 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $colors['primary'] }}"></span>
                                {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($resume->certifications && count($resume->certifications) > 0)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" style="color: {{ $colors['primary'] }}">Certifications</h2>
                    <div class="space-y-2">
                        @foreach($resume->certifications as $cert)
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ $cert['name'] ?? '' }}</p>
                                <p class="text-xs text-slate-500">{{ ($cert['issuer'] ?? '') }} • {{ ($cert['date'] ?? '') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->languages && count($resume->languages) > 0)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.3em] border-b border-slate-200 pb-2 mb-4" style="color: {{ $colors['primary'] }}">Languages</h2>
                    <div class="space-y-1">
                        @foreach($resume->languages as $lang)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-700">{{ $lang['name'] ?? '' }}</span>
                                <span class="text-slate-500 capitalize">{{ $lang['level'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
