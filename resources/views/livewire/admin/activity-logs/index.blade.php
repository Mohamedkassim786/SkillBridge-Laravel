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
                <span class="text-rose-400 font-bold">Activity Logs</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">System Audit & Activity Logs</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Audit trail of all platform user, staff, and administrator actions.</p>
        </div>
    </div>

    <!-- ACTION BAR (DARK NAVY CARD) -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-5 shadow-xl flex flex-col xl:flex-row xl:items-center justify-between gap-4 text-white">
        <!-- Left Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="clearOldLogs" wire:confirm="Clear audit logs older than 30 days?" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-slate-300 text-xs font-bold hover:bg-slate-700 hover:text-white transition-all">
                Clear 30+ Day Logs
            </button>
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-[300px]">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search logs, IP address..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="w-full pl-9 pr-4 py-2 rounded-xl text-xs font-medium text-white placeholder-slate-400 focus:outline-none focus:border-[#f15153]">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <select wire:model.live="selectedUser" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Users</option>
                @foreach ($users as $usr)
                    <option value="{{ $usr->id }}" class="text-slate-900">{{ $usr->first_name }} {{ $usr->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- SECTION 1: LOG STATISTICS (DARK NAVY CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Logs -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Recorded Logs</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalLogsCount) }}</h3>
        </div>

        <!-- Card 2: Active User Sessions -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Unique Active Users</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($activeUsersCount) }}</h3>
        </div>
    </div>

    <!-- SECTION 2: ACTIVITY LOGS TABLE (DARK NAVY TABLE) -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 text-white text-[11px] font-black uppercase tracking-wider border-b border-slate-800">
                        <th class="p-3.5">Timestamp</th>
                        <th class="p-3.5">User</th>
                        <th class="p-3.5">Action</th>
                        <th class="p-3.5">IP Address</th>
                        <th class="p-3.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 font-medium">
                    @forelse ($logs as $l)
                        @php
                            $actorName = $l->user ? ($l->user->first_name . ' ' . $l->user->last_name) : 'System Event';
                        @endphp
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <td class="p-3.5 font-mono text-[11px] text-slate-400">
                                {{ $l->created_at ? $l->created_at->format('d M Y, h:i:s A') : 'N/A' }}
                            </td>
                            <td class="p-3.5">
                                <div class="flex items-center gap-2">
                                    <div style="width: 26px; height: 26px; border-radius: 50%; background: #f15153; color: white; font-weight: 800; font-size: 11px;" class="flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($actorName, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white">{{ $actorName }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $l->user?->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    {{ $l->action }}
                                </span>
                            </td>
                            <td class="p-3.5 font-mono text-[11px] text-slate-400">
                                {{ $l->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="p-3.5 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    Success
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-semibold">No audit logs recorded in database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold text-slate-400">
            <span>Showing {{ $logs->count() }} of {{ $totalLogsCount }} audit logs</span>
            <div>{{ $logs->links() }}</div>
        </div>
    </div>

</div>
