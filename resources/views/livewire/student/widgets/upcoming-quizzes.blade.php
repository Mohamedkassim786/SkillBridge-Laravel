<div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <span>❓ Upcoming Quizzes</span>
        </h3>
        <a href="#" class="text-xs font-extrabold text-[#f15153] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($quizzes as $q)
            <div style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);" class="p-4 rounded-2xl flex items-center justify-between gap-4 text-white">
                <div>
                    <div class="text-sm font-bold text-white">{{ $q->title }}</div>
                    <div class="text-xs mt-1" style="color: #a997be;">{{ $q->course }} • Duration: {{ $q->duration }} • <span class="text-amber-400 font-semibold">{{ $q->attempts_left }} attempts left</span></div>
                </div>
                <a href="#" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="px-4 py-2 rounded-xl text-white font-black text-xs transition-all whitespace-nowrap text-decoration-none">
                    Start Quiz
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs" style="color: #a997be;">No quizzes active right now.</div>
        @endforelse
    </div>
</div>
