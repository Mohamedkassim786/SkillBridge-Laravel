<div class="min-h-screen" style="background-color: #321847;">

    {{-- Header --}}
    <div class="relative py-16 overflow-hidden" style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25);">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center space-y-3">
            <span class="text-xs font-bold text-[#f15153] uppercase tracking-[0.2em]">Got Questions?</span>
            <h1 class="text-4xl font-black text-white tracking-tight">Frequently Asked <span class="text-[#f15153]">Questions</span></h1>
            <p class="text-purple-300">Find quick answers about courses, pricing, certificates, and enterprise team plans.</p>

            {{-- Search --}}
            <div class="relative mt-6 max-w-md mx-auto">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search questions..."
                    style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.12);" class="w-full pl-11 pr-4 py-3 rounded-2xl text-sm text-white placeholder-purple-400 focus:outline-none focus:border-[#f15153] transition-all">
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-3" x-data="{ active: 0 }">

        {{-- Loading indicator --}}
        <div wire:loading class="text-center text-xs text-purple-300 py-2">Searching...</div>

        @forelse ($faqs as $i => $faq)
            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px;" class="overflow-hidden">
                <button
                    @click="active = active === {{ $i }} ? null : {{ $i }}"
                    class="w-full flex items-start justify-between px-6 py-5 text-left gap-4"
                >
                    <div class="flex items-center gap-3">
                        <span style="background: rgba(241,81,83,0.15); color: #f15153;" class="shrink-0 px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase">{{ $faq->category }}</span>
                        <span class="text-sm font-semibold text-white">{{ $faq->question }}</span>
                    </div>
                    <span class="shrink-0 mt-0.5 w-6 h-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center transition-all duration-200"
                        :class="active === {{ $i }} ? 'bg-[#f15153]/15 border-[#f15153]/30 rotate-45' : ''">
                        <svg class="w-3 h-3" :class="active === {{ $i }} ? 'text-[#f15153]' : 'text-purple-400'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </span>
                </button>

                <div x-show="active === {{ $i }}" x-cloak
                    class="px-6 pb-6 text-sm leading-relaxed border-t border-purple-800/40 pt-4" style="color: #d4c5e2;">
                    {{ $faq->answer }}
                </div>
            </div>
        @empty
            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 24px;" class="p-16 text-center space-y-3">
                <svg class="w-10 h-10 mx-auto text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-medium" style="color: #a997be;">No questions matched your search.</p>
                <button wire:click="$set('search', '')" class="text-sm text-[#f15153] hover:underline font-bold">Clear search →</button>
            </div>
        @endforelse

        {{-- Still have questions CTA --}}
        <div class="pt-10 text-center space-y-4">
            <p class="text-sm" style="color: #a997be;">Still have questions?</p>
            <a href="{{ route('contact') }}" style="background: #f15153; color: white;" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:opacity-90 transition-all">
                Contact Our Support Team →
            </a>
        </div>
    </div>
</div>
