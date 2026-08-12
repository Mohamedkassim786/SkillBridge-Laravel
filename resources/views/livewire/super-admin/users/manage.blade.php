<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">All Users Directory & Controls</h1>
            <p class="text-xs text-slate-300">View, search, filter, block, reset passwords, and audit all platform accounts.</p>
        </div>
    </div>

    <!-- CONTROL & FILTERS BAR -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-3xl shadow-xl flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search name, email, user ID..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#f15153] placeholder-slate-400">
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <select wire:model.live="role" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                <option value="">All Roles</option>
                <option value="student">Student</option>
                <option value="staff">Staff / Trainer</option>
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>

            <select wire:model.live="status" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
                <option value="pending">Pending</option>
            </select>
        </div>
    </div>

    <!-- USERS TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">User Details</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Account Status</th>
                        <th class="py-3 px-4">Email Verified</th>
                        <th class="py-3 px-4">Joined Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($users as $u)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white">{{ $u->name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $u->email }}</div>
                                <div class="text-[10px] text-slate-500 font-mono">ID: {{ $u->id }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $u->hasRole('super_admin') ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : '' }}
                                    {{ $u->hasRole('admin') ? 'bg-purple-500/20 text-purple-300 border-purple-500/30' : '' }}
                                    {{ $u->hasRole('staff') ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : '' }}
                                    {{ $u->hasRole('student') ? 'bg-blue-500/20 text-blue-300 border-blue-500/30' : '' }}">
                                    {{ $u->roles->pluck('name')->implode(', ') ?: 'User' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $u->status === 'active' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border-rose-500/30' }}">
                                    {{ strtoupper($u->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($u->email_verified_at)
                                    <span class="text-emerald-400 font-bold">✓ Verified</span>
                                @else
                                    <span class="text-slate-500 font-bold">Unverified</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $u->created_at->format('M d, Y') }}</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button wire:click="toggleStatus('{{ $u->id }}')" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold">
                                    {{ $u->status === 'active' ? 'Block' : 'Unblock' }}
                                </button>
                                <button wire:click="openPasswordModal('{{ $u->id }}')" class="px-3 py-1.5 rounded-xl bg-amber-600/80 hover:bg-amber-600 text-white text-[11px] font-bold">
                                    Reset Password
                                </button>
                                <button wire:click="forceLogout('{{ $u->id }}')" class="px-3 py-1.5 rounded-xl bg-purple-600/80 hover:bg-purple-600 text-white text-[11px] font-bold">
                                    Logout
                                </button>
                                <button wire:click="deleteUser('{{ $u->id }}')" wire:confirm="Are you sure you want to delete this user?" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No users match your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- PASSWORD RESET MODAL -->
    @if ($showPasswordModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-2xl max-w-md w-full text-white space-y-4">
                <h3 class="text-base font-black text-white">Reset Password for {{ $selectedUser?->name }}</h3>
                <p class="text-xs text-slate-300">Set a new strong password for this account. System audit log will record this action.</p>

                <form wire:submit.prevent="resetPassword" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">New Password</label>
                        <input type="password" wire:model="newPassword" required placeholder="At least 8 characters..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs focus:outline-none">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showPasswordModal', false)" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs">Cancel</button>
                        <button type="submit" style="background-color: #f15153;" class="px-5 py-2 rounded-xl text-white font-bold text-xs shadow-md">Confirm Reset</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
