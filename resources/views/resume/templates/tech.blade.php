<div class="h-full font-mono bg-slate-900 text-slate-300 min-h-[297mm]">
    <!-- Terminal Header -->
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <span class="ml-4 text-xs text-slate-500">resume.json</span>
        </div>
        <div class="flex items-center gap-6">
            @if($resume->photo)
                <img src="{{ asset('storage/' . $resume->photo) }}" class="w-24 h-24 rounded-lg object-cover border-2" style="border-color: {{ $colors['primary'] }}">
            @endif
            <div>
                <p class="text-slate-500 text-sm">// Developer Profile</p>
                <h1 class="text-3xl font-bold text-white">{{ $resume->full_name ?? 'Your Name' }}</h1>
                <p class="text-lg" style="color: {{ $colors['primary'] }}">{{ $resume->job_title ?? 'Software Engineer' }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 p-6">
        <!-- Main -->
        <div class="col-span-2 space-y-6">
            @if($resume->summary)
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-green-400 text-sm mb-2">/** About */</p>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $resume->summary }}</p>
                </div>
            @endif

            @if($resume->experience && count($resume->experience) > 0)
                <div>
                    <p class="text-green-400 text-sm mb-4">/** Work Experience */</p>
                    <div class="space-y-4">
                        @foreach($resume->experience as $exp)
                            <div class="bg-slate-800/50 rounded-lg p-4 border-l-2" style="border-color: {{ $colors['primary'] }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-white font-bold">{{ $exp['title'] ?? '' }}</h3>
                                        <p class="text-sm" style="color: {{ $colors['primary'] }}">{{ $exp['company'] ?? '' }}</p>
                                    </div>
                                    <span class="text-xs text-slate-500 bg-slate-800 px-2 py-1 rounded">{{ ($exp['start_date'] ?? '') }} - {{ ($exp['end_date'] ?? '') }}</span>
                                </div>
                                <p class="text-sm text-slate-400 mt-3 whitespace-pre-line">{{ $exp['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-slate-800/50 rounded-lg p-4">
                <p class="text-green-400 text-sm mb-3">/** Contact */</p>
                <div class="space-y-2 text-sm">
                    @if($resume->email)<p class="text-slate-400"><span class="text-purple-400">email:</span> "{{ $resume->email }}"</p>@endif
                    @if($resume->phone)<p class="text-slate-400"><span class="text-purple-400">phone:</span> "{{ $resume->phone }}"</p>@endif
                    @if($resume->location)<p class="text-slate-400"><span class="text-purple-400">location:</span> "{{ $resume->location }}"</p>@endif
                    @if($resume->github)<p class="text-slate-400"><span class="text-purple-400">github:</span> "{{ $resume->github }}"</p>@endif
                    @if($resume->linkedin)<p class="text-slate-400"><span class="text-purple-400">linkedin:</span> "{{ $resume->linkedin }}"</p>@endif
                </div>
            </div>

            @if($resume->skills && count($resume->skills) > 0)
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-green-400 text-sm mb-3">/** Tech Stack */</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($resume->skills as $skill)
                            <span class="px-2 py-1 text-xs rounded text-white" style="background-color: {{ $colors['primary'] }}">
                                {{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->education && count($resume->education) > 0)
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-green-400 text-sm mb-3">/** Education */</p>
                    <div class="space-y-3">
                        @foreach($resume->education as $edu)
                            <div>
                                <p class="text-white text-sm font-medium">{{ $edu['degree'] ?? '' }}</p>
                                <p class="text-xs text-slate-500">{{ $edu['school'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($resume->certifications && count($resume->certifications) > 0)
                <div class="bg-slate-800/50 rounded-lg p-4">
                    <p class="text-green-400 text-sm mb-3">/** Certifications */</p>
                    <div class="space-y-2">
                        @foreach($resume->certifications as $cert)
                            <div>
                                <p class="text-white text-sm">{{ $cert['name'] ?? '' }}</p>
                                <p class="text-xs text-slate-500">{{ $cert['issuer'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
