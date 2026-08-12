<header x-data="{ profileOpen: false }" style="background-color: #210f30; border-bottom: 1px solid rgba(241,81,83,0.25);" class="h-16 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 shadow-lg">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-purple-200 hover:text-white hover:bg-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <a href="{{ route('super_admin.dashboard') }}" class="flex items-center gap-3 text-decoration-none">
            <div style="width: 38px; height: 38px; border-radius: 12px; background: linear-gradient(135deg, #f15153, #f87171); color: white; font-weight: 900; font-size: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(241,81,83,0.4);" class="shrink-0">
                SB
            </div>
            <div>
                <div class="text-sm font-black text-white leading-none">SkillBridge</div>
                <div class="text-[10px] font-bold text-rose-400 uppercase tracking-widest mt-1">SUPER ADMIN CONTROL</div>
            </div>
        </a>
    </div>

    <!-- Right Actions -->
    <div class="flex items-center gap-4 text-xs font-bold">
        <!-- Live System Badge -->
        <div style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3);" class="hidden sm:flex px-3 py-1.5 rounded-full text-emerald-300 items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>REAL-TIME ENGINE ACTIVE</span>
        </div>

        <a href="{{ route('home') }}" target="_blank" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);" class="px-3 py-1.5 rounded-xl text-purple-200 hover:text-white hover:bg-white/10 transition text-decoration-none hidden sm:inline-block">
            🌐 View Public Website ↗
        </a>

        <!-- User Profile Dropdown / Badge -->
        <div class="relative flex items-center h-full pl-3 border-l border-purple-800/40">
            <button @click="profileOpen = !profileOpen" class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-white/10 transition-all text-left cursor-pointer focus:outline-none">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #f15153; color: white; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center;" class="shrink-0 shadow-sm">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'S', 0, 1)) }}
                </div>
                <div class="hidden md:block text-left">
                    <div class="text-xs font-bold text-white leading-tight flex items-center gap-1">
                        <span>{{ auth()->user()?->name ?? 'Super Admin' }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="text-[10px] text-rose-400 font-semibold">System Root</div>
                </div>
            </button>

            <!-- Profile Dropdown Menu -->
            <div x-show="profileOpen" @click.away="profileOpen = false" x-cloak
                style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); top: 52px;"
                class="absolute right-0 w-48 rounded-2xl shadow-2xl py-2 z-50 text-xs text-slate-200">
                <a href="{{ route('profile.settings') }}" class="block px-4 py-2 hover:bg-slate-800 text-slate-200 text-decoration-none">Profile Settings</a>
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-slate-800 text-slate-200 text-decoration-none">Admin Panel</a>
                <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 hover:bg-slate-800 text-slate-200 text-decoration-none">Student Portal</a>
                <div class="border-t border-slate-800 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-rose-400 font-bold hover:bg-slate-800 cursor-pointer">
                        Sign Out / Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
