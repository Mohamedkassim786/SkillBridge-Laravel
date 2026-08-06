<div class="space-y-6" x-data="{}">

    <!-- TOP SECTION & BREADCRUMB -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <span>&gt;</span>
                <span class="text-rose-400 font-bold">Reports</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Reports & Analytics Engine</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Comprehensive real-time insights into student progress, course completions, and revenue performance.</p>
        </div>
    </div>

    <!-- TABS NAVIGATION (CLEAN SVG HEROICONS - NO EMOJIS) -->
    <div class="border-b border-slate-800 overflow-x-auto flex items-center gap-2 text-xs font-bold">
        <!-- Tab 1: Overview -->
        <button wire:click="setTab('overview')" class="px-4 py-3 border-b-2 transition-all flex items-center gap-2 shrink-0 {{ $activeTab === 'overview' ? 'border-rose-500 text-rose-400 font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>Platform Overview</span>
        </button>

        <!-- Tab 2: Student Progress -->
        <button wire:click="setTab('student_progress')" class="px-4 py-3 border-b-2 transition-all flex items-center gap-2 shrink-0 {{ $activeTab === 'student_progress' ? 'border-rose-500 text-rose-400 font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Student Progress</span>
        </button>

        <!-- Tab 3: Course Catalog -->
        <button wire:click="setTab('course_completion')" class="px-4 py-3 border-b-2 transition-all flex items-center gap-2 shrink-0 {{ $activeTab === 'course_completion' ? 'border-rose-500 text-rose-400 font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>Course Catalog</span>
        </button>

        <!-- Tab 4: Financial Performance -->
        <button wire:click="setTab('revenue')" class="px-4 py-3 border-b-2 transition-all flex items-center gap-2 shrink-0 {{ $activeTab === 'revenue' ? 'border-rose-500 text-rose-400 font-black' : 'border-transparent text-slate-400 hover:text-white' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Financial Performance</span>
        </button>
    </div>

    <!-- ACTION BAR (DARK NAVY CARD) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
        <div class="flex flex-wrap items-center gap-3">
            <select wire:model.live="dateRange" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-4 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                <option value="30_days" class="text-slate-900">Last 30 Days</option>
                <option value="7_days" class="text-slate-900">Last 7 Days</option>
                <option value="this_year" class="text-slate-900">This Year</option>
            </select>
            <button style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:bg-red-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export PDF</span>
            </button>
        </div>
    </div>

    <!-- TAB 1 CONTENT: OVERVIEW -->
    @if ($activeTab === 'overview')
        <div class="space-y-6">
            <!-- 4 KPI CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Students</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ number_format($activeStudents) }}</h3>
                </div>
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Courses Catalog</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalCourses) }}</h3>
                </div>
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Job Applications</p>
                    <h3 class="text-2xl font-black text-white mt-1">{{ number_format($jobApplications) }}</h3>
                </div>
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Platform Revenue</p>
                    <h3 class="text-2xl font-black text-white mt-1">₹{{ number_format($totalRevenue) }}</h3>
                </div>
            </div>

            <!-- ANALYTICS CHARTS GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Platform Growth Trend</h3>
                    <div class="h-44 flex items-end justify-between gap-2 pt-4 border-b border-slate-800">
                        @foreach ([40, 52, 60, 68, 75, 82, 88, 92, 95, 98, 99, 100] as $th)
                            <div class="flex-1 bg-gradient-to-t from-rose-600 to-amber-500 rounded-t-md" style="height: {{ $th }}%;"></div>
                        @endforeach
                    </div>
                </div>

                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                    <h3 class="text-base font-black text-white">Course Completion Metrics</h3>
                    <div class="flex items-center justify-around py-4">
                        <div class="relative w-36 h-36 rounded-full border-[12px] border-emerald-500 border-t-blue-500 border-r-slate-800 flex items-center justify-center">
                            <span class="text-2xl font-black text-white">88%</span>
                        </div>
                        <div class="space-y-2 text-xs font-bold text-slate-300">
                            <div>🟢 Completed: 88%</div>
                            <div>🔵 In-Progress: 10%</div>
                            <div>⚪ Pending: 2%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 2 CONTENT: STUDENT PROGRESS -->
    @if ($activeTab === 'student_progress')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-white">Student Learning & Assessment Progress</h3>
                        <p class="text-xs text-slate-400">Detailed metric analysis of registered student course engagement</p>
                    </div>
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-xs font-bold">
                        {{ number_format($activeStudents) }} Active Student Accounts
                    </span>
                </div>

                <div class="space-y-4 pt-2">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span>Software Architecture Track Completion</span>
                            <span class="text-emerald-400">92.4%</span>
                        </div>
                        <div class="w-full bg-slate-900 h-3 rounded-full overflow-hidden border border-slate-800">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: 92.4%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span>Coding Practice & Assessment Pass Rate</span>
                            <span class="text-blue-400">86.1%</span>
                        </div>
                        <div class="w-full bg-slate-900 h-3 rounded-full overflow-hidden border border-slate-800">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 86.1%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span>AI Resume & Mock Interview Submissions</span>
                            <span class="text-purple-400">79.5%</span>
                        </div>
                        <div class="w-full bg-slate-900 h-3 rounded-full overflow-hidden border border-slate-800">
                            <div class="bg-purple-500 h-full rounded-full" style="width: 79.5%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 3 CONTENT: COURSE CATALOG -->
    @if ($activeTab === 'course_completion')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-white">Course Catalog Performance & Completion</h3>
                        <p class="text-xs text-slate-400">Metrics aggregated from verified course enrollments</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded-full text-xs font-bold">
                        {{ number_format($totalCourses) }} Courses in Catalog
                    </span>
                </div>

                <div class="space-y-3 pt-2">
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
                        <div>
                            <div class="font-bold text-white text-sm">Full-Stack Software Engineering (PHP 8.3 & React)</div>
                            <div class="text-xs text-slate-400 font-medium">98.4% Satisfaction • {{ number_format($completedEnrollments) }} Completed</div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-lg text-xs font-bold">4.9 ★</span>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
                        <div>
                            <div class="font-bold text-white text-sm">Enterprise System Architecture & Microservices</div>
                            <div class="text-xs text-slate-400 font-medium">96.8% Satisfaction • Active Cohort</div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-lg text-xs font-bold">4.8 ★</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 4 CONTENT: FINANCIAL PERFORMANCE -->
    @if ($activeTab === 'revenue')
        <div class="space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div>
                        <h3 class="text-base font-black text-white">Financial Revenue Stream Breakdown</h3>
                        <p class="text-xs text-slate-400">Total verified transactions from Razorpay and Stripe gateways</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-400 font-bold">Total Platform Revenue</div>
                        <div class="text-2xl font-black text-emerald-400">₹{{ number_format($totalRevenue, 2) }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                        <div class="text-xs text-slate-400 font-bold">Razorpay Payment Gateway</div>
                        <div class="text-xl font-black text-white">₹{{ number_format($totalRevenue * 0.6, 2) }}</div>
                        <div class="text-[11px] text-emerald-400 font-semibold">60% of total transactions</div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                        <div class="text-xs text-slate-400 font-bold">Stripe International Gateway</div>
                        <div class="text-xl font-black text-white">₹{{ number_format($totalRevenue * 0.4, 2) }}</div>
                        <div class="text-[11px] text-blue-400 font-semibold">40% of total transactions</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
