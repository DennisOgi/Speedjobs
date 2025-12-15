<div class="h-full p-12 font-sans min-h-[297mm]">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-light text-slate-900">{{ $resume->full_name ?? 'Your Name' }}</h1>
            <p class="text-lg text-slate-500 mt-1">{{ $resume->job_title ?? 'Professional Title' }}</p>
            <div class="flex flex-wrap gap-4 mt-4 text-sm text-slate-400">
                @if($resume->email)<span>{{ $resume->email }}</span>@endif
                @if($resume->phone)<span>{{ $resume->phone }}</span>@endif
                @if($resume->location)<span>{{ $resume->location }}</span>@endif
            </div>
        </div>

        @if($resume->summary)
            <div class="mb-10">
                <p class="text-slate-600 leading-relaxed">{{ $resume->summary }}</p>
            </div>
        @endif

        @if($resume->experience && count($resume->experience) > 0)
            <div class="mb-10">
                <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-6">Experience</h2>
                <div class="space-y-8">
                    @foreach($resume->experience as $exp)
                        <div>
                            <div class="flex justify-between items-baseline">
                                <h3 class="font-medium text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                <span class="text-sm text-slate-400">{{ ($exp['start_date'] ?? '') }} — {{ ($exp['end_date'] ?? '') }}</span>
                            </div>
                            <p class="text-sm" style="color: {{ $colors['primary'] }}">{{ $exp['company'] ?? '' }}</p>
                            <p class="text-sm text-slate-500 mt-2 whitespace-pre-line">{{ $exp['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-10">
            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-4">Education</h2>
                    <div class="space-y-4">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="font-medium text-slate-900">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-sm text-slate-500">{{ $edu['school'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-4">Skills</h2>
                    <p class="text-sm text-slate-600">
                        @foreach($resume->skills as $index => $skill)
                            {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}@if($index < count($resume->skills) - 1), @endif
                        @endforeach
                    </p>
                </div>
            @endif
        </div>

        @if($resume->languages && count($resume->languages) > 0)
            <div class="mt-10">
                <h2 class="text-xs font-medium uppercase tracking-widest text-slate-400 mb-4">Languages</h2>
                <div class="flex flex-wrap gap-4">
                    @foreach($resume->languages as $lang)
                        <span class="text-sm text-slate-600">{{ $lang['name'] ?? '' }} ({{ ucfirst($lang['level'] ?? '') }})</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
