<div class="h-full font-sans min-h-[297mm]">
    <!-- Bold Header -->
    <div class="p-10 text-white relative overflow-hidden" style="background-color: {{ $colors['primary'] }}">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-white transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full bg-white transform -translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="relative flex items-center gap-8">
            @if($resume->photo)
                <img src="{{ asset('storage/' . $resume->photo) }}" class="w-32 h-32 rounded-2xl object-cover border-4 border-white/20 shadow-2xl">
            @endif
            <div>
                <h1 class="text-5xl font-black tracking-tight">{{ $resume->full_name ?? 'YOUR NAME' }}</h1>
                <p class="text-xl font-light tracking-widest text-white/80 mt-2 uppercase">{{ $resume->job_title ?? 'Professional Title' }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Bar -->
    <div class="px-10 py-4 bg-slate-900 text-white/80 flex flex-wrap gap-6 text-sm">
        @if($resume->email)<span>{{ $resume->email }}</span>@endif
        @if($resume->phone)<span>{{ $resume->phone }}</span>@endif
        @if($resume->location)<span>{{ $resume->location }}</span>@endif
        @if($resume->linkedin)<span>{{ $resume->linkedin }}</span>@endif
    </div>

    <div class="grid grid-cols-3 gap-8 p-10">
        <!-- Main Content -->
        <div class="col-span-2 space-y-8">
            @if($resume->summary)
                <div>
                    <h2 class="text-2xl font-black text-slate-900 mb-4">ABOUT ME</h2>
                    <p class="text-slate-600 leading-relaxed">{{ $resume->summary }}</p>
                </div>
            @endif

            @if($resume->experience && count($resume->experience) > 0)
                <div>
                    <h2 class="text-2xl font-black text-slate-900 mb-6 inline-block border-b-4 pb-2" style="border-color: {{ $colors['primary'] }}">EXPERIENCE</h2>
                    <div class="space-y-6">
                        @foreach($resume->experience as $exp)
                            <div class="relative pl-6 border-l-4" style="border-color: {{ $colors['primary'] }}">
                                <h3 class="text-xl font-bold text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                <p class="text-sm font-bold uppercase tracking-wider text-slate-400">{{ $exp['company'] ?? '' }}</p>
                                <p class="text-sm font-bold mt-1" style="color: {{ $colors['primary'] }}">{{ ($exp['start_date'] ?? '') }} - {{ ($exp['end_date'] ?? '') }}</p>
                                <p class="text-slate-600 mt-3 whitespace-pre-line">{{ $exp['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h2 class="text-lg font-black text-slate-900 mb-4 border-b-2 border-slate-900 pb-1">EDUCATION</h2>
                    <div class="space-y-4">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="font-bold text-slate-900">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-sm text-slate-500">{{ $edu['school'] ?? '' }}</p>
                                <p class="text-xs text-slate-400">{{ ($edu['start_date'] ?? '') }} - {{ ($edu['end_date'] ?? '') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h2 class="text-lg font-black text-slate-900 mb-4 border-b-2 border-slate-900 pb-1">SKILLS</h2>
                    <div class="space-y-2">
                        @foreach($resume->skills as $skill)
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $colors['primary'] }}"></div>
                                <span class="text-sm text-slate-700">{{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->languages && count($resume->languages) > 0)
                <div>
                    <h2 class="text-lg font-black text-slate-900 mb-4 border-b-2 border-slate-900 pb-1">LANGUAGES</h2>
                    <div class="space-y-2">
                        @foreach($resume->languages as $lang)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-700">{{ $lang['name'] ?? '' }}</span>
                                <span class="text-slate-400 capitalize">{{ $lang['level'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
