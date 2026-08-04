<div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4">
    <!-- 1. Total Purchased Courses -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Purchased</div>
        <div class="mt-2 text-2xl font-black text-[#0B1F3A]">{{ $stats['purchased_courses'] ?? 0 }}</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Total Enrolled</div>
    </div>

    <!-- 2. Courses In Progress -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="text-xs font-bold text-blue-600 uppercase tracking-wider">In Progress</div>
        <div class="mt-2 text-2xl font-black text-blue-600">{{ $stats['in_progress_courses'] ?? 0 }}</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Active Learning</div>
    </div>

    <!-- 3. Completed Courses -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Completed</div>
        <div class="mt-2 text-2xl font-black text-emerald-600">{{ $stats['completed_courses'] ?? 0 }}</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Finished Modules</div>
    </div>

    <!-- 4. Certificates Earned -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="text-xs font-bold text-[#D62828] uppercase tracking-wider">Certificates</div>
        <div class="mt-2 text-2xl font-black text-[#D62828]">{{ $stats['certificates_earned'] ?? 0 }}</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Verified Badges</div>
    </div>

    <!-- 5. Learning Hours -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="text-xs font-bold text-purple-600 uppercase tracking-wider">Hours</div>
        <div class="mt-2 text-2xl font-black text-purple-600">{{ $stats['learning_hours'] ?? 0 }}h</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Watch Time</div>
    </div>

    <!-- 6. Learning Streak -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="text-xs font-bold text-amber-600 uppercase tracking-wider">Streak 🔥</div>
        <div class="mt-2 text-2xl font-black text-amber-600">{{ $stats['learning_streak'] ?? 0 }}d</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Active Days</div>
    </div>

    <!-- 7. Overall Completion % -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow col-span-2 sm:col-span-1">
        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider">Overall</div>
        <div class="mt-2 text-2xl font-black text-[#0B1F3A]">{{ $stats['overall_completion'] ?? 0 }}%</div>
        <div class="mt-1 text-[11px] font-semibold text-slate-400">Curriculum</div>
    </div>
</div>
