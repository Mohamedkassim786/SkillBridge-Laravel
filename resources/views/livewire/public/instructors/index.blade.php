<div class="min-h-screen">

    {{-- Header --}}
    <div class="relative bg-[#07101F] border-b border-white/5 py-16 overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <span class="text-xs font-bold text-rose-500 uppercase tracking-[0.2em]">Expert Faculty</span>
            <h1 class="text-4xl font-black text-white tracking-tight mt-2 mb-3">Top <span class="gradient-text-red">Instructors</span></h1>
            <p class="text-slate-400 max-w-xl">Learn directly from senior software architects, principal engineers, and domain specialists with production expertise.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($instructors as $inst)
                <a href="{{ route('instructors.show', $inst->id) }}" class="group glass-card border-glow rounded-3xl p-8 text-center space-y-5 hover-lift">
                    <div class="relative mx-auto w-20 h-20">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-rose-500 to-orange-400 flex items-center justify-center text-white font-black text-3xl shadow-lg shadow-rose-500/20 group-hover:shadow-rose-500/30 transition-shadow">
                            {{ strtoupper(substr($inst->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-[#060D1A] flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-base font-black text-white group-hover:text-rose-400 transition-colors">{{ $inst->name }}</h3>
                        <p class="text-xs text-rose-400 font-semibold uppercase tracking-wider mt-1">{{ ucfirst($inst->role) }} Architect</p>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed">
                        Production engineering specialist. Enterprise PHP 8.3, Laravel 12, Livewire 3, and system design expert.
                    </p>

                    <div class="w-full py-2.5 rounded-xl bg-white/5 border border-white/10 group-hover:bg-rose-500/10 group-hover:border-rose-500/30 text-slate-400 group-hover:text-white text-xs font-semibold text-center transition-all">
                        View Profile →
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-slate-600 py-20">No instructors listed.</div>
            @endforelse
        </div>
    </div>
</div>
