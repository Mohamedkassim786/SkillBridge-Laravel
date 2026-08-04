<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>📈 Career Placement Readiness</span>
        </h3>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">Career Hub</a>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <!-- ATS Score Ring -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">ATS Score</div>
            <div class="mt-1 text-3xl font-black text-[#D62828]">{{ $progress['ats_score'] ?? 88 }}/100</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-0.5">High Compatibility</div>
        </div>

        <!-- Applications Pipeline -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Applied Jobs</div>
            <div class="mt-1 text-3xl font-black text-[#0B1F3A]">{{ $progress['jobs_applied'] ?? 6 }}</div>
            <div class="text-[11px] text-blue-600 font-semibold mt-0.5">{{ $progress['interviews_scheduled'] ?? 2 }} Interviews Scheduled</div>
        </div>
    </div>

    <!-- Skill Gaps Recommendation -->
    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900">
        <div class="text-xs font-bold uppercase tracking-wider text-amber-800">Top Recommended Skill Boosts</div>
        <div class="flex flex-wrap gap-1.5 mt-2">
            @foreach ($progress['top_skill_gaps'] ?? ['Docker', 'AWS Lambda', 'GraphQL'] as $gap)
                <span class="px-2.5 py-1 rounded-md bg-white border border-amber-200 text-xs font-semibold text-amber-900">+ {{ $gap }}</span>
            @endforeach
        </div>
    </div>
</div>
