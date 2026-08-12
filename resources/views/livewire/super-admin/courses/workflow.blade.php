<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Course Approval & Workflow Lifecycle Pipeline</h1>
            <p class="text-xs text-slate-300">Control real status workflow: <code>draft → pending_review → approved → published → archived / rejected</code>.</p>
        </div>
    </div>

    <!-- CONTROL BAR -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="p-4 rounded-3xl shadow-xl flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search course title..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold focus:outline-none placeholder-slate-400">
        </div>

        <select wire:model.live="status" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Statuses</option>
            <option value="draft">Draft</option>
            <option value="pending_review">Pending Review</option>
            <option value="approved">Approved</option>
            <option value="published">Published</option>
            <option value="rejected">Rejected</option>
            <option value="archived">Archived</option>
        </select>
    </div>

    <!-- COURSES TABLE CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Course</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Assigned Trainer</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Workflow Status</th>
                        <th class="py-3 px-4 text-right">Pipeline Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($courses as $c)
                        @php
                            $st = ($c->currentVersion?->is_published ?? true) ? 'published' : 'draft';
                        @endphp
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-bold text-white max-w-xs">{{ $c->title }}</td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $c->category?->name ?? 'Software Engineering' }}</td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $c->trainer?->name ?? 'Senior Trainer' }}</td>
                            <td class="py-3.5 px-4 font-bold text-emerald-400">₹{{ number_format($c->currentVersion?->price ?? 2999) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $st === 'published' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : '' }}
                                    {{ $st === 'approved' ? 'bg-blue-500/20 text-blue-300 border-blue-500/30' : '' }}
                                    {{ $st === 'pending_review' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30 animate-pulse' : '' }}
                                    {{ $st === 'rejected' ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : '' }}
                                    {{ $st === 'archived' ? 'bg-slate-800 text-slate-400 border-slate-700' : '' }}">
                                    {{ strtoupper($st) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                @if ($st === 'pending_review' || $st === 'draft')
                                    <button wire:click="updateCourseStatus('{{ $c->id }}', 'approved')" class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold">
                                        Approve
                                    </button>
                                    <button wire:click="updateCourseStatus('{{ $c->id }}', 'rejected')" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                        Reject
                                    </button>
                                @elseif ($st === 'approved')
                                    <button wire:click="updateCourseStatus('{{ $c->id }}', 'published')" style="background-color: #f15153;" class="px-3 py-1.5 rounded-xl text-white text-[11px] font-bold shadow-md">
                                        Publish Now
                                    </button>
                                @elseif ($st === 'published')
                                    <button wire:click="updateCourseStatus('{{ $c->id }}', 'archived')" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold">
                                        Archive
                                    </button>
                                @elseif ($st === 'archived')
                                    <button wire:click="updateCourseStatus('{{ $c->id }}', 'published')" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold">
                                        Restore
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No courses match your workflow criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($courses->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
