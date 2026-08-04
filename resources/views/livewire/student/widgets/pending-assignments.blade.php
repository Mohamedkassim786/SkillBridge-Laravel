<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>📝 Pending Assignments</span>
        </h3>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($assignments as $a)
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-[#0B1F3A]">{{ $a->title }}</span>
                        @if ($a->priority === 'High')
                            <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold">High Priority</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold">Medium</span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-500 mt-1">{{ $a->course }} • Due: <span class="font-semibold text-slate-700">{{ $a->due_date }}</span></div>
                </div>
                <a href="#" class="px-4 py-2 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
                    Submit Project
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-500">No pending assignments. Great job!</div>
        @endforelse
    </div>
</div>
