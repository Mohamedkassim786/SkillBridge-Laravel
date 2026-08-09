<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Trainer Management & Approval Pipeline</h1>
            <p class="text-xs text-slate-300">Verify instructor qualifications, assign courses/batches, inspect class attendance, and manage status: <code>pending → approved → suspended → rejected</code>.</p>
        </div>
    </div>

    <!-- CONTROL BAR -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-4 rounded-3xl shadow-xl flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search trainer name, email..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold focus:outline-none placeholder-slate-400">
        </div>

        <select wire:model.live="verification_status" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Verification Statuses</option>
            <option value="pending">Pending Verification</option>
            <option value="approved">Approved</option>
            <option value="suspended">Suspended</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <!-- TRAINERS TABLE CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Trainer Info</th>
                        <th class="py-3 px-4">Assigned Courses</th>
                        <th class="py-3 px-4">Verification Status</th>
                        <th class="py-3 px-4">Account Status</th>
                        <th class="py-3 px-4 text-right">Approval Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($trainers as $t)
                        @php
                            $vStatus = $t->status ?? 'active';
                        @endphp
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white">{{ $t->name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $t->email }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">
                                {{ $t->assignedCourses->pluck('title')->implode(', ') ?: 'General Trainer' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $vStatus === 'approved' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : '' }}
                                    {{ $vStatus === 'pending' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30 animate-pulse' : '' }}
                                    {{ $vStatus === 'suspended' ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : '' }}
                                    {{ $vStatus === 'rejected' ? 'bg-slate-800 text-slate-400 border-slate-700' : '' }}">
                                    {{ strtoupper($vStatus) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    {{ strtoupper($t->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                @if ($vStatus === 'pending' || $vStatus === 'rejected')
                                    <button wire:click="updateTrainerVerification('{{ $t->id }}', 'approved')" style="background-color: #D62828;" class="px-3 py-1.5 rounded-xl text-white text-[11px] font-bold shadow-md">
                                        Approve Trainer
                                    </button>
                                    <button wire:click="updateTrainerVerification('{{ $t->id }}', 'rejected')" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold">
                                        Reject
                                    </button>
                                @elseif ($vStatus === 'approved')
                                    <button wire:click="updateTrainerVerification('{{ $t->id }}', 'suspended')" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                        Suspend Access
                                    </button>
                                @elseif ($vStatus === 'suspended')
                                    <button wire:click="updateTrainerVerification('{{ $t->id }}', 'approved')" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold">
                                        Reactivate
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No trainers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($trainers->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $trainers->links() }}
            </div>
        @endif
    </div>
</div>
