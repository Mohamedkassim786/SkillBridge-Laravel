<div class="p-4 space-y-6">
    <!-- Main Navigation Section -->
    <div>
        <div class="px-3 mb-2 text-xs font-extrabold uppercase tracking-wider text-slate-400">Student Portal</div>
        <nav class="space-y-1.5" x-data="{ openCourses: true, openJobs: true, openResume: {{ request()->routeIs('student.career.*') ? 'true' : 'true' }}, openPractice: {{ request()->routeIs('student.practice.*') ? 'true' : 'true' }} }">
            
            <!-- 1. DASHBOARD -->
            <a href="{{ route('student.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('student.dashboard') ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- 2. MY COURSES (DROPDOWN) -->
            <div>
                <button @click="openCourses = !openCourses" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/10 hover:text-white transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>My Courses</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openCourses ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openCourses" class="pl-6 pt-1 space-y-1">
                    <a href="{{ route('student.courses.index') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.courses.index') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Enrolled Courses</span>
                    </a>
                    <a href="{{ route('courses.index') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition-all group">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Browse Course Catalog</span>
                    </a>
                </div>
            </div>

            <!-- 3. JOBS & CAREERS (DROPDOWN) -->
            <div>
                <button @click="openJobs = !openJobs" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/10 hover:text-white transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Jobs & Careers</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openJobs ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openJobs" class="pl-6 pt-1 space-y-1">
                    <a href="{{ route('jobs.index') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/10 transition-all group">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M15 16h.01M15 12h.01M9 8h.01M15 8h.01"></path>
                        </svg>
                        <span>Jobs Marketplace</span>
                    </a>
                    <a href="{{ route('student.applications.index') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.applications.*') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>My Job Applications</span>
                    </a>
                    <a href="{{ route('student.career.saved') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.career.saved') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        <span>Saved Jobs & Alerts</span>
                    </a>
                </div>
            </div>

            <!-- 4. RESUME BUILDER (DROPDOWN) -->
            <div>
                <button @click="openResume = !openResume" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/10 hover:text-white transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Resume Builder</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openResume ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openResume" class="pl-6 pt-1 space-y-1">
                    <a href="{{ route('student.career.resume') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.career.resume') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>AI Resume & ATS Score</span>
                    </a>
                    <a href="{{ route('student.career.cover-letter') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.career.cover-letter') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Cover Letter Generator</span>
                    </a>
                </div>
            </div>

            <!-- 5. PRACTICE & ASSESSMENTS (DROPDOWN) -->
            <div>
                <button @click="openPractice = !openPractice" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/10 hover:text-white transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        <span>Practice Hub</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openPractice ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openPractice" class="pl-6 pt-1 space-y-1">
                    <a href="{{ route('student.practice.coding') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.practice.coding') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        <span>Coding Practice Sandbox</span>
                    </a>
                    <a href="{{ route('student.practice.mock') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.practice.mock') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>AI Mock Interviews</span>
                    </a>
                    <a href="{{ route('student.practice.assessments') }}" class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm font-semibold transition-all hover:bg-white/10 group {{ request()->routeIs('student.practice.assessments') ? 'text-rose-400 font-bold bg-white/5' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Skill Assessment Tests</span>
                    </a>
                </div>
            </div>

            <!-- 6. LIVE CLASSES -->
            <a href="{{ route('student.live-classes.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('student.live-classes.*') ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span>Live Classes</span>
            </a>

            <!-- 7. CERTIFICATES -->
            <a href="{{ route('student.certificates.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('student.certificates.*') ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <span>Certificates</span>
            </a>

            <!-- 8. PAYMENTS -->
            <a href="{{ route('student.payments.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('student.payments.*') ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span>Payments & Billing</span>
            </a>

            <!-- 9. PROFILE & SETTINGS -->
            <a href="{{ route('student.settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('student.settings.*') ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                </svg>
                <span>My Profile & Settings</span>
            </a>
        </nav>
    </div>
</div>

<!-- Bottom Logout Button -->
<div class="p-4 border-t border-white/10">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold text-sm text-rose-400 hover:bg-rose-500/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Sign Out Account
        </button>
    </form>
</div>
