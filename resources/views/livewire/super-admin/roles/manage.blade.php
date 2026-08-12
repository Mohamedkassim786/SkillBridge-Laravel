<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Roles & Spatie Permissions Matrix</h1>
            <p class="text-xs text-slate-300">Manage security roles, assign capability permissions, and configure custom role access.</p>
        </div>

        <button wire:click="$set('showRoleModal', true)" style="background-color: #f15153;" class="px-5 py-2.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition">
            + Create Custom Role
        </button>
    </div>

    <!-- ROLES & PERMISSIONS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($roles as $r)
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                            {{ $r->name === 'super_admin' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30' }}">
                            {{ strtoupper(str_replace('_', ' ', $r->name)) }}
                        </span>
                        <span class="text-xs text-slate-400 font-bold">Role ID: {{ $r->id }}</span>
                    </div>

                    <h3 class="text-lg font-black text-white mt-3">{{ ucfirst(str_replace('_', ' ', $r->name)) }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Guard: <code class="text-rose-400">{{ $r->guard_name }}</code></p>
                </div>

                <div class="pt-4 border-t border-slate-800 space-y-2">
                    <div class="text-[11px] font-bold text-slate-300">Assigned Capabilities:</div>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse ($r->permissions as $p)
                            <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 text-[10px] font-mono border border-slate-700">
                                {{ $p->name }}
                            </span>
                        @empty
                            <span class="text-[11px] text-slate-500 italic">Full Root Super Admin Privileges</span>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- PERMISSION GROUPS AUDIT LIST -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <h3 class="text-base font-black text-white">Available Permission Capability Groups</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
            @foreach ($permissionGroups as $groupName => $perms)
                <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-2xl space-y-2">
                    <div class="text-xs font-black text-rose-400 uppercase tracking-wider">{{ $groupName }}</div>
                    <div class="space-y-1">
                        @foreach ($perms as $perm)
                            <div class="text-xs text-slate-300 font-mono flex items-center gap-2">
                                <span class="text-emerald-400">✓</span>
                                <span>{{ $perm }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CREATE ROLE MODAL -->
    @if ($showRoleModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-2xl max-w-md w-full text-white space-y-4">
                <h3 class="text-base font-black text-white">Create Custom Security Role</h3>

                <form wire:submit.prevent="createRole" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Role Name</label>
                        <input type="text" wire:model="newRoleName" required placeholder="e.g. content_moderator" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs font-mono">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showRoleModal', false)" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs">Cancel</button>
                        <button type="submit" style="background-color: #f15153;" class="px-5 py-2 rounded-xl text-white font-bold text-xs shadow-md">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
