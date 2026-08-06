<header x-data="{ profileOpen: false, notifyOpen: false }" class="sticky top-0 z-50 text-white"
    style="background-color: #0B1F3A; border-bottom: 1px solid rgba(255,255,255,0.08); height: 64px;">
    <div class="w-full px-6 h-full flex items-center justify-between gap-4">

        <!-- Left: Logo & Brand Badge -->
        <div class="flex items-center gap-3 shrink-0">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-400 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-decoration-none">
                <div style="width: 34px; height: 34px; min-width: 34px; min-height: 34px; border-radius: 9px; background: #D62828; color: white; font-weight: 900; font-size: 15px;"
                    class="flex items-center justify-center shadow-sm shrink-0">
                    SB
                </div>
                <span class="text-base font-extrabold text-white tracking-tight">SkillBridge <span
                        class="text-rose-400 font-bold text-xs uppercase tracking-wider ml-1">Admin</span></span>
            </a>
        </div>

        <!-- Center: Search Bar -->
        <div class="flex-1 max-w-md hidden md:block">
            <div class="relative flex items-center">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search courses, lessons, users, jobs, payments..."
                    style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12); color: white;"
                    class="w-full pl-10 pr-4 py-1.5 rounded-xl text-xs focus:outline-none focus:border-rose-500 placeholder-slate-400">
            </div>
        </div>

        <!-- Right Controls: Notifications, Public Link, Profile -->
        <div class="flex items-center gap-3 shrink-0">

            <!-- Notifications Bell -->
            <div class="relative flex items-center h-full">
                <button @click="notifyOpen = !notifyOpen" style="background: rgba(255,255,255,0.07);"
                    class="p-2 rounded-xl text-slate-300 hover:text-white relative transition-all flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span style="background: #D62828; color: white; width: 16px; height: 16px; min-width: 16px; min-height: 16px; max-width: 16px; max-height: 16px; border-radius: 50%; font-size: 9px; font-weight: 900; line-height: 1; display: flex; align-items: center; justify-content: center;"
                        class="absolute -top-1 -right-1 shadow-sm">5</span>
                </button>

                <!-- Notifications Dropdown (Positioned 58px down so it appears completely below the header) -->
                <div x-show="notifyOpen" @click.away="notifyOpen = false" x-cloak
                    style="background: #112240; border: 1px solid #1e3a5f; top: 56px;"
                    class="absolute right-0 w-72 rounded-2xl shadow-2xl py-2 z-50 text-xs text-slate-200">
                    <div class="px-4 py-2 border-b border-slate-800 flex justify-between font-bold">
                        <span class="text-white">System Alerts</span>
                        <span class="text-rose-400">5 New</span>
                    </div>
                    <div class="divide-y divide-slate-800 max-h-56 overflow-y-auto">
                        <div class="p-3 hover:bg-slate-800/80 cursor-pointer">
                            <div class="font-bold text-white">New Enrollment</div>
                            <div class="text-[11px] text-slate-400">Priya S. purchased Laravel 12</div>
                        </div>
                        <div class="p-3 hover:bg-slate-800/80 cursor-pointer">
                            <div class="font-bold text-white">Job Application</div>
                            <div class="text-[11px] text-slate-400">Rahul M. applied for TCS role</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Public Website Button -->
            <a href="{{ route('home') }}"
                style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white;"
                class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-white/20 transition-all text-decoration-none">
                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m-9 9a9 9 0 019-9" />
                </svg>
                Public Website
            </a>

            <!-- Admin Profile Badge -->
            <div class="relative flex items-center h-full">
                <button @click="profileOpen = !profileOpen"
                    class="flex items-center gap-2 p-1 rounded-xl hover:bg-white/10 transition-all">
                    <div style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; max-width: 32px; max-height: 32px; border-radius: 50%; background: #D62828; color: white; font-weight: 900; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; line-height: 1;"
                        class="shrink-0 shadow-sm">
                        {{ strtoupper(substr(auth()->user()?->first_name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-left hidden lg:block">
                        <div class="text-xs font-bold text-white leading-tight">
                            {{ auth()->user()?->name ?? 'Admin Account' }}</div>
                        <div class="text-[10px] text-slate-400 font-semibold">Super Admin</div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Profile Dropdown (Explicit top: 56px to sit completely below 64px navbar) -->
                <div x-show="profileOpen" @click.away="profileOpen = false" x-cloak
                    style="background: #112240; border: 1px solid #1e3a5f; top: 56px;"
                    class="absolute right-0 w-48 rounded-2xl shadow-2xl py-2 z-50 text-xs text-slate-200">
                    <a href="{{ route('profile.settings') }}" class="block px-4 py-2 hover:bg-slate-800 text-slate-200">Profile
                        Settings</a>
                    <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 hover:bg-slate-800 text-slate-200">Student
                        Portal</a>
                    <div class="border-t border-slate-800 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-rose-400 font-bold hover:bg-slate-800">Sign
                            Out</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>