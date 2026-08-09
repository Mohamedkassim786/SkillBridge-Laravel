<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            <span>Career Placement Readiness</span>
        </h3>
        <a href="{{ route('student.applications.index') }}" class="text-xs font-extrabold text-[#D62828] hover:underline">Career Hub</a>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <!-- ATS Score Ring -->
        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-center text-white">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">ATS Score</div>
            <div class="mt-1 text-3xl font-black text-[#D62828]">{{ $progress['ats_score'] ?? 88 }}/100</div>
            <div class="text-[11px] text-emerald-400 font-semibold mt-0.5">High Compatibility</div>
        </div>

        <!-- Applications Pipeline -->
        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-center text-white">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Applied Jobs</div>
            <div class="mt-1 text-3xl font-black text-white">{{ $progress['jobs_applied'] ?? 6 }}</div>
            <div class="text-[11px] text-blue-400 font-semibold mt-0.5">{{ $progress['interviews_scheduled'] ?? 2 }} Interviews Scheduled</div>
        </div>
    </div>

    <!-- Skill Gaps Recommendation -->
    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white">
        <div class="text-xs font-black uppercase tracking-wider text-amber-400">Top Recommended Skill Boosts</div>
        <div class="flex flex-wrap gap-1.5 mt-2">
            @foreach ($progress['top_skill_gaps'] ?? ['Docker', 'AWS Lambda', 'GraphQL'] as $gap)
                <span style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="px-2.5 py-1 rounded-md text-xs font-bold text-slate-200">+ {{ $gap }}</span>
            @endforeach
        </div>
    </div>
</div>
