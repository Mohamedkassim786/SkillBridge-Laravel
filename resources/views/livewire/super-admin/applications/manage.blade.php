<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Student Job Applications & Placement Pipeline</h1>
            <p class="text-xs text-slate-300">Track full status lifecycle: <code>applied → under_review → shortlisted → interview_scheduled → offer_received → hired → rejected → withdrawn</code>.</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-3xl shadow-xl flex items-center justify-between">
        <div class="text-xs font-bold text-slate-300">Filter Application Status:</div>

        <select wire:model.live="statusFilter" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Application Lifecycle Statuses</option>
            <option value="applied">Applied</option>
            <option value="under_review">Under Review</option>
            <option value="shortlisted">Shortlisted</option>
            <option value="interview_scheduled">Interview Scheduled</option>
            <option value="offer_received">Offer Received</option>
            <option value="hired">🏆 Hired (Placed)</option>
            <option value="rejected">Rejected</option>
            <option value="withdrawn">Withdrawn</option>
        </select>
    </div>

    <!-- APPLICATIONS TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Student Candidate</th>
                        <th class="py-3 px-4">Job Role & Company</th>
                        <th class="py-3 px-4">Applied Date</th>
                        <th class="py-3 px-4">Lifecycle Status</th>
                        <th class="py-3 px-4 text-right">Lifecycle Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($applications as $app)
                        @php
                            $st = $app->status ?? 'applied';
                        @endphp
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white">{{ $app->user?->name ?? 'Student' }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $app->user?->email ?? 'N/A' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white">{{ $app->jobPosting?->title ?? 'Developer Role' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $app->jobPosting?->company?->name ?? 'Company' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ $app->created_at->format('M d, Y') }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $st === 'hired' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30 font-black' : '' }}
                                    {{ $st === 'offer_received' ? 'bg-cyan-500/20 text-cyan-300 border-cyan-500/30' : '' }}
                                    {{ $st === 'interview_scheduled' ? 'bg-purple-500/20 text-purple-300 border-purple-500/30' : '' }}
                                    {{ $st === 'shortlisted' ? 'bg-blue-500/20 text-blue-300 border-blue-500/30' : '' }}
                                    {{ $st === 'under_review' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : '' }}
                                    {{ $st === 'rejected' ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : '' }}
                                    {{ $st === 'applied' ? 'bg-slate-800 text-slate-300 border-slate-700' : '' }}">
                                    {{ strtoupper(str_replace('_', ' ', $st)) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1">
                                <button wire:click="updateApplicationStatus('{{ $app->id }}', 'shortlisted')" class="px-2.5 py-1 rounded-xl bg-blue-600/80 text-white text-[10px] font-bold">Shortlist</button>
                                <button wire:click="updateApplicationStatus('{{ $app->id }}', 'interview_scheduled')" class="px-2.5 py-1 rounded-xl bg-purple-600/80 text-white text-[10px] font-bold">Interview</button>
                                <button wire:click="updateApplicationStatus('{{ $app->id }}', 'hired')" class="px-2.5 py-1 rounded-xl bg-emerald-600 text-white text-[10px] font-bold">Mark Hired</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No job applications recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($applications->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
