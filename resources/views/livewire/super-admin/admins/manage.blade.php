<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Multi-Admin Management & Controls</h1>
            <p class="text-xs text-slate-300">Create admin accounts, restrict module permissions, view login history, and revoke sessions.</p>
        </div>

        <button wire:click="openCreateModal" style="background-color: #f15153;" class="px-5 py-2.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition">
            + Create Admin Account
        </button>
    </div>

    <!-- ADMINS LIST CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Admin Name</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Last Login</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach ($admins as $adm)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-bold text-white">{{ $adm->name }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">{{ $adm->email }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $adm->hasRole('super_admin') ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : 'bg-purple-500/20 text-purple-300 border-purple-500/30' }}">
                                    {{ $adm->roles->pluck('name')->implode(', ') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    ACTIVE
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $adm->loginHistories->first()?->created_at?->diffForHumans() ?? 'Recent Session' }}
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button wire:click="viewLoginHistory('{{ $adm->id }}')" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold">
                                    Login History
                                </button>
                                <button wire:click="revokeSessions('{{ $adm->id }}')" class="px-3 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-[11px] font-bold">
                                    Revoke Sessions
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- CREATE ADMIN MODAL -->
    @if ($showCreateModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-2xl max-w-lg w-full text-white space-y-4">
                <h3 class="text-base font-black text-white">Create Admin Account</h3>
                <p class="text-xs text-slate-300">Grant administrative access to SkillBridge management suite.</p>

                <form wire:submit.prevent="createAdmin" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Full Name</label>
                        <input type="text" wire:model="name" required placeholder="e.g. System Administrator" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Email Address</label>
                        <input type="email" wire:model="email" required placeholder="admin@skillbridge.com" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Password</label>
                        <input type="password" wire:model="password" required placeholder="Strong password..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Role Assignment</label>
                        <select wire:model="role" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs font-bold">
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin (Root Privilege)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs">Cancel</button>
                        <button type="submit" style="background-color: #f15153;" class="px-5 py-2 rounded-xl text-white font-bold text-xs shadow-md">Create Admin</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- LOGIN HISTORY MODAL -->
    @if ($selectedAdminForHistory)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-2xl max-w-2xl w-full text-white space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-black text-white">Login History for {{ $selectedAdminForHistory->name }}</h3>
                    <button wire:click="$set('selectedAdminForHistory', null)" class="text-slate-400 hover:text-white text-xs">✕ Close</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-bold">
                                <th class="py-2.5 px-3">IP Address</th>
                                <th class="py-2.5 px-3">Device / Agent</th>
                                <th class="py-2.5 px-3">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 text-slate-300">
                            @forelse ($loginHistory as $lh)
                                <tr>
                                    <td class="py-2.5 px-3 font-mono text-emerald-400">{{ $lh->ip_address }}</td>
                                    <td class="py-2.5 px-3 text-slate-400 truncate max-w-xs">{{ $lh->user_agent }}</td>
                                    <td class="py-2.5 px-3 text-slate-400">{{ $lh->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-slate-400">No login logs recorded for this account.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
