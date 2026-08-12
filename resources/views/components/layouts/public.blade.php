<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #321847;">
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
            background: #210f30;
        }
        ::-webkit-scrollbar-thumb {
            background: #542878;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f15153;
        }
        select option {
            background-color: #321847 !important;
            color: #FFFFFF !important;
        }
    </style>
</head>
<body style="background-color: #321847; margin: 0; min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between;" class="font-sans antialiased text-purple-50 selection:bg-[#f15153] selection:text-white">

    <x-public.navbar />

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-public.footer />

    @livewireScripts
</body>
</html>
