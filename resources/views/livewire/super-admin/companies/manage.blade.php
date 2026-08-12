<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Hiring Companies & Recruiter Verification</h1>
            <p class="text-xs text-slate-300">Approve partner companies, inspect posted jobs, and manage platform verification status.</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-3xl shadow-xl flex items-center justify-between">
        <div class="w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search company name..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2 rounded-xl text-xs font-semibold focus:outline-none">
        </div>
    </div>

    <!-- COMPANIES TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Company Name</th>
                        <th class="py-3 px-4">Website</th>
                        <th class="py-3 px-4">Active Jobs Posted</th>
                        <th class="py-3 px-4">Verification Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($companies as $c)
                        @php
                            $st = $c->status ?? 'approved';
                        @endphp
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-bold text-white">{{ $c->name }}</td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ $c->website ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-bold text-cyan-400">{{ $c->job_postings_count }} jobs</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $st === 'approved' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border-rose-500/30' }}">
                                    {{ strtoupper($st) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button wire:click="toggleVerification('{{ $c->id }}')" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold">
                                    {{ $st === 'approved' ? 'Suspend' : 'Approve' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No companies found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($companies->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
</div>
