<div class="min-h-screen" style="background-color: #321847;">

    {{-- Header --}}
    <div class="relative style-hero py-16 overflow-hidden" style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <span class="text-xs font-bold text-[#f15153] uppercase tracking-[0.2em]">Expert Faculty</span>
            <h1 class="text-4xl font-black text-white tracking-tight mt-2 mb-3">Top <span class="text-[#f15153]">Instructors</span></h1>
            <p class="text-purple-300 max-w-xl">Learn directly from senior software architects, principal engineers, and domain specialists with production expertise.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($instructors as $inst)
                <a href="{{ route('instructors.show', $inst->id) }}" style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 24px;" class="group p-8 text-center space-y-5 hover:border-[#f15153] transition-all">
                    <div class="relative mx-auto w-20 h-20">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-[#f15153] to-rose-400 flex items-center justify-center text-white font-black text-3xl shadow-lg shadow-[#f15153]/20 transition-shadow">
                            {{ strtoupper(substr($inst->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-[#251237] flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-base font-black text-white group-hover:text-[#f15153] transition-colors">{{ $inst->name }}</h3>
                        <p class="text-xs text-[#f15153] font-semibold uppercase tracking-wider mt-1">{{ ucfirst($inst->role) }} Architect</p>
                    </div>

                    <p class="text-xs leading-relaxed" style="color: #a997be;">
                        Production engineering specialist. Enterprise PHP 8.3, Laravel 12, Livewire 3, and system design expert.
                    </p>

                    <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);" class="w-full py-2.5 rounded-xl group-hover:bg-[#f15153] group-hover:border-[#f15153] text-purple-200 group-hover:text-white text-xs font-semibold text-center transition-all">
                        View Profile →
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-purple-300 py-20">No instructors listed.</div>
            @endforelse
        </div>
    </div>
</div>
