<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Super Admin Control Center - SkillBridge' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        .super-admin-sidebar-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: calc(100vh - 64px);
        }
        @media (max-width: 1024px) {
            .super-admin-sidebar-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body style="background-color: #07162C;" class="h-full font-sans antialiased text-white" x-data="{ sidebarOpen: false }">
    <div style="background-color: #07162C;" class="min-h-screen flex flex-col">

        <!-- Top Navbar -->
        <x-super-admin.navbar />

        <div style="background-color: #07162C;" class="flex-1 flex overflow-hidden super-admin-sidebar-layout">
            <!-- Sidebar Navigation -->
            <x-super-admin.sidebar />

            <!-- Main Content Area (Deep Navy Canvas #07162C) -->
            <main style="background-color: #07162C;" class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
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

        <!-- Dark Navy Footer -->
        <footer style="background-color: #0B1F3A; border-top: 1px solid #1e3a5f;" class="py-4 text-center text-xs text-slate-400 font-semibold z-20">
            © 2026 SkillBridge Super Admin Control Center • High-Security Management Suite
        </footer>
    </div>

    @livewireScripts
</body>
</html>
