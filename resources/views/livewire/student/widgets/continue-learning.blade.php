@if ($activeCourse)
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative">
        <div class="flex items-center justify-between gap-4 mb-4">
            <div class="flex items-center gap-2">
                @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-xs font-extrabold text-emerald-700 uppercase tracking-wider">🎉 Course Completed</span>
                @else
                    <span class="w-2.5 h-2.5 rounded-full bg-[#D62828] animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Continue Learning</span>
                @endif
            </div>
            <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">{{ $activeCourse['category'] }}</span>
        </div>

        <h3 class="text-xl font-extrabold text-[#0B1F3A] leading-tight">
            {{ $activeCourse['title'] }}
        </h3>

        <div class="mt-3 space-y-1">
            @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                <div class="text-xs font-bold text-emerald-600">Verified Certificate Issued 🎉</div>
                <div class="text-xs text-slate-600">Congratulations! You have completed all course curriculum modules.</div>
            @else
                <div class="text-xs font-bold text-[#D62828]">{{ $activeCourse['current_module'] }}</div>
                <div class="text-xs text-slate-600">{{ $activeCourse['current_lesson'] }}</div>
            @endif
        </div>

        <!-- Progress Bar -->
        <div class="mt-5 space-y-1.5">
            <div class="flex justify-between text-xs font-semibold">
                <span class="text-slate-700">Progress</span>
                <span class="text-[#0B1F3A] font-bold">{{ $activeCourse['progress_percent'] }}%</span>
            </div>
            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $activeCourse['progress_percent'] }}%"></div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between pt-4 border-t border-slate-100">
            <div class="text-xs text-slate-500">
                @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                    🏆 100% Curriculum Completed
                @else
                    ⏳ Approx. {{ $activeCourse['remaining_mins'] }} mins remaining
                @endif
            </div>

            @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                <div class="flex items-center gap-2">
                    @if (!empty($activeCourse['certificate_id']))
                        <a href="{{ route('student.certificates.view', $activeCourse['certificate_id']) }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition-all">
                            View 👁️
                        </a>
                        <a href="{{ route('student.certificates.download', $activeCourse['certificate_id']) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md transition-all flex items-center gap-1.5">
                            <span>Download PDF ⬇️</span>
                        </a>
                    @else
                        <a href="#recent-certificates" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md transition-all">
                            View Certificates
                        </a>
                    @endif
                </div>
            @else
                <a href="{{ route('student.courses.player', ['courseId' => $activeCourse['course_id'], 'lesson' => $activeCourse['active_lesson_id'] ?? null]) }}" class="px-5 py-2.5 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                    <span>Resume Lesson</span>
                    <svg class="w-4 h-4 text-[#D62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
@else
    <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm text-center space-y-4">
        <div class="w-16 h-16 rounded-2xl bg-slate-100 text-[#0B1F3A] text-2xl font-bold flex items-center justify-center mx-auto shadow-xs">
            🎓
        </div>
        <div>
            <h3 class="text-base font-extrabold text-[#0B1F3A]">No Active Course Enrolled</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">You are not currently enrolled in any active course. Browse our course catalog to start learning.</p>
        </div>
        <a href="{{ route('student.courses.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#D62828] hover:bg-red-700 text-white font-extrabold text-xs shadow-md transition-all">
            Browse Course Catalog
        </a>
    </div>
@endif
