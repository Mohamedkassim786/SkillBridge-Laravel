<div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl text-white shadow-xl relative overflow-hidden">
    <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#f15153]/20 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10 space-y-3">
        <div class="flex items-center justify-between gap-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[11px] font-bold text-white border border-white/15">
                <svg class="w-3.5 h-3.5 text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>AI Career Insight</span>
            </span>
        </div>

        <h4 class="text-base font-bold text-white leading-snug">{{ $insight['headline'] ?? 'Next Career Milestone' }}</h4>
        <p class="text-xs leading-relaxed" style="color: #d4c5e2;">{{ $insight['insight'] ?? 'Completing Redis Caching will boost job matches by +12%.' }}</p>

        <div class="pt-2">
            <a href="#" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="w-full inline-flex justify-center py-2.5 px-4 rounded-xl text-white font-bold text-xs transition-all">
                {{ $insight['recommended_action'] ?? 'Take Action Now' }}
            </a>
        </div>
    </div>
</div>
