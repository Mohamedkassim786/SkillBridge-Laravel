<div class="min-h-screen">

    {{-- Instructor Profile Header --}}
    <div class="relative bg-[#07101F] border-b border-white/5 py-20 overflow-hidden">
        <div class="absolute inset-0 dot-grid opacity-20 pointer-events-none"></div>
        <div class="absolute right-0 top-0 w-80 h-80 bg-rose-500/5 blur-3xl rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative flex flex-col md:flex-row items-center md:items-start gap-10">
            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-32 h-32 rounded-3xl bg-gradient-to-tr from-rose-500 to-orange-400 flex items-center justify-center text-white font-black text-5xl shadow-2xl shadow-rose-500/25">
                    {{ strtoupper(substr($instructor->name, 0, 1)) }}
                </div>
                <div class="absolute -bottom-2 -right-2 px-3 py-1 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase">Active</div>
            </div>

            {{-- Info --}}
            <div class="space-y-4 text-center md:text-left">
                <div>
                    <h1 class="text-4xl font-black text-white">{{ $instructor->name }}</h1>
                    <p class="text-rose-400 font-bold text-sm mt-1 uppercase tracking-wider">{{ ucfirst($instructor->role) }} Architect & Senior Mentor</p>
                </div>
                <p class="text-slate-400 max-w-xl leading-relaxed">
                    Senior engineer specializing in production enterprise systems, PHP 8.3 architecture, Livewire 3 reactive UIs, and domain-driven microservices design.
                </p>
                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 justify-center md:justify-start">
                    <span>📚 {{ $courses->count() }} Courses</span>
                    <span>🎓 1,000+ Students</span>
                    <span>⭐ 4.9 Rating</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Courses --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
        <h2 class="text-2xl font-black text-white">Courses by {{ $instructor->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($courses as $course)
                <a href="{{ route('courses.show', $course->id) }}" class="group glass-card border-glow rounded-3xl overflow-hidden hover-lift flex flex-col">
                    <div class="h-1.5 bg-gradient-to-r from-rose-600 to-orange-400"></div>
                    <div class="p-6 flex flex-col gap-4 flex-1">
                        <h3 class="text-base font-bold text-white group-hover:text-rose-400 transition-colors leading-snug">{{ $course->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 flex-1">{{ $course->currentVersion?->description }}</p>
                        <div class="flex items-center justify-between pt-3 border-t border-white/5">
                            <span class="text-xs text-slate-500 capitalize">{{ $course->currentVersion?->level ?? 'intermediate' }} level</span>
                            <span class="font-black text-white">${{ number_format($course->currentVersion?->price ?? 99) }}</span>
                        </div>
                    </div>
                    <div class="px-6 pb-5">
                        <div class="w-full py-2.5 rounded-xl bg-white/5 border border-white/10 group-hover:bg-rose-500/10 group-hover:border-rose-500/30 text-white text-xs font-semibold text-center transition-all">View Course →</div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-slate-600 py-16">No active courses listed for this instructor.</div>
            @endforelse
        </div>
    </div>
</div>
