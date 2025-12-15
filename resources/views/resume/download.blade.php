<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->full_name ?? 'Resume' }} - {{ $resume->job_title ?? 'Professional' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .resume-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .resume-container {
                margin: 0;
                box-shadow: none;
            }
        }
        @media screen {
            body {
                background: #f1f5f9;
                padding: 20px;
            }
            .resume-container {
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-3 z-50">
        <button onclick="window.print()" class="px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold shadow-lg hover:bg-primary-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download / Print
        </button>
        <a href="{{ route('resume.edit', $resume) }}" class="px-6 py-3 bg-white text-slate-700 rounded-xl font-semibold shadow-lg hover:bg-slate-50 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Resume
        </a>
    </div>

    @php
        $colorSchemes = \App\Models\Resume::getColorSchemes();
        $colors = $colorSchemes[$resume->color_scheme] ?? $colorSchemes['blue'];
    @endphp

    <div class="resume-container" style="--primary: {{ $colors['primary'] }}">
        @switch($resume->template)
            @case('professional')
                @include('resume.templates.professional', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('modern')
                @include('resume.templates.modern', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('executive')
                @include('resume.templates.executive', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('minimal')
                @include('resume.templates.minimal', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('creative')
                @include('resume.templates.creative', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('tech')
                @include('resume.templates.tech', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('elegant')
                @include('resume.templates.elegant', ['resume' => $resume, 'colors' => $colors])
                @break
            @case('bold')
                @include('resume.templates.bold', ['resume' => $resume, 'colors' => $colors])
                @break
            @default
                @include('resume.templates.professional', ['resume' => $resume, 'colors' => $colors])
        @endswitch
    </div>

    <script>
        // Auto-trigger print dialog after a short delay
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // };
    </script>
</body>
</html>
