<div class="min-h-screen pb-24" style="background-color: #0B1F3A; color: #cbd5e1;">

    <style>
        .course-detail-layout {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        @media (min-width: 1024px) {
            .course-detail-layout {
                display: grid;
                grid-template-columns: 1fr 340px;
                gap: 36px;
                align-items: start;
            }
        }
    </style>

    <!-- HEADER / BREADCRUMB SECTION -->
    <div style="background: linear-gradient(180deg, #0B1F3A 0%, #081628 100%); border-bottom: 1px solid #1e3a5f; padding: 24px 0 28px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-slate-600">></span>
                <a href="{{ route('courses.index') }}" class="hover:text-white transition-colors">Courses</a>
                <span class="text-slate-600">></span>
                <a href="#" class="hover:text-white transition-colors">{{ $course->category?->name ?? 'Web Development' }}</a>
                <span class="text-slate-600">></span>
                <span class="text-rose-400 font-bold max-w-xs truncate">{{ $course->title }}</span>
            </nav>

            <div class="max-w-4xl space-y-4">
                <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight">
                    {{ $course->title }} - Beginner to Advanced
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Master {{ $course->title }} from scratch. Build real-world projects, learn REST APIs, Livewire 3, Sanctum, and get placed as a professional software engineer.
                </p>

                <!-- Instructor Row & Rating -->
                <div class="flex flex-wrap items-center gap-6 pt-2 text-xs">
                    <div class="flex items-center gap-3">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 18px; box-shadow: 0 4px 14px rgba(214,40,40,0.35);" class="shrink-0">
                            {{ strtoupper(substr($course->trainer?->name ?? 'John Doe', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 14px; font-weight: 800; color: white;">{{ $course->trainer?->name ?? 'John Doe' }}</div>
                            <div style="font-size: 11.5px; color: #94a3b8;">Senior Laravel Developer @ TCS</div>
                        </div>
                    </div>

                    <div class="h-8 w-px bg-slate-700 hidden sm:block"></div>

                    <div class="flex items-center gap-2">
                        <span class="text-amber-400 font-bold text-sm">4.8 ★★★★★</span>
                        <span class="text-slate-400">(1,234 reviews)</span>
                        <span class="text-slate-600">•</span>
                        <span class="text-slate-300 font-bold">15,432 students</span>
                    </div>
                </div>

                <!-- Course Meta Info Bar -->
                <div class="flex flex-wrap items-center gap-5 pt-4 text-xs text-slate-300 border-t border-slate-800">
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> 42 hours total</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg> 156 video lectures</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> 25 quizzes</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> 18 assignments</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg> Certificate of completion</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Lifetime access</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg> Mobile & desktop access</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN TWO COLUMN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="course-detail-layout">

            <!-- LEFT COLUMN (70% Width) -->
            <div class="space-y-10">

                <!-- 1. WHAT YOU'LL LEARN -->
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-6">
                    <h2 class="text-2xl font-black text-white">What You'll Learn</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-300">
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Build complete web applications with Laravel 12</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Master PHP 8.3, MySQL, and REST API design</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Implement API authentication with Laravel Sanctum</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Create dynamic UIs with Livewire 3 components</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Deploy to production with Docker & CI/CD</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Build a complete job portal project from scratch</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Prepare for senior technical interview rounds</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Get direct job placement support & referrals</span>
                        </div>
                    </div>
                </div>

                <!-- 2. COURSE CURRICULUM -->
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-6">
                    @php
                        $dbModules = $course->currentVersion?->modules ?? collect([]);
                        $totalLecturesCount = $dbModules->pluck('lessons')->flatten()->count();
                    @endphp

                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-black text-white">Course Curriculum</h2>
                        <span class="text-xs text-slate-400 font-semibold">{{ $dbModules->count() }} Modules • {{ $totalLecturesCount }} Lectures</span>
                    </div>

                    <div class="space-y-3" x-data="{ openMod: 0 }">
                        @forelse ($dbModules as $mIdx => $mod)
                            <div style="background: #081628; border: 1px solid #1e3a5f; border-radius: 16px;" class="overflow-hidden">
                                <button @click="openMod = openMod === {{ $mIdx }} ? null : {{ $mIdx }}" class="w-full px-5 py-4 text-left flex items-center justify-between hover:bg-slate-800/40 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span style="background: #1e3a5f; color: #60a5fa;" class="w-7 h-7 rounded-lg text-xs font-extrabold flex items-center justify-center">
                                            {{ $mIdx + 1 }}
                                        </span>
                                        <span class="text-sm font-bold text-white">{{ $mod->title }}</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-xs text-slate-400 hidden sm:inline">{{ $mod->lessons->count() }} {{ Str::plural('lecture', $mod->lessons->count()) }}</span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="openMod === {{ $mIdx }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </button>
                                <div x-show="openMod === {{ $mIdx }}" x-cloak class="px-5 py-3 border-t border-slate-800 space-y-2 text-xs text-slate-300">
                                    @forelse ($mod->lessons as $lesIdx => $les)
                                        <div class="flex items-center justify-between py-1 border-b border-slate-800/60 last:border-0">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-4 h-4 {{ $les->is_free_preview ? 'text-rose-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Lecture {{ $lesIdx + 1 }}: {{ $les->title }}
                                            </span>
                                            @if ($les->is_free_preview)
                                                <span class="text-emerald-400 font-bold text-[10.5px]">Free Preview</span>
                                            @else
                                                <span class="text-slate-500">{{ (int) round($les->duration / 60) }} min</span>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-slate-500 py-1 italic">No lessons added to this module yet.</div>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 text-center text-slate-400 text-xs">
                                Course curriculum is currently being updated.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 3. REQUIREMENTS -->
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">Requirements</h2>
                    <ul class="space-y-2.5 text-xs text-slate-300 list-disc list-inside">
                        <li>Basic HTML, CSS, and elementary programming knowledge.</li>
                        <li>Any computer running Windows, macOS, or Linux.</li>
                        <li>A willingness to write production-grade PHP code.</li>
                    </ul>
                </div>

                <!-- 4. FULL DESCRIPTION -->
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">Description</h2>
                    <div class="text-xs text-slate-300 leading-relaxed space-y-4">
                        <p>
                            Welcome to the <strong>Complete Laravel 12 Development Course 2026</strong>. This comprehensive program is designed to take you from foundational PHP concepts to advanced enterprise software architecture. Unlike basic tutorials that rely on dummy code, this curriculum focuses on production-level design patterns, Domain-Driven Design (DDD), Repository & Service layers, and Livewire 3 reactivity.
                        </p>
                        <p>
                            Throughout this course, you will build a full-fledged enterprise Job Portal and Learning System from scratch. You will implement token authentication using Laravel Sanctum, configure high-throughput background queues with Redis and Horizon, write automated tests, and deploy your applications using Docker containers.
                        </p>
                        <p>
                            By the end of this course, you will have a production repository on GitHub, a verified SHA-256 certificate, and the direct technical preparation needed to land senior backend software engineering roles at top tech firms.
                        </p>
                    </div>
                </div>

                <!-- 5. INSTRUCTOR BIO -->
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-6">
                    <h2 class="text-2xl font-black text-white">Instructor</h2>
                    <div class="flex flex-col sm:flex-row items-start gap-6">
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 36px; box-shadow: 0 6px 20px rgba(214,40,40,0.4);" class="shrink-0">
                            {{ strtoupper(substr($course->trainer?->name ?? 'John Doe', 0, 1)) }}
                        </div>
                        <div class="space-y-3 flex-1">
                            <div>
                                <h3 class="text-xl font-extrabold text-white">{{ $course->trainer?->name ?? 'John Doe' }}</h3>
                                <div class="text-xs text-rose-400 font-semibold">Senior Laravel Developer @ TCS</div>
                            </div>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                10+ years of experience in PHP and Laravel development. Previously worked at TCS and Infosys building high-scale microservices. Taught 50,000+ students worldwide with a focus on clean code and production architecture.
                            </p>
                            <div class="flex items-center gap-4 pt-1">
                                <a href="#" style="color: #60a5fa;" class="text-xs font-bold hover:underline">LinkedIn</a>
                                <a href="#" style="color: #cbd5e1;" class="text-xs font-bold hover:underline">GitHub</a>
                                <a href="#" style="color: #38bdf8;" class="text-xs font-bold hover:underline">Twitter</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. STUDENT REVIEWS -->
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-6">
                    <h2 class="text-2xl font-black text-white">Student Reviews</h2>

                    <!-- Overall Rating Overview -->
                    <div class="flex flex-col sm:flex-row items-center gap-8 p-6 rounded-2xl" style="background: #081628; border: 1px solid #1e3a5f;">
                        <div class="text-center sm:text-left space-y-1">
                            <div class="text-5xl font-black text-white">4.8</div>
                            <div class="text-amber-400 text-lg">★★★★★</div>
                            <div class="text-xs text-slate-400">Course Rating • 1,234 Reviews</div>
                        </div>

                        <div class="flex-1 space-y-2 text-xs w-full">
                            <div class="flex items-center gap-3">
                                <span class="w-8 text-slate-400">5 ★</span>
                                <div class="flex-1 h-2 rounded-full bg-slate-800 overflow-hidden"><div class="h-full bg-amber-400 rounded-full" style="width: 85%;"></div></div>
                                <span class="w-8 text-right text-slate-400">85%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-8 text-slate-400">4 ★</span>
                                <div class="flex-1 h-2 rounded-full bg-slate-800 overflow-hidden"><div class="h-full bg-amber-400 rounded-full" style="width: 12%;"></div></div>
                                <span class="w-8 text-right text-slate-400">12%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-8 text-slate-400">3 ★</span>
                                <div class="flex-1 h-2 rounded-full bg-slate-800 overflow-hidden"><div class="h-full bg-amber-400 rounded-full" style="width: 2%;"></div></div>
                                <span class="w-8 text-right text-slate-400">2%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        @php
                            $reviewsSample = [
                                ['name' => 'Priya S.', 'date' => '2 weeks ago', 'quote' => 'Excellent course! I learned Laravel from zero to advanced. The projects are real-world and the instructor explains everything clearly. Got placed at Infosys with 7 LPA after completing this course. Highly recommended!', 'helpful' => 234],
                                ['name' => 'Rahul M.', 'date' => '1 month ago', 'quote' => 'The production architecture, repository pattern, and Livewire 3 modules gave me the confidence to crack senior technical interview rounds easily.', 'helpful' => 189],
                            ];
                        @endphp

                        @foreach ($reviewsSample as $rev)
                            <div style="background: #081628; border: 1px solid #1e3a5f; border-radius: 16px; padding: 20px;" class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); color: white; font-weight: 800; font-size: 12px; display: flex; align-items: center; justify-content: center;">
                                            {{ strtoupper(substr($rev['name'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white">{{ $rev['name'] }}</div>
                                            <div class="text-[11px] text-amber-400">★★★★★ <span class="text-slate-500 ml-1">{{ $rev['date'] }}</span></div>
                                        </div>
                                    </div>
                                    <button style="background: #1e3a5f; color: #cbd5e1;" class="px-3 py-1 rounded-lg text-xs font-semibold flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Helpful ({{ $rev['helpful'] }})
                                    </button>
                                </div>
                                <p class="text-xs text-slate-300 leading-relaxed italic">
                                    "{{ $rev['quote'] }}"
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center pt-2">
                        <button class="text-xs font-bold text-rose-400 hover:underline">View all 1,234 reviews ➔</button>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (30% Width Sticky Card) -->
            <div style="position: sticky; top: 90px; z-index: 10;">
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 24px; box-shadow: 0 12px 36px rgba(0,0,0,0.35);" class="space-y-6">

                    <!-- Course Preview Video Container -->
                    <div style="position: relative; height: 180px; border-radius: 16px; overflow: hidden; background: #081628;">
                        <img src="{{ $course->thumbnail ?? 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&auto=format&fit=crop&q=80' }}" alt="Course Preview" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; inset: 0; background: rgba(11,31,58,0.4); display: flex; align-items: center; justify-content: center;">
                            <div style="width: 56px; height: 56px; border-radius: 50%; background: #D62828; color: white; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(214,40,40,0.5); cursor: pointer;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <svg class="w-7 h-7 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Discount Badge -->
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <span style="background: #D62828; color: white;" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                                40% OFF - Limited Time!
                            </span>
                        </div>
                        <div class="flex items-baseline gap-3 pt-2">
                            <span class="text-3xl font-black text-[#f87171]">₹{{ number_format($course->currentVersion?->price ?? 2999) }}</span>
                            <span class="text-sm text-slate-500 line-clamp-1 line-through">₹{{ number_format(($course->currentVersion?->price ?? 2999) * 1.66) }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button wire:click="enroll" style="background: #D62828; color: white; box-shadow: 0 4px 16px rgba(214,40,40,0.4);" class="w-full py-3.5 rounded-xl font-extrabold text-sm hover:bg-red-700 transition-all text-center block">
                            Enroll Now ➔
                        </button>
                        <button style="background: transparent; border: 1px solid #1e3a5f; color: white;" class="w-full py-3 rounded-xl font-bold text-xs hover:bg-slate-800 transition-all">
                            Add to Cart
                        </button>
                    </div>

                    <!-- Guarantee Badge -->
                    <div style="background: #081628; border: 1px solid #1e3a5f; border-radius: 12px; padding: 12px;" class="flex items-center gap-3 text-xs text-slate-300">
                        <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span><strong>30-Day Money-Back Guarantee</strong><br><span class="text-[11px] text-slate-400">100% Risk-Free Guarantee</span></span>
                    </div>

                    <!-- This Course Includes List -->
                    <div class="space-y-3 text-xs text-slate-300 border-t border-slate-800 pt-4">
                        <h4 class="font-bold text-white text-xs uppercase tracking-wider mb-2">This course includes:</h4>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>42 hours on-demand video</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>156 downloadable resources</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>25 quizzes with solutions</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>18 coding assignments</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Certificate of completion</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Lifetime access</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Mobile & desktop access</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Job placement support</span>
                        </div>
                    </div>

                    <!-- Buy for your team -->
                    <div class="text-center pt-2 border-t border-slate-800">
                        <a href="#" style="color: #60a5fa;" class="text-xs font-bold hover:underline">Buy for your team (Corporate Discount) ➔</a>
                    </div>

                </div>
            </div>

        </div>

        <!-- BOTTOM SECTION: RELATED COURSES (4 Cards Row) -->
        <div class="mt-16 pt-10 border-t border-slate-800 space-y-8">
            <h2 class="text-2xl font-black text-white">Related Courses</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($relatedCourses as $rel)
                    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="position: relative; height: 150px; background: #081628;">
                                <img src="{{ $rel->thumbnail ?? 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&auto=format&fit=crop&q=80' }}" alt="{{ $rel->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; left: 10px; background: #D62828; color: white; font-weight: 800; font-size: 10px; padding: 3px 8px; border-radius: 20px;">
                                    40% OFF
                                </span>
                            </div>
                            <div style="padding: 14px; display: flex; flex-direction: column; gap: 8px;">
                                <h4 style="font-size: 14px; font-weight: 800; color: white; margin: 0; line-height: 1.3;" class="line-clamp-2">
                                    {{ $rel->title }}
                                </h4>
                                <div style="font-size: 11.5px; color: #94a3b8;">by {{ $rel->trainer?->name ?? 'John Doe' }}</div>
                                <div style="font-size: 16px; font-weight: 900; color: #f87171;">₹{{ number_format($rel->currentVersion?->price ?? 2999) }}</div>
                            </div>
                        </div>
                        <div style="padding: 0 14px 14px;">
                            <a href="{{ route('courses.show', $rel->id) }}" style="background: #D62828; color: white; font-weight: 800; font-size: 12px; padding: 8px; border-radius: 8px; text-align: center; display: block; text-decoration: none;">
                                View Syllabus ➔
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-slate-500 text-xs text-center py-4">No related courses found.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
