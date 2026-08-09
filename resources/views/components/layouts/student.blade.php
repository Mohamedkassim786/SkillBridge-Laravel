<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #07162C !important;">
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
    <style>
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
<body class="h-full font-sans antialiased text-white" style="background-color: #07162C !important;" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col" style="background-color: #07162C !important;">
        <!-- Top Navbar -->
        <x-student.navbar />

        <div class="flex-1 flex" style="background-color: #07162C !important;">
            <!-- Sidebar Navigation -->
            <x-student.sidebar />

            <!-- Main Dashboard Canvas -->
            <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8" style="background-color: #07162C !important;">
                <div class="max-w-7xl mx-auto space-y-8" style="background-color: #07162C !important;">
                    @if (session('status'))
                        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm font-bold shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="p-4 rounded-xl bg-amber-500/20 border border-amber-500/30 text-amber-300 text-sm font-bold shadow-sm">
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
