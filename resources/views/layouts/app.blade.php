<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 selection:bg-primary-100 selection:text-primary-900 relative">
        <!-- Fixed Mesh Gradient Background -->
        <div class="fixed inset-0 z-[-1] pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-200/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-accent-200/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-brand-dark/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>
        <div class="min-h-screen flex flex-col">
            @include('components.navbar')

            <!-- Page Content -->
            <main class="flex-grow {{ request()->routeIs('welcome') ? '' : 'pt-20' }}">
                {{ $slot }}
            </main>

            @include('components.footer')
        </div>
    </body>
</html>
