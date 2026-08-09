<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Staff & Trainer Portal - SkillBridge' }}</title>

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

        .staff-sidebar-layout {
            display: grid;
            grid-template-columns: 256px 1fr;
            min-height: calc(100vh - 64px);
            align-items: start;
        }
        @media (max-width: 1024px) {
            .staff-sidebar-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body style="background-color: #07162C;" class="h-full font-sans antialiased text-white" x-data="{ sidebarOpen: false }">
    <div style="background-color: #07162C;" class="min-h-screen flex flex-col">

        <!-- TOP NAVBAR FOR STAFF PORTAL -->
        <header style="background-color: #0B1F3A; border-bottom: 1px solid rgba(255,255,255,0.08);" class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between z-30 sticky top-0 shadow-md text-white">
            <!-- Brand Logo -->
            <div class="flex items-center gap-4">
                <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-2.5 text-decoration-none">
                    <div style="background: #D62828;" class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md">
                        S
                    </div>
                    <div>
                        <span class="font-black text-white text-base tracking-tight">SkillBridge</span>
                        <span class="text-[10px] font-bold text-rose-400 block -mt-1 uppercase tracking-widest">Staff & Trainer Portal</span>
                    </div>
                </a>
            </div>

            <!-- Search Bar & User Profile -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center relative w-64">
                    <input type="text" placeholder="Search courses, students..." style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);" class="w-full pl-9 pr-4 py-1.5 rounded-xl text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Notification Bell -->
                <button class="relative p-2 text-slate-300 hover:text-white rounded-xl hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="w-2 h-2 rounded-full bg-[#D62828] absolute top-2 right-2 ring-2 ring-[#0B1F3A]"></span>
                </button>

                <!-- Staff User Avatar -->
                <div class="flex items-center gap-3 border-l border-slate-800 pl-4">
                    <div style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; max-width: 32px; max-height: 32px; border-radius: 50%; background: #D62828; color: white; font-weight: 900; font-size: 13px; display: inline-flex; align-items: center; justify-content: center;" class="shrink-0 shadow-md">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'T', 0, 1)) }}
                    </div>
                    <div class="hidden md:block">
                        <div class="text-xs font-bold text-white leading-tight">{{ auth()->user()?->name ?? 'Senior Instructor' }}</div>
                        <div class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Instructor / Staff</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- LAYOUT GRID: SIDEBAR + MAIN CONTENT -->
        <div style="background-color: #07162C;" class="flex-1 flex staff-sidebar-layout">

            <x-staff.sidebar />

            <!-- MAIN CONTENT AREA -->
            <main style="background-color: #07162C;" class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="w-full space-y-6">
                    @if (isset($header))
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>

        </div>

        <!-- FOOTER -->
        <footer style="background: #0B1F3A; border-top: 1px solid #1e3a5f;" class="py-4 text-center text-xs text-slate-400 font-semibold z-20">
            © {{ date('Y') }} SkillBridge Staff & Trainer Portal. All rights reserved.
        </footer>
    </div>

    @livewireScripts
</body>
</html>
