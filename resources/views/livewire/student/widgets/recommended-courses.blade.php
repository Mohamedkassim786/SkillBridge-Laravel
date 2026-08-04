<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
                <span>🎯 AI Recommended Courses</span>
            </h3>
            <p class="text-xs text-slate-500">Based on your learning history and target skill gaps</p>
        </div>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">Explore Catalog</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($courses as $c)
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="inline-block px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-extrabold uppercase mb-2">
                        {{ $c->category ?? 'Software' }}
                    </div>
                    <h4 class="text-sm font-extrabold text-[#0B1F3A] leading-snug">{{ $c->title }}</h4>
                    <div class="mt-2 flex items-center gap-3 text-xs text-slate-500">
                        <span>⭐ {{ $c->rating ?? 4.9 }}</span>
                        <span>👥 {{ $c->students_count ?? 1200 }} students</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-base font-extrabold text-[#0B1F3A]">{{ $c->price ?? '$49' }}</span>
                    <a href="#" class="px-3.5 py-1.5 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-bold text-xs shadow-sm transition-all">
                        Enroll Now
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
