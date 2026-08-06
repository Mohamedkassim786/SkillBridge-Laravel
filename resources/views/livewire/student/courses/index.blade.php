<div class="space-y-8 text-white">
    <!-- Header Title & Filter Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">My Enrolled Courses</h1>
            <p class="text-xs text-slate-300 mt-1">Access your active learning paths, track progress, and continue lessons.</p>
        </div>

        <!-- Filter Status Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
            <button wire:click="$set('status', 'all')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $status === 'all' ? 'bg-[#D62828] text-white shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                All Courses
            </button>
            <button wire:click="$set('status', 'in_progress')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $status === 'in_progress' ? 'bg-[#D62828] text-white shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                In Progress
            </button>
            <button wire:click="$set('status', 'completed')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $status === 'completed' ? 'bg-[#D62828] text-white shadow-md font-black' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                Completed
            </button>
        </div>
    </div>

    <!-- Search Controls & Multi-Filter Toolbar -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search Bar -->
            <div class="lg:col-span-2 relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search my courses by title..."
                       style="background: #112240; border: 1px solid #1e3a5f; color: white;"
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl text-xs font-semibold text-white placeholder-slate-400 focus:outline-none focus:border-rose-500">
                <div class="absolute left-3 top-3 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <select wire:model.live="category_id" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                    <option value="" class="text-slate-900">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" class="text-slate-900">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Trainer Filter -->
            <div>
                <select wire:model.live="trainer_id" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                    <option value="" class="text-slate-900">All Instructors</option>
                    @foreach ($trainers as $tr)
                        <option value="{{ $tr->id }}" class="text-slate-900">{{ $tr->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Difficulty Filter -->
            <div>
                <select wire:model.live="difficulty" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                    <option value="" class="text-slate-900">All Difficulties</option>
                    <option value="beginner" class="text-slate-900">Beginner</option>
                    <option value="intermediate" class="text-slate-900">Intermediate</option>
                    <option value="advanced" class="text-slate-900">Advanced</option>
                </select>
            </div>
        </div>

        <!-- Sorting & Clear Filters Row -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-slate-800">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-400">Sort by:</span>
                <select wire:model.live="sort" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-1.5 rounded-lg text-xs font-bold focus:outline-none">
                    <option value="recently_accessed" class="text-slate-900">Recently Accessed</option>
                    <option value="highest_progress" class="text-slate-900">Highest Progress</option>
                    <option value="newest" class="text-slate-900">Newest Enrolled</option>
                </select>
            </div>

            @if ($search || $category_id || $trainer_id || $difficulty || $status !== 'all')
                <button wire:click="clearFilters" class="text-xs font-bold text-[#D62828] hover:underline flex items-center gap-1">
                    <span>✕ Clear All Filters</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Livewire Loading State Indicator -->
    <div wire:loading.flex class="justify-center items-center py-6">
        <div class="flex items-center gap-3 text-xs font-bold text-white">
            <svg class="animate-spin h-5 w-5 text-[#D62828]" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Filtering course catalog...</span>
        </div>
    </div>

    <!-- Course Cards Responsive Grid -->
    <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($courses as $course)
            @php
                $enrollment = $course->enrollments->first();
                $modules = $course->currentVersion?->modules ?? collect([]);
                $allLessons = $modules->pluck('lessons')->flatten();
                $totalLessons = $allLessons->count();
                $completedLessonsCount = (int) round(($totalLessons * ($enrollment?->progress_percent ?? 0)) / 100);
                $totalSeconds = $allLessons->sum('duration');
                $durationHours = round($totalSeconds / 3600, 1);
                $firstLesson = $allLessons->first();
            @endphp

            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-xl hover:border-rose-500/50 transition-all duration-300 overflow-hidden flex flex-col justify-between group text-white">
                <div>
                    <!-- Thumbnail Header -->
                    <div class="relative h-48 bg-slate-900 overflow-hidden">
                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                        
                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-full bg-[#0B1F3A]/90 text-white text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md">
                                {{ $course->category?->name ?? 'Software Architecture' }}
                            </span>
                        </div>

                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-1 rounded-full bg-slate-900/80 text-amber-300 text-[10px] font-extrabold uppercase backdrop-blur-md">
                                {{ ucfirst($course->currentVersion?->level ?? 'advanced') }}
                            </span>
                        </div>
                    </div>

                    <!-- Course Content Details -->
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-base font-extrabold text-white leading-snug line-clamp-2">
                                {{ $course->title }}
                            </h3>
                            <div class="text-xs text-slate-300 font-medium mt-1 flex items-center gap-2">
                                <span>Instructor: <strong class="text-white">{{ $course->trainer?->name ?? 'Dr. Marcus Vance' }}</strong></span>
                                <span>•</span>
                                <span>⏱️ {{ $durationHours > 0 ? $durationHours.' hrs' : '2.5 hrs' }}</span>
                            </div>
                        </div>

                        <!-- Lessons Counter & Current Lesson -->
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3 rounded-2xl text-xs space-y-1 text-white">
                            <div class="flex justify-between font-bold text-slate-300">
                                <span>Lessons Completed</span>
                                <span class="text-white font-black">{{ $completedLessonsCount }} / {{ max(1, $totalLessons) }}</span>
                            </div>
                            <div class="text-[11px] text-slate-400 truncate">
                                Current: <span class="font-semibold text-slate-200">{{ $firstLesson?->title ?? 'Module 1: Introduction' }}</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs font-bold">
                                <span class="text-slate-400">Course Progress</span>
                                <span class="text-[#D62828]">{{ $enrollment?->progress_percent ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-slate-900 h-2.5 rounded-full overflow-hidden border border-slate-800">
                                <div class="bg-[#D62828] h-full rounded-full transition-all duration-500"
                                     style="width: {{ $enrollment?->progress_percent ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Action CTA Button -->
                <div class="p-6 pt-0">
                    <a href="{{ route('student.courses.player', [$course->id, 'lesson' => $firstLesson?->id]) }}" style="background-color: #D62828;"
                       class="w-full inline-flex justify-center items-center gap-2 py-3.5 rounded-xl text-white font-black text-xs shadow-md transition-all text-decoration-none">
                        <span>Continue Learning</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="col-span-full p-12 text-center rounded-3xl shadow-xl space-y-4 text-white">
                <div class="w-16 h-16 rounded-full bg-slate-800 text-2xl flex items-center justify-center mx-auto">📚</div>
                <h3 class="text-lg font-extrabold text-white">No Enrolled Courses Found</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                    @if ($search || $category_id || $trainer_id || $difficulty || $status !== 'all')
                        No courses match your active search or filter criteria. Try clearing filters.
                    @else
                        You have not enrolled in any courses yet. Browse our course catalog to get started.
                    @endif
                </p>

                @if ($search || $category_id || $trainer_id || $difficulty || $status !== 'all')
                    <button wire:click="clearFilters" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-black text-xs shadow-md">
                        Clear All Filters
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination Controls -->
    @if ($courses->hasPages())
        <div class="pt-4">
            {{ $courses->links() }}
        </div>
    @endif
</div>
