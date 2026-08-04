<div class="p-6 rounded-3xl bg-[#0B1F3A] text-white shadow-xl relative overflow-hidden">
    <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#D62828]/20 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10 space-y-3">
        <div class="flex items-center justify-between gap-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[11px] font-bold text-slate-200 border border-white/15">
                🤖 AI Career Insight
            </span>
        </div>

        <h4 class="text-base font-bold text-white leading-snug">{{ $insight['headline'] ?? 'Next Career Milestone' }}</h4>
        <p class="text-xs text-slate-300 leading-relaxed">{{ $insight['insight'] ?? 'Completing Redis Caching will boost job matches by +12%.' }}</p>

        <div class="pt-2">
            <a href="#" class="w-full inline-flex justify-center py-2.5 px-4 rounded-xl bg-[#D62828] hover:bg-[#b7102a] text-white font-bold text-xs shadow-md transition-all">
                {{ $insight['recommended_action'] ?? 'Take Action Now' }}
            </a>
        </div>
    </div>
</div>
