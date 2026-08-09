<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-8 rounded-3xl text-white relative overflow-hidden shadow-xl">
    <!-- Glow Background Accents -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#D62828]/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-slate-200 border border-white/10 backdrop-blur-md">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                <span>{{ $streak }}-Day Learning Streak</span>
                <span class="text-slate-400">•</span>
                <span>{{ $batch }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                {{ $greeting }}, {{ $name }}!
            </h1>

            <p class="text-sm sm:text-base text-slate-300 max-w-xl">
                Ready to continue your software learning path? You have 1 pending assignment due tomorrow and 2 active job recommendations waiting.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <a href="#" class="px-6 py-3.5 rounded-xl bg-[#D62828] hover:bg-[#b7102a] text-white font-bold text-sm shadow-lg shadow-[#D62828]/30 transition-all flex items-center justify-center gap-2">
                <span>Resume Active Lesson</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
