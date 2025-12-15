<div class="h-full p-12 min-h-[297mm]" style="font-family: 'Playfair Display', Georgia, serif;">
    <!-- Elegant Header -->
    <div class="text-center mb-12">
        @if($resume->photo)
            <img src="{{ asset('storage/' . $resume->photo) }}" class="w-28 h-28 rounded-full object-cover mx-auto mb-6 border-4" style="border-color: {{ $colors['primary'] }}">
        @endif
        <h1 class="text-4xl font-normal text-slate-900 tracking-wide">{{ $resume->full_name ?? 'Your Name' }}</h1>
        <div class="flex items-center justify-center gap-4 mt-2">
            <span class="w-12 h-px bg-slate-300"></span>
            <p class="text-lg tracking-widest uppercase" style="color: {{ $colors['primary'] }}">{{ $resume->job_title ?? 'Professional Title' }}</p>
            <span class="w-12 h-px bg-slate-300"></span>
        </div>
        <div class="flex justify-center flex-wrap gap-6 mt-6 text-sm text-slate-500" style="font-family: sans-serif;">
            @if($resume->email)<span>{{ $resume->email }}</span>@endif
            @if($resume->phone)<span>{{ $resume->phone }}</span>@endif
            @if($resume->location)<span>{{ $resume->location }}</span>@endif
        </div>
    </div>

    @if($resume->summary)
        <div class="max-w-2xl mx-auto text-center mb-12">
            <p class="text-slate-600 leading-relaxed italic">{{ $resume->summary }}</p>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-12">
        <!-- Main Content -->
        <div class="col-span-8">
            @if($resume->experience && count($resume->experience) > 0)
                <div>
                    <h2 class="text-sm uppercase tracking-[0.3em] mb-6 flex items-center gap-4" style="color: {{ $colors['primary'] }}">
                        <span class="flex-1 h-px bg-slate-200"></span>
                        Experience
                        <span class="flex-1 h-px bg-slate-200"></span>
                    </h2>
                    <div class="space-y-8">
                        @foreach($resume->experience as $exp)
                            <div>
                                <div class="flex justify-between items-baseline">
                                    <h3 class="text-xl text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                    <span class="text-sm text-slate-400 italic">{{ ($exp['start_date'] ?? '') }} — {{ ($exp['end_date'] ?? '') }}</span>
                                </div>
                                <p class="text-sm tracking-wider uppercase" style="color: {{ $colors['primary'] }}">{{ $exp['company'] ?? '' }}</p>
                                <p class="text-sm text-slate-600 mt-3 whitespace-pre-line leading-relaxed" style="font-family: sans-serif;">{{ $exp['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-span-4 space-y-8">
            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h2 class="text-sm uppercase tracking-[0.3em] mb-4" style="color: {{ $colors['primary'] }}">Education</h2>
                    <div class="space-y-4">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="text-slate-900">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-sm text-slate-500" style="font-family: sans-serif;">{{ $edu['school'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h2 class="text-sm uppercase tracking-[0.3em] mb-4" style="color: {{ $colors['primary'] }}">Expertise</h2>
                    <div class="space-y-2" style="font-family: sans-serif;">
                        @foreach($resume->skills as $skill)
                            <p class="text-sm text-slate-600">{{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->languages && count($resume->languages) > 0)
                <div>
                    <h2 class="text-sm uppercase tracking-[0.3em] mb-4" style="color: {{ $colors['primary'] }}">Languages</h2>
                    <div class="space-y-2" style="font-family: sans-serif;">
                        @foreach($resume->languages as $lang)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">{{ $lang['name'] ?? '' }}</span>
                                <span class="text-slate-400 capitalize">{{ $lang['level'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->certifications && count($resume->certifications) > 0)
                <div>
                    <h2 class="text-sm uppercase tracking-[0.3em] mb-4" style="color: {{ $colors['primary'] }}">Certifications</h2>
                    <div class="space-y-2" style="font-family: sans-serif;">
                        @foreach($resume->certifications as $cert)
                            <div>
                                <p class="text-sm text-slate-700">{{ $cert['name'] ?? '' }}</p>
                                <p class="text-xs text-slate-400">{{ $cert['issuer'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
