<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-4.42-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>
                <span>AI Recommended Courses</span>
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
