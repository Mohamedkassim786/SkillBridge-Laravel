<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #321847 !important;">
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
<body class="h-full font-sans antialiased text-white" style="background-color: #321847 !important;" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col" style="background-color: #321847 !important;">
        <!-- Top Navbar -->
        <x-student.navbar />

        <div class="flex-1 flex" style="background-color: #321847 !important;">
            <!-- Sidebar Navigation -->
            <x-student.sidebar />

            <!-- Main Dashboard Canvas -->
            <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8" style="background-color: #321847 !important;">
                <div class="max-w-7xl mx-auto space-y-8" style="background-color: #321847 !important;">
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
