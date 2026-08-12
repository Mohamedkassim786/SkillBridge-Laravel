<div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            <span>Career Placement Readiness</span>
        </h3>
        <a href="{{ route('student.applications.index') }}" class="text-xs font-extrabold text-[#f15153] hover:underline">Career Hub</a>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <!-- ATS Score Ring -->
        <div style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);" class="p-4 rounded-2xl text-center text-white">
            <div class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">ATS Score</div>
            <div class="mt-1 text-3xl font-black text-[#f15153]">{{ $progress['ats_score'] ?? 88 }}/100</div>
            <div class="text-[11px] text-emerald-400 font-semibold mt-0.5">High Compatibility</div>
        </div>

        <!-- Applications Pipeline -->
        <div style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);" class="p-4 rounded-2xl text-center text-white">
            <div class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">Applied Jobs</div>
            <div class="mt-1 text-3xl font-black text-white">{{ $progress['jobs_applied'] ?? 6 }}</div>
            <div class="text-[11px] text-purple-300 font-semibold mt-0.5">{{ $progress['interviews_scheduled'] ?? 2 }} Interviews Scheduled</div>
        </div>
    </div>

    <!-- Skill Gaps Recommendation -->
    <div style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);" class="p-4 rounded-2xl text-white">
        <div class="text-xs font-black uppercase tracking-wider text-amber-400">Top Recommended Skill Boosts</div>
        <div class="flex flex-wrap gap-1.5 mt-2">
            @foreach ($progress['top_skill_gaps'] ?? ['Docker', 'AWS Lambda', 'GraphQL'] as $gap)
                <span style="background-color: rgba(241,81,83,0.15); border: 1px solid rgba(241,81,83,0.3);" class="px-2.5 py-1 rounded-md text-xs font-bold text-white">+ {{ $gap }}</span>
            @endforeach
        </div>
    </div>
</div>
