<header class="sticky top-0 z-40 bg-[#0B1F3A] border-b border-[#1e3a5f] text-white shadow-xl">
    <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
        <!-- Left Mobile Sidebar Toggle & Brand -->
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-[#D62828] flex items-center justify-center font-extrabold text-sm text-white shadow-md shadow-[#D62828]/30">
                    SB
                </div>
                <span class="text-xl font-black tracking-tight text-white hidden sm:inline">SkillBridge</span>
            </a>
        </div>

        <!-- Global Search Input -->
        <div class="flex-1 max-w-md hidden sm:block">
            <div class="relative">
                <input type="text" placeholder="Search courses, lessons, assignments, jobs..."
                       style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                       class="w-full pl-10 pr-4 py-2 rounded-xl text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#D62828]/50 transition-all">
                <div class="absolute left-3 top-2.5 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Right Quick Control Icons & Profile Dropdown -->
        <div class="flex items-center gap-3">
            <!-- Notifications Bell -->
            <a href="#" class="relative p-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#D62828] animate-ping"></span>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#D62828]"></span>
            </a>

            <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs border border-slate-700 transition-all">
                🌐 Website
            </a>

            @if (in_array(auth()->user()?->role, ['admin', 'super_admin']))
                <div class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('admin.courses.manage') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs transition-all">
                        📚 Courses
                    </a>
                    <a href="{{ route('admin.lessons.manage') }}" class="px-3 py-1.5 rounded-xl bg-[#D62828] hover:bg-red-700 text-white font-extrabold text-xs shadow-md transition-all">
                        🎬 Videos
                    </a>
                    <a href="{{ route('admin.enrollments.manage') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs transition-all">
                        🎓 Enrollments
                    </a>
                </div>
            @endif

            <!-- Student Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-white/10 transition-colors focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-[#D62828] text-white font-bold text-xs flex items-center justify-center border border-white/20">
                        {{ strtoupper(substr(auth()->user()->first_name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <div class="text-xs font-bold text-white leading-tight">{{ auth()->user()->name ?? 'Student User' }}</div>
                        <div class="text-[10px] text-slate-300">Student Account</div>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition style="top: 56px; background-color: #0B1F3A; border: 1px solid #1e3a5f;"
                     class="absolute right-0 w-56 rounded-2xl shadow-2xl py-2 text-white z-50">
                    <div class="px-4 py-3 border-b border-slate-800">
                        <p class="text-xs font-bold text-slate-400">Signed in as</p>
                        <p class="text-xs font-black text-white truncate mt-0.5">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-xs font-bold text-slate-200 hover:bg-white/10 hover:text-white">Profile Settings</a>
                    <a href="{{ route('sessions.manage') }}" class="block px-4 py-2 text-xs font-bold text-slate-200 hover:bg-white/10 hover:text-white">Active Sessions</a>
                    <a href="{{ route('password.change') }}" class="block px-4 py-2 text-xs font-bold text-slate-200 hover:bg-white/10 hover:text-white">Change Password</a>
                    <div class="border-t border-slate-800 mt-2 pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs font-black text-rose-400 hover:bg-rose-500/20">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
