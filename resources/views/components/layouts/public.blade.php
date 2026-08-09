<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0B1F3A]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? \App\Models\CmsSetting::get('site_name', 'SkillBridge LMS') }} - Enterprise Software Learning</title>
    <meta name="description" content="{{ $metaDescription ?? \App\Models\CmsSetting::get('hero_subheading', 'Master full-stack software architecture, domain-driven design, and enterprise PHP 8.3/Laravel 12.') }}">

    <!-- OpenGraph Tags -->
    <meta property="og:title" content="{{ $title ?? 'SkillBridge LMS' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Enterprise-grade software learning platform' }}">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Tailwind & Livewire Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #07162C;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e3a5f;
            border-radius: 9999px;
            border: 1px solid rgba(214, 40, 40, 0.2);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #D62828;
        }
        ::-webkit-scrollbar-corner {
            background: #07162C;
        }
        * {
            scrollbar-width: thin;
            scrollbar-color: #1e3a5f #07162C;
        }
        select option {
            background-color: #0B1F3A !important;
            color: #FFFFFF !important;
        }
    </style>
</head>
<body style="background-color: #0B1F3A; margin: 0; min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between;" class="font-sans antialiased text-slate-100 selection:bg-[#D62828] selection:text-white">

    <x-public.navbar />

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-public.footer />

    @livewireScripts
</body>
</html>
