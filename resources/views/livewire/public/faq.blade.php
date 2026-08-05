<div class="min-h-screen">

    {{-- Header --}}
    <div class="relative bg-[#07101F] border-b border-white/5 py-16 overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center space-y-3">
            <span class="text-xs font-bold text-rose-500 uppercase tracking-[0.2em]">Got Questions?</span>
            <h1 class="text-4xl font-black text-white tracking-tight">Frequently Asked <span class="gradient-text-red">Questions</span></h1>
            <p class="text-slate-400">Find quick answers about courses, pricing, certificates, and enterprise team plans.</p>

            {{-- Search --}}
            <div class="relative mt-6 max-w-md mx-auto">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search questions..."
                    class="w-full pl-11 pr-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500/40 transition-all">
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-3" x-data="{ active: 0 }">

        {{-- Loading indicator --}}
        <div wire:loading class="text-center text-xs text-slate-500 py-2">Searching...</div>

        @forelse ($faqs as $i => $faq)
            <div class="glass-card rounded-2xl overflow-hidden border-glow">
                <button
                    @click="active = active === {{ $i }} ? null : {{ $i }}"
                    class="w-full flex items-start justify-between px-6 py-5 text-left gap-4"
                >
                    <div class="flex items-center gap-3">
                        <span class="shrink-0 px-2.5 py-0.5 rounded-full tag-pill text-[9px] font-black uppercase">{{ $faq->category }}</span>
                        <span class="text-sm font-semibold text-white">{{ $faq->question }}</span>
                    </div>
                    <span class="shrink-0 mt-0.5 w-6 h-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center transition-all duration-200"
                        :class="active === {{ $i }} ? 'bg-rose-500/15 border-rose-500/30 rotate-45' : ''">
                        <svg class="w-3 h-3" :class="active === {{ $i }} ? 'text-rose-400' : 'text-slate-500'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </span>
                </button>

                <div x-show="active === {{ $i }}" x-cloak
                    class="px-6 pb-6 text-sm text-slate-400 leading-relaxed border-t border-white/5 pt-4">
                    {{ $faq->answer }}
                </div>
            </div>
        @empty
            <div class="glass-card rounded-3xl p-16 text-center space-y-3">
                <svg class="w-10 h-10 mx-auto text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-slate-500 font-medium">No questions matched your search.</p>
                <button wire:click="$set('search', '')" class="text-sm text-rose-400 hover:text-rose-300 font-bold">Clear search →</button>
            </div>
        @endforelse

        {{-- Still have questions CTA --}}
        <div class="pt-10 text-center space-y-4">
            <p class="text-slate-500 text-sm">Still have questions?</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 btn-glow px-6 py-3 rounded-xl text-white font-bold text-sm">
                Contact Our Support Team →
            </a>
        </div>
    </div>
</div>
