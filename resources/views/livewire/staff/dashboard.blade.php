<div class="space-y-6" x-data="{ modalOpen: @entangle('showReplyModal') }">

    <!-- Flash Status Messages -->
    @if (session()->has('status'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold text-xs flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-sm">✕</button>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📊 1. STAFF DASHBOARD OVERVIEW -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'dashboard')
        <div class="space-y-6">
            <!-- HERO BANNER -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="relative z-10 max-w-2xl">
                    <span class="px-3 py-1 rounded-full bg-teal-500/20 text-teal-300 text-xs font-bold border border-teal-500/30 uppercase tracking-widest inline-block mb-3">
                        Trainer & Instructor Workspace
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">Welcome back, {{ auth()->user()?->name ?? 'Instructor' }}! 👋</h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-2 font-medium leading-relaxed">
                        Manage course curriculum, upload video lectures, evaluate student assignments, and answer live student doubts.
                    </p>
                </div>

                <div class="relative z-10 flex flex-wrap items-center gap-3">
                    <button wire:click="setTab('create_course')" class="px-5 py-3 rounded-2xl bg-teal-500 hover:bg-teal-600 text-white font-extrabold text-xs shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Create New Course</span>
                    </button>
                    <a href="{{ route('admin.lessons.manage') }}" style="background-color: #D62828;" class="px-5 py-3 rounded-2xl text-white font-extrabold text-xs shadow-lg hover:bg-red-700 transition-all flex items-center gap-2 text-decoration-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 00-2 2z"/></svg>
                        <span>Upload Video Lecture</span>
                    </a>
                </div>
            </div>

            <!-- 4 REAL TOP STATS CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Courses Catalog</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalCoursesCount) }}</h3>
                    <p class="text-[11px] text-emerald-400 mt-1 font-semibold">Live MySQL 8 Records</p>
                </div>

                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Active Students</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalStudentsCount) }}</h3>
                    <p class="text-[11px] text-blue-400 mt-1 font-semibold">Enrolled Student Accounts</p>
                </div>

                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Platform Revenue</p>
                    <h3 class="text-2xl font-black text-emerald-400 mt-1">₹{{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-[11px] text-emerald-300 mt-1 font-semibold">Verified Transactions</p>
                </div>

                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Curriculum Video Lessons</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalLessonsCount) }}</h3>
                    <p class="text-[11px] text-amber-400 mt-1 font-semibold">Published Video Streaming</p>
                </div>
            </div>

            <!-- COURSES LISTING TABLE -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden text-white text-xs">
                <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                    <h3 class="text-base font-black text-white">My Assigned Courses & Curriculum</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-slate-300">
                        <thead>
                            <tr class="bg-slate-900/90 text-white font-black uppercase text-[11px] border-b border-slate-800">
                                <th class="p-4">Course Title</th>
                                <th class="p-4">Modules</th>
                                <th class="p-4">Lessons</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse ($courses as $c)
                                <tr class="hover:bg-slate-800/60 transition-colors">
                                    <td class="p-4 font-bold text-white text-xs">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $c->thumbnail }}" alt="{{ $c->title }}" class="w-14 h-9 rounded-lg object-cover border border-slate-700">
                                            <span>{{ $c->title }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 font-semibold text-slate-400">
                                        {{ $c->currentVersion?->modules->count() ?: 0 }} Modules
                                    </td>
                                    <td class="p-4 font-semibold text-slate-400">
                                        {{ $c->currentVersion?->modules->sum(fn($m) => $m->lessons->count()) ?: 0 }} Lessons
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('admin.lessons.manage', ['selectedCourseId' => $c->id]) }}" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold text-xs text-decoration-none inline-block">
                                            Manage Lessons
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-400">No course records in database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📚 2. MY COURSES -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'courses')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">My Assigned Courses</h2>
                        <p class="text-xs text-slate-400 mt-1">Manage course curriculum, modules, and video streaming</p>
                    </div>
                    <button wire:click="setTab('create_course')" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-extrabold text-xs shadow-md">
                        + Create Course
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    @forelse ($courses as $cItem)
                        <div style="background-color: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl space-y-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $cItem->thumbnail }}" class="w-16 h-10 rounded-lg object-cover border border-slate-700">
                                <div>
                                    <div class="font-bold text-white text-xs">{{ $cItem->title }}</div>
                                    <div class="text-[11px] text-slate-400">Slug: {{ $cItem->slug }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-2 border-t border-slate-800">
                                <span class="text-emerald-400 font-bold">Price: ₹{{ number_format($cItem->currentVersion?->price ?? 0, 2) }}</span>
                                <a href="{{ route('admin.lessons.manage', ['selectedCourseId' => $cItem->id]) }}" class="text-rose-400 font-bold hover:underline">Manage Lessons ➔</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-slate-400 text-xs">No courses registered.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- ➕ 3. CREATE COURSE BUILDER -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'create_course')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h2 class="text-xl font-black text-white tracking-tight">Create Course Builder (Step {{ $createCourseStep }} of 4)</h2>
                    <p class="text-xs text-slate-400 mt-1">Build, structure, and publish a new software course curriculum.</p>
                </div>
                <div class="flex items-center gap-1.5">
                    @for ($s = 1; $s <= 4; $s++)
                        <button wire:click="setCreateStep({{ $s }})" class="w-8 h-8 rounded-full font-black text-xs transition-all {{ $createCourseStep === $s ? 'bg-[#D62828] text-white shadow-lg' : 'bg-slate-800 text-slate-400' }}">{{ $s }}</button>
                    @endfor
                </div>
            </div>

            @if ($createCourseStep === 1)
                <form wire:submit.prevent="setCreateStep(2)" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Course Title</label>
                        <input type="text" placeholder="Enter course title..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl font-semibold focus:outline-none focus:border-rose-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Course Subtitle</label>
                        <input type="text" placeholder="Enter subtitle..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Category</label>
                            <select style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2.5 rounded-xl font-bold">
                                <option class="text-slate-900">Web Development</option>
                                <option class="text-slate-900">System Design</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Level</label>
                            <select style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2.5 rounded-xl font-bold">
                                <option class="text-slate-900">Beginner</option>
                                <option class="text-slate-900">Intermediate</option>
                                <option class="text-slate-900">Advanced</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4 border-t border-slate-800">
                        <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black">Next: Curriculum →</button>
                    </div>
                </form>
            @elseif ($createCourseStep === 2)
                <div class="space-y-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
                        <span class="font-bold text-white">Module 1: Web Architecture & Database Optimization</span>
                        <a href="{{ route('admin.lessons.manage') }}" class="px-3 py-1.5 rounded-lg bg-teal-600 text-white font-bold text-decoration-none">+ Add Lesson</a>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-slate-800">
                        <button wire:click="setCreateStep(1)" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 font-bold">← Back</button>
                        <button wire:click="setCreateStep(3)" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black">Next: Pricing →</button>
                    </div>
                </div>
            @elseif ($createCourseStep === 3)
                <div class="space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Course Price (₹)</label>
                            <input type="number" value="4999" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl font-bold">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1">Discount Price (₹)</label>
                            <input type="number" value="2999" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl font-bold">
                        </div>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-slate-800">
                        <button wire:click="setCreateStep(2)" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 font-bold">← Back</button>
                        <button wire:click="setCreateStep(4)" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black">Next: Publish →</button>
                    </div>
                </div>
            @else
                <div class="text-center py-6 space-y-4 text-xs">
                    <div class="w-14 h-14 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 font-black flex items-center justify-center text-xl mx-auto">✓</div>
                    <h3 class="text-base font-black text-white">Course Curriculum Ready for Review & Publishing!</h3>
                    <div class="flex justify-center gap-3">
                        <button wire:click="setTab('courses')" style="background-color: #D62828;" class="px-6 py-3 rounded-xl text-white font-black">Publish Course Now</button>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 👥 4. MY BATCHES -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'batches')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">My Student Batches</h2>
                        <p class="text-xs text-slate-400 mt-1">Live active cohorts and student learning groups</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Courses</div>
                        <div class="text-2xl font-black text-white mt-1">{{ number_format($totalCoursesCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Enrolled Students</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($totalStudentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Verified Enrollments</div>
                        <div class="text-2xl font-black text-blue-400 mt-1">{{ number_format($totalEnrollmentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Completed Tracks</div>
                        <div class="text-2xl font-black text-amber-400 mt-1">{{ number_format($completedEnrollmentsCount) }}</div>
                    </div>
                </div>

                <div class="overflow-x-auto pt-4">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead>
                            <tr class="bg-slate-900/90 text-white font-bold border-b border-slate-800">
                                <th class="p-3">Cohort Batch</th>
                                <th class="p-3">Course Track</th>
                                <th class="p-3 text-center">Active Students</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse ($courses as $bCourse)
                                <tr class="hover:bg-slate-800/60">
                                    <td class="p-3 font-bold text-white">{{ $bCourse->title }} Batch</td>
                                    <td class="p-3 text-slate-400">{{ $bCourse->title }} Track</td>
                                    <td class="p-3 text-center font-bold text-emerald-400">{{ number_format($totalStudentsCount) }} Students</td>
                                    <td class="p-3 text-center"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Active</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-4 text-center text-slate-400">No active cohorts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📝 5. ASSIGNMENTS -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'assignments')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">Assignments & Student Submissions</h2>
                        <p class="text-xs text-slate-400 mt-1">Review student submissions and evaluate coding progress</p>
                    </div>
                </div>

                <!-- 4 REAL ASSIGNMENT STAT CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Registered Students</div>
                        <div class="text-2xl font-black text-white mt-1">{{ number_format($totalStudentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Courses</div>
                        <div class="text-2xl font-black text-amber-400 mt-1">{{ number_format($totalCoursesCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Completed Enrollments</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($completedEnrollmentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Job Applications</div>
                        <div class="text-2xl font-black text-blue-400 mt-1">{{ number_format($jobApplicationsCount) }}</div>
                    </div>
                </div>

                <!-- ASSIGNMENTS TABLE -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead>
                            <tr class="bg-slate-900/90 text-white font-bold border-b border-slate-800">
                                <th class="p-3">Course Assignment Track</th>
                                <th class="p-3">Student Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse ($students as $st)
                                <tr class="hover:bg-slate-800/60">
                                    <td class="p-3 font-bold text-white">Course Assessment Module</td>
                                    <td class="p-3 text-slate-300 font-semibold">{{ $st->first_name }} {{ $st->last_name }}</td>
                                    <td class="p-3 text-slate-400 font-mono">{{ $st->email }}</td>
                                    <td class="p-3 text-center">
                                        <button wire:click="$set('showGradeModal', true)" class="px-3 py-1 bg-slate-800 border border-slate-700 hover:bg-slate-700 text-white rounded-lg text-xs font-bold">
                                            Evaluate
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-4 text-center text-slate-400">No student submissions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📊 6. QUIZZES -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'quizzes')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">Quizzes & Assessment Tracks</h2>
                        <p class="text-xs text-slate-400 mt-1">Manage multiple-choice quizzes and coding assessment tracks</p>
                    </div>
                </div>

                <!-- 4 REAL QUIZ STAT CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Courses</div>
                        <div class="text-2xl font-black text-white mt-1">{{ number_format($totalCoursesCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Curriculum Lessons</div>
                        <div class="text-2xl font-black text-blue-400 mt-1">{{ number_format($totalLessonsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Students</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($totalStudentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Completed Enrollments</div>
                        <div class="text-2xl font-black text-amber-400 mt-1">{{ number_format($completedEnrollmentsCount) }}</div>
                    </div>
                </div>

                <!-- QUIZZES TABLE -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead>
                            <tr class="bg-slate-900/90 text-white font-bold border-b border-slate-800">
                                <th class="p-3">Course Assessment Track</th>
                                <th class="p-3">Curriculum Lessons</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse ($courses as $qCourse)
                                <tr class="hover:bg-slate-800/60">
                                    <td class="p-3 font-bold text-white">{{ $qCourse->title }} Quiz Track</td>
                                    <td class="p-3 text-slate-400">{{ $qCourse->currentVersion?->modules->sum(fn($m) => $m->lessons->count()) ?: 0 }} Lessons</td>
                                    <td class="p-3 text-center"><span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Active</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="p-4 text-center text-slate-400">No active quiz tracks found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📈 7. STUDENT PROGRESS -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'student_progress')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <h2 class="text-xl font-black text-white tracking-tight">Student Progress & Analytics</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead>
                            <tr class="bg-slate-900/90 text-white font-bold border-b border-slate-800">
                                <th class="p-3">Student Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse ($students as $st)
                                <tr class="hover:bg-slate-800/60">
                                    <td class="p-3 font-bold text-white">{{ $st->first_name }} {{ $st->last_name }}</td>
                                    <td class="p-3 text-slate-400">{{ $st->email }}</td>
                                    <td class="p-3 text-center font-bold text-emerald-400">Active Student</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="p-4 text-center text-slate-400">No student records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📅 8. LIVE CLASSES -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'live_classes')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">Live Masterclasses & Schedule</h2>
                        <p class="text-xs text-slate-400 mt-1">Manage live WebRTC & Zoom masterclass streaming sessions</p>
                    </div>
                    <a href="{{ url('/student/live-classroom') }}" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-extrabold text-xs shadow-md text-decoration-none inline-block">
                        🚀 Launch Live Stream
                    </a>
                </div>

                <!-- 4 REAL LIVE CLASS STAT CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Courses</div>
                        <div class="text-2xl font-black text-white mt-1">{{ number_format($totalCoursesCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Students</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($totalStudentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Verified Enrollments</div>
                        <div class="text-2xl font-black text-blue-400 mt-1">{{ number_format($totalEnrollmentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Lessons</div>
                        <div class="text-2xl font-black text-amber-400 mt-1">{{ number_format($totalLessonsCount) }}</div>
                    </div>
                </div>

                <!-- LIVE CLASSES LIST WITH DIRECT CLASSROOM LINK -->
                <div class="space-y-3 pt-2 text-xs">
                    @forelse ($courses as $lCourse)
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <div class="font-black text-white text-sm">Live Session: {{ $lCourse->title }}</div>
                                <div class="text-slate-400 mt-0.5 font-semibold">Track: {{ $lCourse->title }} • Platform: WebRTC / Zoom</div>
                                <div class="text-teal-400 font-bold mt-1">📅 Scheduled • {{ number_format($totalStudentsCount) }} Active Students</div>
                            </div>
                            <a href="{{ url('/student/live-classroom') }}" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-extrabold shadow-md shrink-0 text-decoration-none inline-block">
                                🚀 Start Live Class
                            </a>
                        </div>
                    @empty
                        <div class="p-4 text-slate-400 text-xs">No active masterclasses.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📄 9. COURSE MATERIALS -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'materials')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tight">Course Materials & Video Resources</h2>
                        <p class="text-xs text-slate-400 mt-1">Manage video lessons, curriculum modules, and materials</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Video Lessons</div>
                        <div class="text-2xl font-black text-white mt-1">{{ number_format($totalLessonsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Courses</div>
                        <div class="text-2xl font-black text-blue-400 mt-1">{{ number_format($totalCoursesCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Students</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($totalStudentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Total Enrollments</div>
                        <div class="text-2xl font-black text-amber-400 mt-1">{{ number_format($totalEnrollmentsCount) }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📋 10. REPORTS -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'reports')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <h2 class="text-xl font-black text-white tracking-tight">Trainer Reports & Performance</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Courses</div>
                        <div class="text-2xl font-black text-white mt-1">{{ number_format($totalCoursesCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Active Students</div>
                        <div class="text-2xl font-black text-emerald-400 mt-1">{{ number_format($totalStudentsCount) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Platform Revenue</div>
                        <div class="text-2xl font-black text-emerald-300 mt-1">₹{{ number_format($totalRevenue, 2) }}</div>
                    </div>
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl text-white">
                        <div class="text-xs text-slate-400 font-bold uppercase">Curriculum Lessons</div>
                        <div class="text-2xl font-black text-blue-400 mt-1">{{ number_format($totalLessonsCount) }} Lessons</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- ⚙️ 11. SETTINGS -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'settings')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-6 text-xs">
            <h2 class="text-xl font-black text-white tracking-tight">Trainer Settings & Account Profile</h2>
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-slate-300 space-y-2">
                <div><strong>Trainer Name:</strong> {{ auth()->user()?->name }}</div>
                <div><strong>Email Address:</strong> {{ auth()->user()?->email }}</div>
                <div><strong>Account Role:</strong> {{ auth()->user()?->roles->pluck('name')->implode(', ') ?: 'Staff Instructor' }}</div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 📞 12. MESSAGES -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'messages')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
            <h2 class="text-xl font-black text-white tracking-tight">Student Communications Inbox</h2>
            <div class="space-y-3 pt-2 text-xs">
                @forelse ($students as $stItem)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <div class="font-bold text-white text-sm">{{ $stItem->first_name }} {{ $stItem->last_name }}</div>
                            <div class="text-slate-400 mt-0.5">Student Account • {{ $stItem->email }}</div>
                        </div>
                        <button wire:click="openReplyModal('{{ $stItem->first_name }}', 'Course Support Inquiry')" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-bold text-xs">
                            Message Student
                        </button>
                    </div>
                @empty
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-400 text-center">No student records in inbox.</div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 🎯 13. HELP & SUPPORT -->
    <!-- ========================================================================= -->
    @if ($activeTab === 'support')
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4 text-xs">
            <h2 class="text-xl font-black text-white tracking-tight">Instructor Help & Guidelines Handbook</h2>
            <p class="text-slate-300">Access teaching guides, curriculum standards, and platform policies.</p>
        </div>
    @endif

    <!-- GRADE SUBMISSION MODAL -->
    <div x-show="$wire.showGradeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden text-white">
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-black tracking-tight text-white">Grade Student Submission</h3>
                <button wire:click="$set('showGradeModal', false)" class="text-slate-400 hover:text-white">✕</button>
            </div>
            <div class="p-6 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Score (0-100)</label>
                    <input type="number" wire:model="gradeScore" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl font-bold">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Feedback</label>
                    <textarea wire:model="gradeFeedback" rows="3" placeholder="Enter detailed feedback..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="submitGrade" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black">Submit Grade</button>
                </div>
            </div>
        </div>
    </div>

    <!-- REPLIES MODAL -->
    <div x-show="$wire.showReplyModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden text-white">
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-black tracking-tight text-white">Reply to {{ $selectedStudentName }}</h3>
                <button wire:click="$set('showReplyModal', false)" class="text-slate-400 hover:text-white">✕</button>
            </div>
            <div class="p-6 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Reply Message</label>
                    <textarea wire:model="replyMessage" rows="4" placeholder="Type your answer for the student..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="sendReply" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black">Send Reply</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCHEDULE CLASS MODAL -->
    <div x-show="$wire.showScheduleClassModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden text-white">
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-black tracking-tight text-white">Schedule New Live Class</h3>
                <button wire:click="$set('showScheduleClassModal', false)" class="text-slate-400 hover:text-white">✕</button>
            </div>
            <div class="p-6 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Class Title</label>
                    <input type="text" placeholder="e.g. Live Q&A: Masterclass" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl font-bold">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Date</label>
                        <input type="date" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Time</label>
                        <input type="time" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="scheduleLiveClass" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black">Schedule Session</button>
                </div>
            </div>
        </div>
    </div>

</div>
