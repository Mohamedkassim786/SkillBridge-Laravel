<div class="space-y-6" x-data="{}">

    <!-- Flash Status Messages -->
    @if (session()->has('status'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold text-xs flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-sm">✕</button>
        </div>
    @endif

    <!-- TOP SECTION & BREADCRUMB -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <span>&gt;</span>
                <span class="text-rose-400 font-bold">Backups</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Backup & Disaster Recovery</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Automated database backups, cloud archiving, and disaster recovery tools.</p>
        </div>
    </div>

    <!-- SECTION 1: BACKUP STATUS (3 CARDS) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Card 1: Database Size -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">MySQL 8 Database Size</p>
            <h3 class="text-2xl font-black text-white mt-1">14.2 MB</h3>
        </div>

        <!-- Card 2: Last Backup -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Last Automated Backup</p>
            <h3 class="text-2xl font-black text-white mt-1">Today, 2:00 AM</h3>
        </div>

        <!-- Card 3: Storage Location -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cloud Vault Target</p>
            <h3 class="text-2xl font-black text-white mt-1">AWS S3 (Encrypted)</h3>
        </div>
    </div>

    <!-- SECTION 2: MANUAL BACKUP CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
        <div class="border-b border-slate-800 pb-3 flex items-center justify-between">
            <div>
                <h3 class="text-base font-black text-white tracking-tight">Create Instant System Snapshot</h3>
                <p class="text-xs text-slate-400 font-medium">Create an immediate compressed backup dump of database tables and assets.</p>
            </div>
            <button type="button" wire:click="createManualBackup" style="background-color: #f15153;" class="px-6 py-3 rounded-xl text-white font-black text-xs shadow-lg hover:bg-red-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                <span>Create Backup Now</span>
            </button>
        </div>
    </div>

</div>
