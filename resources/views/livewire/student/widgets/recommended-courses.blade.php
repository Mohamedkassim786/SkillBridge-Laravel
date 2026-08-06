<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-white flex items-center gap-2">
                <span>🎯 AI Recommended Courses</span>
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">Based on your learning history and target skill gaps</p>
        </div>
        <a href="{{ route('courses.index') }}" class="text-xs font-extrabold text-[#D62828] hover:underline">Explore Catalog</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse ($courses as $c)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl flex flex-col justify-between text-white">
                <div>
                    <div class="inline-block px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30 text-[10px] font-black uppercase mb-2">
                        {{ $c->category?->name ?? 'Software Development' }}
                    </div>
                    <h4 class="text-sm font-extrabold text-white leading-snug">{{ $c->title }}</h4>
                    <div class="mt-2 flex items-center gap-3 text-xs text-slate-400">
                        <span>Level: <strong class="capitalize text-slate-200">{{ $c->currentVersion?->level ?? 'Intermediate' }}</strong></span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between">
                    <span class="text-base font-black text-emerald-400">₹{{ number_format($c->currentVersion?->price ?? 0, 2) }}</span>
                    <a href="{{ route('student.courses.show', $c->id) }}" style="background-color: #D62828;" class="px-3.5 py-1.5 rounded-lg text-white font-black text-xs shadow-md transition-all text-decoration-none">
                        View Course
                    </a>
                </div>
            </div>
        @empty
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="col-span-full p-8 text-center text-xs text-slate-400 rounded-2xl">
                You are enrolled in all available courses! Check back soon for new enterprise course additions.
            </div>
        @endforelse
    </div>
</div>
