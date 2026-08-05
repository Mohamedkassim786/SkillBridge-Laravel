<div class="space-y-6">

    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">User & Student Management</h1>
            <p class="text-xs text-slate-500 mt-1">Manage all registered students, instructors, admins, and staff accounts.</p>
        </div>

        <div class="flex items-center gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-rose-500">
            <select wire:model.live="roleFilter" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:border-rose-500">
                <option value="">All Roles</option>
                <option value="student">Students</option>
                <option value="trainer">Instructors</option>
                <option value="admin">Admins</option>
            </select>
        </div>
    </div>

    <!-- USERS DATA TABLE -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-900">
                        <th class="p-4 font-bold">ID</th>
                        <th class="p-4 font-bold">User</th>
                        <th class="p-4 font-bold">Role</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold">Joined Date</th>
                        <th class="p-4 font-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $u)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-slate-400 font-mono">#{{ $u->id }}</td>
                            <td class="p-4 font-bold text-slate-900 flex items-center gap-3">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 12px;" class="flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-slate-900">{{ $u->name }}</div>
                                    <div class="text-[11px] text-slate-500 font-normal">{{ $u->email }}</div>
                                </div>
                            </td>
                            <td class="p-4 font-bold text-rose-600 capitalize">{{ $u->role }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 capitalize">
                                    {{ $u->status ?? 'active' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-500 font-medium">{{ $u->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="p-4 text-center">
                                <button class="px-3 py-1 bg-slate-100 border border-slate-200 text-slate-800 rounded-lg text-xs font-bold hover:bg-slate-200">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">No users found matching your filter criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>

</div>
