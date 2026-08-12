<div class="min-h-screen" style="background-color: #321847;">

    {{-- Instructor Profile Header --}}
    <div class="relative py-20 overflow-hidden" style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25);">
        <div class="absolute right-0 top-0 w-80 h-80 bg-[#f15153]/5 blur-3xl rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative flex flex-col md:flex-row items-center md:items-start gap-10">
            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-32 h-32 rounded-3xl bg-gradient-to-tr from-[#f15153] to-rose-400 flex items-center justify-center text-white font-black text-5xl shadow-2xl shadow-[#f15153]/25">
                    {{ strtoupper(substr($instructor->name, 0, 1)) }}
                </div>
                <div class="absolute -bottom-2 -right-2 px-3 py-1 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase">Active</div>
            </div>

            {{-- Info --}}
            <div class="space-y-4 text-center md:text-left">
                <div>
                    <h1 class="text-4xl font-black text-white">{{ $instructor->name }}</h1>
                    <p class="text-[#f15153] font-bold text-sm mt-1 uppercase tracking-wider">{{ ucfirst($instructor->role) }} Architect & Senior Mentor</p>
                </div>
                <p class="text-purple-200 max-w-xl leading-relaxed">
                    Senior engineer specializing in production enterprise systems, PHP 8.3 architecture, Livewire 3 reactive UIs, and domain-driven microservices design.
                </p>
                <div class="flex flex-wrap items-center gap-4 text-xs text-purple-300 justify-center md:justify-start">
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
                <a href="{{ route('courses.show', $course->id) }}" style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 24px;" class="group overflow-hidden hover:border-[#f15153] transition-all flex flex-col">
                    <div class="h-1.5 bg-[#f15153]"></div>
                    <div class="p-6 flex flex-col gap-4 flex-1">
                        <h3 class="text-base font-bold text-white group-hover:text-[#f15153] transition-colors leading-snug">{{ $course->title }}</h3>
                        <p class="text-xs text-purple-300 line-clamp-2 flex-1">{{ $course->currentVersion?->description }}</p>
                        <div class="flex items-center justify-between pt-3 border-t border-purple-800/40">
                            <span class="text-xs text-purple-300 capitalize">{{ $course->currentVersion?->level ?? 'intermediate' }} level</span>
                            <span class="font-black text-white">₹{{ number_format($course->currentVersion?->price ?? 99) }}</span>
                        </div>
                    </div>
                    <div class="px-6 pb-5">
                        <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);" class="w-full py-2.5 rounded-xl group-hover:bg-[#f15153] text-white text-xs font-semibold text-center transition-all">View Course →</div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-purple-300 py-16">No active courses listed for this instructor.</div>
            @endforelse
        </div>
    </div>
</div>
