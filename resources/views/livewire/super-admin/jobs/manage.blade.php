<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Job Openings Marketplace & Approvals</h1>
            <p class="text-xs text-slate-300">Approve job postings, toggle featured homepage status, and manage career listings.</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-3xl shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search job title, location..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2 rounded-xl text-xs font-semibold focus:outline-none">
        </div>

        <select wire:model.live="statusFilter" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
            <option value="closed">Closed</option>
        </select>
    </div>

    <!-- JOBS TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Job Title</th>
                        <th class="py-3 px-4">Company</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4">Salary</th>
                        <th class="py-3 px-4">Featured</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($jobs as $j)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-bold text-white max-w-xs">{{ $j->title }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-300">{{ $j->company?->name ?? 'Enterprise Company' }}</td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $j->location ?? 'Remote' }}</td>
                            <td class="py-3.5 px-4 font-bold text-emerald-400">₹{{ number_format($j->salary_min) }} - ₹{{ number_format($j->salary_max) }}</td>
                            <td class="py-3.5 px-4">
                                <button wire:click="toggleFeatured('{{ $j->id }}')" class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $j->is_featured ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                                    {{ $j->is_featured ? '⭐ Featured' : 'Standard' }}
                                </button>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button wire:click="deleteJob('{{ $j->id }}')" wire:confirm="Remove this job posting?" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No jobs match your search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jobs->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</div>
