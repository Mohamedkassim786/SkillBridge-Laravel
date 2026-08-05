<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
        .admin-sidebar-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: calc(100vh - 64px);
        }
        @media (max-width: 1024px) {
            .admin-sidebar-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 bg-white" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col bg-white">

        <!-- Top Navbar -->
        <x-admin.navbar />

        <div class="flex-1 flex overflow-hidden admin-sidebar-layout bg-white">
            <!-- Sidebar Navigation -->
            <x-admin.sidebar />

            <!-- Main Content Area (Pure White Background #ffffff) -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-white">
                <div class="w-full space-y-6 bg-white">
                    @if (session('status'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Minimal Pure White Footer -->
        <footer style="background: #ffffff; border-top: 1px solid #e2e8f0;" class="py-4 text-center text-xs text-slate-500 font-semibold z-20">
            © 2026 SkillBridge Admin Panel
        </footer>
    </div>

    @livewireScripts
</body>
</html>