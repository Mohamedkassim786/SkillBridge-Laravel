<div class="space-y-8 text-white">
    <!-- Header Hero Banner with Course Progress Widget -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-8 rounded-3xl text-white shadow-xl relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#D62828]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6 max-w-4xl">
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-slate-200 border border-white/10 backdrop-blur-md">
                    {{ $course->category?->name ?? 'Software Architecture' }}
                </span>
                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-black border border-emerald-500/30">
                    Active Enrollment
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-white leading-tight">{{ $course->title }}</h1>
            <p class="text-sm text-slate-300 leading-relaxed">{{ $course->currentVersion?->description ?? 'Enterprise software course focusing on domain driven design, repository pattern, service layers, and Livewire 3.' }}</p>

            @php
                $enrollment = $course->enrollments->first();
                $modules = $course->currentVersion?->modules ?? collect([]);
                $allLessons = $modules->pluck('lessons')->flatten();
                $totalLessons = $allLessons->count();
                $completedLessonsCount = 0;
                $currentLesson = null;
                $previousCompleted = true;

                foreach ($allLessons as $index => $les) {
                    $prog = $les->progress->first();
                    if ($prog && $prog->is_completed) {
                        $completedLessonsCount++;
                    } elseif (! $currentLesson) {
                        $currentLesson = $les;
                    }
                }
                if (! $currentLesson) {
                    $currentLesson = $allLessons->first();
                }

                $progressPercent = $enrollment?->progress_percent ?? 0;
                $totalSeconds = $allLessons->sum('duration');
                $durationHours = round($totalSeconds / 3600, 1);
            @endphp

            <!-- Course Progress Bar & Metrics Widget -->
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl backdrop-blur-md space-y-3 text-white">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs font-bold">
                    <div class="flex items-center gap-3">
                        <span class="text-slate-300">Overall Progress:</span>
                        <span class="text-[#D62828] text-base font-black">{{ $progressPercent }}%</span>
                        <span class="text-slate-400">• {{ $completedLessonsCount }} / {{ max(1, $totalLessons) }} Lessons Completed</span>
                    </div>

                    @if ($currentLesson)
                        <div class="text-slate-300">
                            Current Lesson: <span class="text-white font-extrabold">{{ $currentLesson->title }}</span>
                        </div>
                    @endif
                </div>

                <div class="w-full bg-slate-900 h-3 rounded-full overflow-hidden border border-slate-800">
                    <div class="bg-[#D62828] h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                </div>

                <!-- Certificate Eligibility Indicator -->
                <div class="flex items-center justify-between text-[11px] pt-1">
                    <span class="text-slate-300">
                        📜 Certificate Status: 
                        @if ($progressPercent >= 100)
                            <strong class="text-emerald-400 font-bold">Eligible & Issued 🎉</strong>
                        @else
                            <strong class="text-amber-300 font-semibold">Requires 100% Completion (Currently {{ $progressPercent }}%)</strong>
                        @endif
                    </span>
                    <span class="text-slate-400">Total Duration: {{ $durationHours > 0 ? $durationHours.' hrs' : '2.5 hrs' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Toolbar -->
    <div class="border-b border-slate-800 flex items-center gap-4 overflow-x-auto pb-1 text-white">
        <button wire:click="$set('activeTab', 'overview')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'overview' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Overview
        </button>
        <button wire:click="$set('activeTab', 'curriculum')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'curriculum' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Curriculum Syllabus ({{ $totalLessons }})
        </button>
        <button wire:click="$set('activeTab', 'outcomes')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'outcomes' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Learning Outcomes
        </button>
        <button wire:click="$set('activeTab', 'requirements')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'requirements' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Requirements
        </button>
        <button wire:click="$set('activeTab', 'resources')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'resources' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Resources ({{ count($resources) }})
        </button>
        <button wire:click="$set('activeTab', 'instructor')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'instructor' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Instructor Profile
        </button>
        <button wire:click="$set('activeTab', 'reviews')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'reviews' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Reviews ({{ count($reviews) }})
        </button>
        <button wire:click="$set('activeTab', 'faqs')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'faqs' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            FAQs
        </button>
        <button wire:click="$set('activeTab', 'certificate')"
                class="pb-3 px-2 text-xs font-extrabold transition-all border-b-2 whitespace-nowrap {{ $activeTab === 'certificate' ? 'border-[#D62828] text-white font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            Certificate Eligibility
        </button>
    </div>

    <!-- Tab 1: Overview -->
    @if ($activeTab === 'overview')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
                    <h3 class="text-lg font-black text-white">Course Overview & Description</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        {{ $course->currentVersion?->description ?? 'This course provides hands-on mastery over scalable software architecture, clean code principles, domain repositories, and Livewire 3 reactive interfaces.' }}
                    </p>
                </div>

                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
                    <h3 class="text-lg font-black text-white">Key Highlights</h3>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white">
                            <div class="font-bold text-white">Level</div>
                            <div class="text-slate-300 capitalize mt-0.5">{{ $course->currentVersion?->level ?? 'advanced' }}</div>
                        </div>
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white">
                            <div class="font-bold text-white">Total Lessons</div>
                            <div class="text-slate-300 mt-0.5">{{ $totalLessons }} Video Lessons</div>
                        </div>
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white">
                            <div class="font-bold text-white">Watch Time</div>
                            <div class="text-slate-300 mt-0.5">{{ $durationHours }} Hours</div>
                        </div>
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white">
                            <div class="font-bold text-white">Access Type</div>
                            <div class="text-slate-300 mt-0.5">Lifetime Student Access</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
                    <h4 class="text-sm font-black text-white">Instructor Info</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-[#D62828] text-white font-black text-sm flex items-center justify-center shadow-md">
                            {{ strtoupper(substr($course->trainer?->first_name ?? 'M', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $course->trainer?->name ?? 'Dr. Marcus Vance' }}</div>
                            <div class="text-xs text-slate-400">Principal Software Architect</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Tab 2: Curriculum Syllabus -->
    @if ($activeTab === 'curriculum')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-6 text-white">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-black text-white">Curriculum Syllabus & Lesson Unlocking</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Lessons unlock sequentially upon achieving at least 90% watch progress on previous lessons.</p>
                </div>
            </div>

            @php
                $unlocked = true;
            @endphp

            <div class="space-y-4">
                @forelse ($modules as $module)
                    <div x-data="{ open: true }" style="background: #112240; border: 1px solid #1e3a5f;" class="rounded-2xl overflow-hidden text-white shadow-md">
                        <button @click="open = !open" class="w-full p-4 bg-slate-900/60 flex items-center justify-between font-black text-sm text-white hover:bg-slate-800 transition-colors">
                            <div class="flex items-center gap-3">
                                <span>{{ $module->title }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 text-[10px] font-bold border border-slate-700">
                                    {{ $module->lessons->count() }} Lessons
                                </span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" class="p-4 divide-y divide-slate-800">
                            @foreach ($module->lessons as $index => $lesson)
                                @php
                                    $prog = $lesson->progress->first();
                                    $isDone = $prog?->is_completed ?? false;
                                    $watchPct = $prog?->watch_percentage ?? 0;
                                    
                                    // Current lesson indicator
                                    $isCurrent = ($currentLesson?->id === $lesson->id);

                                    // Lock logic: first lesson is unlocked; subsequent lessons unlock if previous is completed/watch >= 90%
                                    $isUnlocked = $unlocked;
                                    if (!$isDone && $watchPct < 90) {
                                        $unlocked = false;
                                    }
                                @endphp

                                <div class="py-3.5 flex items-center justify-between text-xs {{ $isCurrent ? 'bg-rose-500/10 -mx-4 px-4 rounded-xl border border-rose-500/20' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <!-- Status Icon -->
                                        @if ($isDone)
                                            <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-300 font-bold flex items-center justify-center text-xs border border-emerald-500/30">✓</span>
                                        @elseif ($isCurrent)
                                            <span class="w-6 h-6 rounded-full bg-[#D62828] text-white font-bold flex items-center justify-center text-xs animate-pulse">▶</span>
                                        @elseif ($isUnlocked)
                                            <span class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-300 font-bold flex items-center justify-center text-[10px] border border-blue-500/30">{{ $index + 1 }}</span>
                                        @else
                                            <span class="w-6 h-6 rounded-full bg-slate-800 text-slate-500 font-bold flex items-center justify-center text-xs border border-slate-700">🔒</span>
                                        @endif

                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-white">{{ $lesson->title }}</span>
                                                @if ($isCurrent)
                                                    <span class="px-2 py-0.5 rounded bg-rose-600 text-white text-[9px] font-black uppercase">Current Lesson</span>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">
                                                Duration: {{ (int) round($lesson->duration / 60) }} mins
                                                @if ($watchPct > 0)
                                                    • Watch Progress: <strong class="text-slate-200">{{ $watchPct }}%</strong>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        @if ($isDone)
                                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black border border-emerald-500/30">Completed</span>
                                        @elseif ($isUnlocked)
                                            <span class="px-2.5 py-1 rounded-full bg-blue-500/20 text-blue-300 text-[10px] font-black border border-blue-500/30">Unlocked</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full bg-slate-800 text-slate-400 text-[10px] font-bold border border-slate-700">Locked 🔒</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400 bg-slate-900/60 rounded-2xl border border-slate-800">No modules uploaded yet.</div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Tab 3: Learning Outcomes -->
    @if ($activeTab === 'outcomes')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
            <h3 class="text-lg font-black text-white">Course Learning Outcomes</h3>
            <ul class="space-y-3 text-xs text-slate-300">
                <li class="flex items-start gap-2.5">
                    <span class="text-emerald-400 font-bold text-sm">✓</span>
                    <span>Design clean enterprise application layers adhering to SOLID principles and Repository Pattern.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="text-emerald-400 font-bold text-sm">✓</span>
                    <span>Construct reactive user interfaces with Livewire 3 and Alpine.js without writing custom JavaScript controllers.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="text-emerald-400 font-bold text-sm">✓</span>
                    <span>Enforce granular role-based authorization using Spatie Permissions and custom Laravel Policies.</span>
                </li>
            </ul>
        </div>
    @endif

    <!-- Tab 4: Requirements -->
    @if ($activeTab === 'requirements')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
            <h3 class="text-lg font-black text-white">Prerequisites & System Requirements</h3>
            <ul class="space-y-2 text-xs text-slate-300 list-disc list-inside">
                <li>Basic understanding of Object-Oriented PHP 8.3 & Laravel framework fundamentals.</li>
                <li>Local development environment with PHP 8.3, Composer, and MySQL/SQLite database.</li>
                <li>Code editor (VS Code or PhpStorm).</li>
            </ul>
        </div>
    @endif

    <!-- Tab 5: Downloadable Resources -->
    @if ($activeTab === 'resources')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
            <h3 class="text-lg font-black text-white">Course Download Files</h3>
            <div class="space-y-3">
                @forelse ($resources as $res)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl flex items-center justify-between text-xs text-white">
                        <div>
                            <div class="font-bold text-white">{{ $res['title'] }}</div>
                            <div class="text-slate-400 text-[11px] mt-0.5">Size: {{ $res['file_size'] }} • Version: {{ $res['version'] }}</div>
                        </div>
                        <a href="#" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-md text-decoration-none">Download File</a>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400 bg-slate-900/60 rounded-2xl border border-slate-800">No resources available for download yet.</div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Tab 6: Instructor Profile -->
    @if ($activeTab === 'instructor')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-[#D62828] text-white font-black text-xl flex items-center justify-center shadow-lg">
                    {{ strtoupper(substr($course->trainer?->first_name ?? 'D', 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-xl font-black text-white">{{ $course->trainer?->name ?? 'Dr. Marcus Vance' }}</h3>
                    <p class="text-xs text-rose-400 font-extrabold">Principal Laravel Architect & Enterprise Trainer</p>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Over 12 years of experience leading enterprise software engineering teams, designing high-throughput microservices, and authoring domain architecture frameworks in PHP 8 and Laravel.
            </p>
        </div>
    @endif

    <!-- Tab 7: Reviews -->
    @if ($activeTab === 'reviews')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-6 text-white">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-black text-white">Student Reviews & Rating Breakdown</h3>
                    <div class="text-xs font-bold text-amber-400 mt-0.5">⭐ 4.9 out of 5.0 Rating</div>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($reviews as $rev)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-2 text-xs text-white">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-white">{{ $rev->user?->name }}</span>
                            <span class="text-amber-400 font-bold">⭐ {{ $rev->rating }}.0</span>
                        </div>
                        <p class="text-slate-300">{{ $rev->review_text }}</p>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400 bg-slate-900/60 rounded-2xl border border-slate-800">No reviews posted yet. Reviews open after 100% course completion.</div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Tab 8: FAQs -->
    @if ($activeTab === 'faqs')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
            <h3 class="text-lg font-black text-white">Frequently Asked Questions</h3>
            <div class="space-y-3 text-xs">
                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-1 text-white">
                    <div class="font-bold text-white">Q: How long do I have access to this course?</div>
                    <div class="text-slate-300">A: You have full lifetime access to all course modules, updates, and downloadable resources.</div>
                </div>
                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-1 text-white">
                    <div class="font-bold text-white">Q: When will my certificate be generated?</div>
                    <div class="text-slate-300">A: Certificates are automatically unlocked as soon as your overall progress reaches 100%.</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Tab 9: Certificate Eligibility -->
    @if ($activeTab === 'certificate')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-6 text-white">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-black text-white">Verified Certificate Eligibility</h3>
                    <p class="text-xs text-slate-400">Criteria needed to generate your official SkillBridge verified certificate.</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl flex items-center justify-between text-white">
                    <div>
                        <div class="font-bold text-white">100% Video Watch Completion</div>
                        <div class="text-slate-400 text-[11px]">Current Progress: {{ $progressPercent }}%</div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $progressPercent >= 100 ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                        {{ $progressPercent >= 100 ? '✓ Complete' : 'In Progress' }}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>
