<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Student Dashboard - SkillBridge' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-slate-900 bg-slate-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navbar -->
        <x-student.navbar />

        <div class="flex-1 flex overflow-hidden">
            <!-- Sidebar Navigation -->
            <x-student.sidebar />

            <!-- Main Dashboard Canvas -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-8">
                    @if (session('status'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium">
                            {{ session('warning') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
