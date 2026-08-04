<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative">
    <div class="flex items-center justify-between gap-4 mb-4">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#D62828] animate-pulse"></span>
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Continue Learning</span>
        </div>
        <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">{{ $activeCourse['category'] ?? 'Software Development' }}</span>
    </div>

    <h3 class="text-xl font-extrabold text-[#0B1F3A] leading-tight">
        {{ $activeCourse['title'] ?? 'Full-Stack Software Architecture with Laravel 12' }}
    </h3>

    <div class="mt-3 space-y-1">
        <div class="text-xs font-bold text-[#D62828]">{{ $activeCourse['current_module'] ?? 'Module 3: Advanced Architecture' }}</div>
        <div class="text-xs text-slate-600">{{ $activeCourse['current_lesson'] ?? 'Lesson 4: Enterprise Services & Repositories' }}</div>
    </div>

    <!-- Progress Bar -->
    <div class="mt-5 space-y-1.5">
        <div class="flex justify-between text-xs font-semibold">
            <span class="text-slate-700">Progress</span>
            <span class="text-[#0B1F3A] font-bold">{{ $activeCourse['progress_percent'] ?? 65 }}%</span>
        </div>
        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
            <div class="bg-[#D62828] h-full rounded-full transition-all duration-500" style="width: {{ $activeCourse['progress_percent'] ?? 65 }}%"></div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-between pt-4 border-t border-slate-100">
        <div class="text-xs text-slate-500">
            ⏳ Approx. {{ $activeCourse['remaining_mins'] ?? 45 }} mins remaining
        </div>
        <a href="#" class="px-5 py-2.5 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
            <span>Resume Lesson</span>
            <svg class="w-4 h-4 text-[#D62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </div>
</div>
