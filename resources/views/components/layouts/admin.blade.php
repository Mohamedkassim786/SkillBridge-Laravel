<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #321847;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Portal - SkillBridge' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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

        .admin-sidebar-layout {
            display: grid;
            grid-template-columns: 256px 1fr;
            min-height: calc(100vh - 64px);
            align-items: start;
        }
        @media (max-width: 1024px) {
            .admin-sidebar-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body style="background-color: #321847;" class="h-full font-sans antialiased text-white" x-data="{ sidebarOpen: false }">
    <div style="background-color: #321847;" class="min-h-screen flex flex-col">

        <!-- Top Navbar -->
        <x-admin.navbar />

        <div style="background-color: #321847;" class="flex-1 flex relative min-h-[calc(100vh-64px)]">
            <!-- Mobile Backdrop Overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-black/60 z-30 lg:hidden backdrop-blur-xs"></div>

            <!-- Sidebar Navigation -->
            <x-admin.sidebar />

            <!-- Main Content Area -->
            <main style="background-color: #321847;" class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8">
                <div class="w-full space-y-6">
                    @if (session('status'))
                        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs font-bold flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer style="background-color: #210f30; border-top: 1px solid rgba(241,81,83,0.2); color: #a997be;" class="py-4 text-center text-xs font-semibold z-20">
            © 2026 SkillBridge Admin Suite • Enterprise LMS & Placement Portal
        </footer>
    </div>

    @livewireScripts
</body>
</html>