@if ($activeCourse)
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl text-white shadow-xl relative">
        <div class="flex items-center justify-between gap-4 mb-4">
            <div class="flex items-center gap-2">
                @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span class="text-xs font-black text-emerald-400 uppercase tracking-wider">Course Completed</span>
                @else
                    <span class="w-2.5 h-2.5 rounded-full bg-[#f15153] animate-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">Continue Learning</span>
                @endif
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">{{ $activeCourse['category'] }}</span>
        </div>

        <h3 class="text-xl font-black text-white leading-tight">
            {{ $activeCourse['title'] }}
        </h3>

        <div class="mt-3 space-y-1">
            @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                <div class="text-xs font-bold text-emerald-400">Verified Certificate Issued</div>
                <div class="text-xs" style="color: #d4c5e2;">Congratulations! You have completed all course curriculum modules.</div>
            @else
                <div class="text-xs font-bold" style="color: #f15153;">{{ $activeCourse['current_module'] }}</div>
                <div class="text-xs" style="color: #a997be;">{{ $activeCourse['current_lesson'] }}</div>
            @endif
        </div>

        <!-- Progress Bar -->
        <div class="mt-5 space-y-1.5">
            <div class="flex justify-between text-xs font-semibold">
                <span style="color: #a997be;">Progress</span>
                <span class="text-white font-bold">{{ $activeCourse['progress_percent'] }}%</span>
            </div>
            <div style="width: 100%; background-color: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); border-radius: 9999px; height: 16px; padding: 2px; box-sizing: border-box; overflow: hidden;">
                <div style="width: {{ max(2, (int)($activeCourse['progress_percent'] ?? 0)) }}%; background-color: #10b981 !important; height: 100%; border-radius: 9999px; min-height: 10px; box-shadow: 0 0 10px #10b981;"></div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between pt-4 border-t border-purple-800/40">
            <div class="text-xs flex items-center gap-1.5" style="color: #a997be;">
                @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"/></svg>
                    <span>100% Curriculum Completed</span>
                @else
                    <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Approx. {{ $activeCourse['remaining_mins'] }} mins remaining</span>
                @endif
            </div>

            @if (!empty($activeCourse['is_completed']) || $activeCourse['progress_percent'] >= 100)
                <div class="flex items-center gap-2">
                    @if (!empty($activeCourse['certificate_id']))
                        <a href="{{ route('student.certificates.view', $activeCourse['certificate_id']) }}" class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition-all text-decoration-none flex items-center gap-1.5">
                            <span>View</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('student.certificates.download', $activeCourse['certificate_id']) }}" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-md transition-all text-decoration-none flex items-center gap-1.5">
                            <span>Download PDF</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    @else
                        <a href="#recent-certificates" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="px-5 py-2.5 rounded-xl text-white font-black text-xs shadow-md transition-all text-decoration-none">
                            View Certificates
                        </a>
                    @endif
                </div>
            @else
                <a href="{{ route('student.courses.player', ['courseId' => $activeCourse['course_id'], 'lesson' => $activeCourse['active_lesson_id'] ?? null]) }}" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="px-5 py-2.5 rounded-xl text-white font-black text-xs transition-all flex items-center gap-2 text-decoration-none">
                    <span>Resume Lesson</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
@else
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-8 rounded-3xl text-white text-center space-y-4 shadow-xl">
        <div class="w-16 h-16 rounded-2xl bg-white/10 text-rose-400 text-2xl font-bold flex items-center justify-center mx-auto shadow-xs">
            <svg class="w-8 h-8 text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
        </div>
        <div>
            <h3 class="text-base font-black text-white">No Active Course Enrolled</h3>
            <p class="text-xs max-w-sm mx-auto mt-1" style="color: #a997be;">You are not currently enrolled in any active course. Browse our course catalog to start learning.</p>
        </div>
        <a href="{{ route('courses.index') }}" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="inline-block px-5 py-2.5 rounded-xl text-white font-black text-xs transition-all text-decoration-none">
            Browse Course Catalog
        </a>
    </div>
@endif
