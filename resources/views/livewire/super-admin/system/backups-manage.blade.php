<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Database Backup & Disaster Recovery Center</h1>
            <p class="text-xs text-slate-300">Generate manual database snapshots, download backups, set retention rules, and execute safe database restores.</p>
        </div>

        <button wire:click="generateManualBackup" wire:loading.attr="disabled" style="background-color: #f15153;" class="px-5 py-2.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition flex items-center gap-2">
            <span wire:loading.remove>⚡ Create Manual DB Backup</span>
            <span wire:loading>Generating Backup...</span>
        </button>
    </div>

    <!-- BACKUPS TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <h3 class="text-base font-black text-white">Backup Snapshot Archive</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Backup Snapshot File</th>
                        <th class="py-3 px-4">Size</th>
                        <th class="py-3 px-4">Created Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach ($backups as $b)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-white">{{ $b->filename }}</td>
                            <td class="py-3.5 px-4 text-cyan-400 font-bold">{{ $b->size }}</td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ $b->created_at }}</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button wire:click="downloadBackup('{{ $b->filename }}')" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold shadow-md">
                                    ⬇️ Download SQL
                                </button>
                                <button wire:click="$set('showRestoreConfirmModal', true)" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                    Restore Backup
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- RESTORE CONFIRMATION MODAL -->
    @if ($showRestoreConfirmModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-2xl max-w-md w-full text-white space-y-4">
                <div class="p-3 rounded-2xl bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs font-bold">
                    ⚠️ DANGER: Restoring a database backup replaces active database state. Logged action will audit to trail.
                </div>

                <h3 class="text-base font-black text-white">Confirm Database Restore</h3>
                <p class="text-xs text-slate-300">Type <code>RESTORE DATABASE</code> below to authorize this action.</p>

                <form wire:submit.prevent="confirmRestore" class="space-y-4">
                    <div>
                        <input type="text" wire:model="confirmRestoreText" required placeholder="RESTORE DATABASE" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs font-mono">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showRestoreConfirmModal', false)" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs">Cancel</button>
                        <button type="submit" style="background-color: #f15153;" class="px-5 py-2 rounded-xl text-white font-bold text-xs shadow-md">Authorize Restore</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
