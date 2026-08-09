<header style="background-color: #0B1F3A; border-bottom: 1px solid rgba(255,255,255,0.08);" class="h-16 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 shadow-lg">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <a href="{{ route('super_admin.dashboard') }}" class="flex items-center gap-3 text-decoration-none">
            <div style="width: 38px; height: 38px; border-radius: 12px; background: linear-gradient(135deg, #D62828, #f87171); color: white; font-weight: 900; font-size: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(214,40,40,0.4);" class="shrink-0">
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
        <div style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3);" class="px-3 py-1.5 rounded-full text-emerald-300 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>REAL-TIME ENGINE ACTIVE</span>
        </div>

        <a href="{{ route('home') }}" target="_blank" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);" class="px-3 py-1.5 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition text-decoration-none hidden sm:inline-block">
            🌐 View Public Website ↗
        </a>

        <!-- User Profile Dropdown / Badge -->
        <div class="flex items-center gap-2.5 pl-3 border-l border-slate-800">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center;">
                {{ strtoupper(substr(auth()->user()?->name ?? 'S', 0, 1)) }}
            </div>
            <div class="hidden md:block text-left">
                <div class="text-xs font-bold text-white leading-tight">{{ auth()->user()?->name ?? 'Super Admin' }}</div>
                <div class="text-[10px] text-rose-400 font-semibold">System Root</div>
            </div>
        </div>
    </div>
</header>
