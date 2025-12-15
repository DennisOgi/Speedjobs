<div class="h-full font-sans min-h-[297mm]">
    <!-- Giant Header -->
    <div class="p-10 pb-6">
        <div class="flex items-end gap-8">
            @if($resume->photo)
                <img src="{{ asset('storage/' . $resume->photo) }}" class="w-36 h-36 rounded-3xl object-cover shadow-2xl">
            @endif
            <div class="flex-1">
                <h1 class="text-6xl font-black text-slate-900 leading-none tracking-tight">{{ $resume->full_name ?? 'YOUR NAME' }}</h1>
                <p class="text-2xl font-bold mt-2" style="color: {{ $colors['primary'] }}">{{ $resume->job_title ?? 'PROFESSIONAL TITLE' }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Strip -->
    <div class="px-10 py-4 flex flex-wrap gap-6 text-sm border-y-4" style="border-color: {{ $colors['primary'] }}">
        @if($resume->email)<span class="font-bold">{{ $resume->email }}</span>@endif
        @if($resume->phone)<span class="font-bold">{{ $resume->phone }}</span>@endif
        @if($resume->location)<span class="font-bold">{{ $resume->location }}</span>@endif
        @if($resume->linkedin)<span class="font-bold">{{ $resume->linkedin }}</span>@endif
    </div>

    <div class="p-10 grid grid-cols-3 gap-10">
        <!-- Main Content -->
        <div class="col-span-2 space-y-8">
            @if($resume->summary)
                <div>
                    <h2 class="text-3xl font-black text-slate-900 mb-4">PROFILE</h2>
                    <p class="text-slate-600 leading-relaxed text-lg">{{ $resume->summary }}</p>
                </div>
            @endif

            @if($resume->experience && count($resume->experience) > 0)
                <div>
                    <h2 class="text-3xl font-black text-slate-900 mb-6">EXPERIENCE</h2>
                    <div class="space-y-6">
                        @foreach($resume->experience as $exp)
                            <div class="p-6 rounded-2xl" style="background: linear-gradient(135deg, {{ $colors['primary'] }}10, {{ $colors['primary'] }}05)">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-xl font-black text-slate-900">{{ $exp['title'] ?? '' }}</h3>
                                        <p class="font-bold" style="color: {{ $colors['primary'] }}">{{ $exp['company'] ?? '' }}</p>
                                    </div>
                                    <span class="text-sm font-bold px-3 py-1 rounded-full text-white" style="background-color: {{ $colors['primary'] }}">{{ ($exp['start_date'] ?? '') }} - {{ ($exp['end_date'] ?? '') }}</span>
                                </div>
                                <p class="text-slate-600 mt-3 whitespace-pre-line">{{ $exp['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h2 class="text-xl font-black text-slate-900 mb-4">SKILLS</h2>
                    <div class="space-y-2">
                        @foreach($resume->skills as $skill)
                            <div class="px-4 py-2 rounded-lg font-bold text-white text-sm" style="background-color: {{ $colors['primary'] }}">
                                {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h2 class="text-xl font-black text-slate-900 mb-4">EDUCATION</h2>
                    <div class="space-y-4">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="font-black text-slate-900">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-sm font-medium text-slate-500">{{ $edu['school'] ?? '' }}</p>
                                <p class="text-xs font-bold" style="color: {{ $colors['primary'] }}">{{ ($edu['start_date'] ?? '') }} - {{ ($edu['end_date'] ?? '') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->certifications && count($resume->certifications) > 0)
                <div>
                    <h2 class="text-xl font-black text-slate-900 mb-4">CERTIFICATIONS</h2>
                    <div class="space-y-3">
                        @foreach($resume->certifications as $cert)
                            <div class="p-3 border-l-4 bg-slate-50" style="border-color: {{ $colors['primary'] }}">
                                <p class="font-bold text-slate-900 text-sm">{{ $cert['name'] ?? '' }}</p>
                                <p class="text-xs text-slate-500">{{ $cert['issuer'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->languages && count($resume->languages) > 0)
                <div>
                    <h2 class="text-xl font-black text-slate-900 mb-4">LANGUAGES</h2>
                    <div class="space-y-2">
                        @foreach($resume->languages as $lang)
                            <div class="flex justify-between text-sm">
                                <span class="font-bold text-slate-700">{{ $lang['name'] ?? '' }}</span>
                                <span class="text-slate-400 capitalize">{{ $lang['level'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
