<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #321847;">
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
<body style="background-color: #321847;" class="h-full font-sans antialiased text-white" x-data="{ sidebarOpen: false }">
    <div style="background-color: #321847;" class="min-h-screen flex flex-col">

        <!-- TOP NAVBAR FOR STAFF PORTAL -->
        <header style="background-color: #210f30; border-bottom: 1px solid rgba(241,81,83,0.25);" class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between z-30 sticky top-0 shadow-md text-white">
            <!-- Brand Logo -->
            <div class="flex items-center gap-4">
                <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-2.5 text-decoration-none">
                    <div style="background: #f15153;" class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md shadow-[#f15153]/30">
                        S
                    </div>
                    <div>
                        <span class="font-black text-white text-base tracking-tight">SkillBridge</span>
                        <span class="text-[10px] font-bold block -mt-1 uppercase tracking-widest" style="color: #f15153;">Staff & Trainer Portal</span>
                    </div>
                </a>
            </div>

            <!-- Search Bar & User Profile -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center relative w-64">
                    <input type="text" placeholder="Search courses, students..." style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);" class="w-full pl-9 pr-4 py-1.5 rounded-xl text-xs text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-[#f15153]">
                    <svg class="w-4 h-4 text-purple-300 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Notification Bell -->
                <button class="relative p-2 text-purple-200 hover:text-white rounded-xl hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="w-2 h-2 rounded-full bg-[#f15153] absolute top-2 right-2 ring-2 ring-[#210f30]"></span>
                </button>

                <!-- Staff User Avatar & Dropdown -->
                <div class="relative border-l border-purple-800/50 pl-4" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" class="flex items-center gap-3 hover:opacity-90 transition-opacity focus:outline-none cursor-pointer">
                        <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; border-radius: 50%; background: #f15153; color: white; font-weight: 900; font-size: 14px; display: inline-flex; align-items: center; justify-content: center;" class="shrink-0 shadow-md shadow-[#f15153]/30">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'T', 0, 1)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="text-xs font-black text-white leading-tight flex items-center gap-1">
                                <span>{{ auth()->user()?->name ?? 'Senior Trainer' }}</span>
                                <svg class="w-3 h-3 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                            <div class="text-[10px] font-bold uppercase tracking-wider" style="color: #f15153;">INSTRUCTOR / STAFF</div>
                        </div>
                    </button>

                    <!-- User Profile Dropdown Menu -->
                    <div x-show="userMenuOpen" x-cloak class="absolute right-0 mt-3 w-64 rounded-2xl shadow-2xl py-3 border z-50 text-white" style="background: #210f30; border-color: rgba(241,81,83,0.3);">
                        <div class="px-4 py-3 border-b border-purple-800/40">
                            <p class="text-xs font-black text-white">{{ auth()->user()?->name ?? 'Senior Trainer' }}</p>
                            <p class="text-[11px] truncate mt-0.5" style="color: #a997be;">{{ auth()->user()?->email ?? 'staff@skillbridge.com' }}</p>
                            <span class="inline-block mt-2 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                                Staff / Instructor
                            </span>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-extrabold hover:bg-white/10 transition-colors text-decoration-none" style="color: #d4c5e2;">
                                <svg class="w-4 h-4 text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Back to Public Platform</span>
                            </a>
                            <a href="{{ route('staff.dashboard') }}?tab=settings" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-extrabold hover:bg-white/10 transition-colors text-decoration-none" style="color: #d4c5e2;">
                                <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                                <span>Account Settings</span>
                            </a>
                        </div>

                        <div class="pt-2 border-t border-purple-800/40 px-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl font-extrabold text-xs text-white transition-all cursor-pointer" style="background: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Sign Out / Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- LAYOUT GRID: SIDEBAR + MAIN CONTENT -->
        <div style="background-color: #321847;" class="flex-1 flex staff-sidebar-layout">

            <x-staff.sidebar />

            <!-- MAIN CONTENT AREA -->
            <main style="background-color: #321847;" class="flex-1 p-4 sm:p-6 lg:p-8">
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
        <footer style="background: #210f30; border-top: 1px solid rgba(241,81,83,0.2); color: #a997be;" class="py-4 text-center text-xs font-semibold z-20">
            © {{ date('Y') }} SkillBridge Staff & Trainer Portal. All rights reserved.
        </footer>
    </div>

    @livewireScripts
</body>
</html>
