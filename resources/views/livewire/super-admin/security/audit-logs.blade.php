<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Full Security Audit Logs & System Trail</h1>
            <p class="text-xs text-slate-300">Track all critical actions: <code>user_created, user_blocked, role_changed, course_approved, payment_refunded, admin_created, settings_updated, backup_created</code>.</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-3xl shadow-xl flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search IP, action, user..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2 rounded-xl text-xs font-semibold focus:outline-none">
        </div>

        <select wire:model.live="actionFilter" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Action Types</option>
            @foreach ($distinctActions as $act)
                <option value="{{ $act }}">{{ $act }}</option>
            @endforeach
        </select>
    </div>

    <!-- AUDIT LOGS TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Log ID</th>
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Action</th>
                        <th class="py-3 px-4">Entity Type</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($auditLogs as $log)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-mono text-slate-500">#{{ $log->id }}</td>
                            <td class="py-3.5 px-4 font-bold text-white">{{ $log->user?->name ?? 'System Root' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ class_basename($log->auditable_type ?? 'N/A') }} #{{ $log->auditable_id }}</td>
                            <td class="py-3.5 px-4 font-mono text-emerald-400">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No audit trail records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($auditLogs->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </div>
</div>
