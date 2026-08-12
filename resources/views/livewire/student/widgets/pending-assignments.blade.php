<div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <span>📝 Pending Assignments</span>
        </h3>
        <a href="#" class="text-xs font-extrabold text-[#f15153] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($assignments as $a)
            <div style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);" class="p-4 rounded-2xl flex items-center justify-between gap-4 text-white">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-white">{{ $a->title }}</span>
                        @if ($a->priority === 'High')
                            <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30 text-[10px] font-black">High Priority</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-black">Medium</span>
                        @endif
                    </div>
                    <div class="text-xs mt-1" style="color: #a997be;">{{ $a->course }} • Due: <span class="font-bold text-white">{{ $a->due_date }}</span></div>
                </div>
                <a href="#" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="px-4 py-2 rounded-xl text-white font-black text-xs transition-all whitespace-nowrap text-decoration-none">
                    Submit Project
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs" style="color: #a997be;">No pending assignments. Great job!</div>
        @endforelse
    </div>
</div>
