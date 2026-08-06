<div class="space-y-6">

    <!-- ACTION BAR HEADER (Dark Navy Card) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-white">User & Student Management</h1>
            <p class="text-xs text-slate-400 mt-1">Manage all registered students, instructors, admins, and staff accounts.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;" class="px-4 py-2 rounded-xl text-xs text-white placeholder-slate-400 focus:outline-none focus:border-rose-500 font-medium">
            </div>

            <select wire:model.live="roleFilter" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-4 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Roles</option>
                <option value="student" class="text-slate-900">Students</option>
                <option value="trainer" class="text-slate-900">Instructors</option>
                <option value="staff" class="text-slate-900">Staff</option>
                <option value="admin" class="text-slate-900">Admins</option>
                <option value="super_admin" class="text-slate-900">Super Admins</option>
            </select>
        </div>
    </div>

    <!-- USERS DATA TABLE (Dark Navy Card) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 border-b border-slate-800 text-white text-xs uppercase tracking-wider">
                        <th class="p-4 font-bold">ID</th>
                        <th class="p-4 font-bold">User</th>
                        <th class="p-4 font-bold">Role</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold">Joined Date</th>
                        <th class="p-4 font-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($users as $u)
                        @php
                            $roleName = $u->roles->first()?->name ?? 'student';
                            $fullName = trim($u->first_name . ' ' . $u->last_name);
                            if (empty($fullName)) { $fullName = $u->name ?? 'User'; }
                        @endphp
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <td class="p-4 text-slate-400 font-mono text-[11px]">#{{ substr($u->id, 0, 18) }}...</td>
                            <td class="p-4 font-bold text-white flex items-center gap-3">
                                <div style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; max-width: 32px; max-height: 32px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; justify-content: center;" class="shrink-0">
                                    {{ strtoupper(substr($fullName, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-white font-bold text-xs">{{ $fullName }}</div>
                                    <div class="text-[11px] text-slate-400 font-normal">{{ $u->email }}</div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-500/20 text-blue-300 border border-blue-500/30 uppercase tracking-wider">
                                    {{ str_replace('_', ' ', $roleName) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 capitalize">
                                    {{ $u->status ?? 'active' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-400 font-medium">{{ $u->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="p-4 text-center">
                                <button class="px-3 py-1 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg text-xs font-bold hover:bg-slate-700 hover:text-white transition-all">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-semibold">No users found matching your filter criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
    </div>

</div>
