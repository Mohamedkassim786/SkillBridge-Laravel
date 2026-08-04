<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>❓ Upcoming Quizzes</span>
        </h3>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($quizzes as $q)
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-4">
                <div>
                    <div class="text-sm font-bold text-[#0B1F3A]">{{ $q->title }}</div>
                    <div class="text-xs text-slate-500 mt-1">{{ $q->course }} • Duration: {{ $q->duration }} • <span class="text-amber-700 font-semibold">{{ $q->attempts_left }} attempts left</span></div>
                </div>
                <a href="#" class="px-4 py-2 rounded-xl bg-[#D62828] hover:bg-[#b7102a] text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
                    Start Quiz
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-500">No quizzes active right now.</div>
        @endforelse
    </div>
</div>
