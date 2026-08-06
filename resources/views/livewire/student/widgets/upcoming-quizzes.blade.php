<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <span>❓ Upcoming Quizzes</span>
        </h3>
        <a href="#" class="text-xs font-extrabold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($quizzes as $q)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl flex items-center justify-between gap-4 text-white">
                <div>
                    <div class="text-sm font-bold text-white">{{ $q->title }}</div>
                    <div class="text-xs text-slate-400 mt-1">{{ $q->course }} • Duration: {{ $q->duration }} • <span class="text-amber-400 font-semibold">{{ $q->attempts_left }} attempts left</span></div>
                </div>
                <a href="#" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-md transition-all whitespace-nowrap text-decoration-none">
                    Start Quiz
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-400">No quizzes active right now.</div>
        @endforelse
    </div>
</div>
