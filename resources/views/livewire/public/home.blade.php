<div class="space-y-24 pb-24" style="background-color: #321847;">
    <style>
        .hero-content {
            position: relative;
            z-index: 30;
            opacity: 1 !important;
            filter: none !important;
            mix-blend-mode: normal !important;
            isolation: isolate;
        }
        .hero-content h1,
        .hero-content h1 span,
        .hero-content p,
        .hero-content .hero-badge {
            opacity: 1 !important;
            filter: none !important;
            mix-blend-mode: normal !important;
        }
        .hero-text-white {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
            opacity: 1 !important;
            filter: none !important;
            mix-blend-mode: normal !important;
            text-shadow: 0 3px 12px rgba(0,0,0,0.9);
        }
        .hero-text-accent {
            color: #ff4d50 !important;
            -webkit-text-fill-color: #ff4d50 !important;
            opacity: 1 !important;
            filter: none !important;
            mix-blend-mode: normal !important;
            text-shadow: 0 3px 12px rgba(0,0,0,0.9);
        }
    </style>

    <!-- 1. HERO SECTION with Video Background -->
    <section class="relative overflow-hidden min-h-screen flex items-center" style="border-bottom: 1px solid rgba(241,81,83,0.25); background-color: #210f30; filter: none !important; opacity: 1 !important; mix-blend-mode: normal !important;">

        {{-- Full-screen Background Video -- Balanced Brightness & Optimized Loading --}}
        <video
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            class="absolute inset-0 w-full h-full object-cover z-0 pointer-events-none"
            style="filter: brightness(0.48) contrast(1.1) saturate(1.2);"
        >
            <source src="{{ asset('storage/videos/full-stack-laravel-architecture/home-page-background/background.mp4') }}" type="video/mp4">
        </video>

        {{-- Soft Overlay for Contrast & Video Visibility (Localized Left Gradient) --}}
        <div class="absolute inset-0 z-10 pointer-events-none" style="background: linear-gradient(90deg, rgba(10,4,18,0.82) 0%, rgba(10,4,18,0.62) 45%, rgba(10,4,18,0.15) 75%, transparent 100%);"></div>

        {{-- Hero Content Container -- Left Aligned, High Contrast & Fully Isolated --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative py-24 w-full hero-content" style="z-index: 30; opacity: 1 !important; filter: none !important; mix-blend-mode: normal !important; isolation: isolate;">
            <div class="max-w-3xl text-left flex flex-col items-start gap-6 hero-content" style="opacity: 1 !important; filter: none !important; mix-blend-mode: normal !important;">

                {{-- 1. Badge --}}
                <div class="hero-badge inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black tracking-[0.18em] uppercase"
                     style="background: rgba(241,81,83,0.25); border: 1.5px solid #f15153; color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; filter: none !important; mix-blend-mode: normal !important;">
                    <span class="w-2 h-2 rounded-full bg-[#f15153] animate-pulse"></span>
                    <span class="hero-text-white" style="font-weight: 800;">LEARN • BUILD • GET HIRED</span>
                </div>

                {{-- 2. Main Headline (100% Pure Bright White & Coral Red #ff4d50) --}}
                <h1 class="font-black tracking-tight"
                    style="font-size: clamp(2.5rem, 4.5vw, 4.25rem); line-height: 1.15; letter-spacing: -0.02em; opacity: 1 !important; filter: none !important; mix-blend-mode: normal !important;">
                    <span class="hero-text-white" style="font-weight: 900;">Build Skills.</span><br>
                    <span class="hero-text-accent" style="font-weight: 900;">Unlock Opportunities.</span>
                </h1>

                {{-- 3. Supporting Text (100% Opaque Pure White with Strong Dark Shadow) --}}
                <p class="hero-text-white font-semibold text-base sm:text-lg leading-relaxed max-w-[680px]"
                   style="line-height: 1.7;">
                    Learn in-demand skills, build real-world projects, and connect with career opportunities that move you forward.
                </p>

                {{-- 4. CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-center gap-4 pt-2 w-full sm:w-auto relative z-30">
                    <a href="{{ route('courses.index') }}"
                       class="w-full sm:w-auto px-8 py-4 rounded-2xl font-extrabold text-sm transition-all hover:scale-105 hover:brightness-110 text-center cursor-pointer"
                       style="background: #f15153; color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; box-shadow: 0 8px 30px rgba(241,81,83,0.45); text-decoration: none;">
                        🚀 &nbsp;Explore All Courses
                    </a>
                    <a href="{{ route('jobs.index') }}"
                       class="w-full sm:w-auto px-8 py-4 rounded-2xl font-extrabold text-sm transition-all hover:bg-white/20 text-center cursor-pointer"
                       style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.4); color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; backdrop-filter: blur(14px); text-decoration: none;">
                        Browse Job Openings →
                    </a>
                </div>

                {{-- 5. Metrics Bar --}}
                <div class="pt-8 mt-4 grid grid-cols-2 sm:grid-cols-4 gap-6 text-left w-full" style="border-top: 1px solid rgba(255,255,255,0.2);">
                    <div>
                        <div class="text-3xl sm:text-4xl font-black" style="color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                            {{ number_format(max(12500, $totalStudents * 50)) }}+
                        </div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider mt-1" style="color: #e5d8f6 !important; -webkit-text-fill-color: #e5d8f6 !important; opacity: 1 !important;">Active Students</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-black" style="color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                            {{ max(48, $totalCourses) }}+
                        </div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider mt-1" style="color: #e5d8f6 !important; -webkit-text-fill-color: #e5d8f6 !important; opacity: 1 !important;">Expert Courses</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-black" style="color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                            {{ max(120, $totalJobs) }}+
                        </div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider mt-1" style="color: #e5d8f6 !important; -webkit-text-fill-color: #e5d8f6 !important; opacity: 1 !important;">Job Openings</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-black" style="color: #ffffff !important; -webkit-text-fill-color: #ffffff !important; opacity: 1 !important; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">98%</div>
                        <div class="text-[11px] font-extrabold uppercase tracking-wider mt-1" style="color: #e5d8f6 !important; -webkit-text-fill-color: #e5d8f6 !important; opacity: 1 !important;">Placement Rate</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-6 right-12 z-20 hidden md:flex items-center gap-3 text-white/70 pointer-events-none">
            <span class="text-[10px] font-bold uppercase tracking-[0.25em]" style="color: #ffffff !important;">Scroll Down</span>
            <div class="w-5 h-8 rounded-full border border-white/40 flex items-start justify-center pt-1.5">
                <div class="w-1 h-2 rounded-full bg-white animate-bounce"></div>
            </div>
        </div>

    </section>

    <!-- 2. POPULAR COURSES SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Popular Courses</h2>
                <p class="text-xs mt-1" style="color: #a997be;">Explore our database courses curated for software engineers.</p>
            </div>
            <a href="{{ route('courses.index') }}" style="color: #f15153;" class="text-sm font-bold hover:underline flex items-center gap-1">
                <span>View All ➔</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($featuredCourses as $course)
                @php
                    $cTitle = is_object($course) ? ($course->title ?? '') : (is_array($course) ? ($course['title'] ?? '') : (string)$course);
                    $catName = is_object($course) ? ($course->category?->name ?? 'Software Engineering') : 'Software Engineering';
                    $lvl = is_object($course) ? ($course->currentVersion?->level ?? 'Intermediate') : 'Intermediate';
                    $priceVal = is_object($course) ? ($course->currentVersion?->price ?? 2999) : 2999;
                    $origPrice = $priceVal * 1.6;
                    $instructorName = is_object($course) ? ($course->trainer?->name ?? 'Senior Engineer') : 'Senior Engineer';
                @endphp
                <div class="rounded-2xl shadow-lg hover:-translate-y-1 transition-all overflow-hidden flex flex-col justify-between" style="background: #251237; border: 1px solid rgba(241,81,83,0.2);">
                    <div>
                        <div class="p-4 pb-2 flex items-center justify-between gap-2">
                            <span class="font-bold text-[10.5px] px-2.5 py-1 rounded-full" style="background: rgba(255,255,255,0.08); color: #e5d9f2;">
                                {{ $catName }}
                            </span>
                            <span class="font-bold text-[10.5px] px-2.5 py-1 rounded-full" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                                {{ $lvl }}
                            </span>
                        </div>

                        <div class="p-4 pt-2 flex flex-col gap-2.5">
                            <h3 class="text-sm font-extrabold text-white leading-snug min-h-[42px]">
                                {{ $cTitle }}
                            </h3>

                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full text-white font-extrabold text-[11px] flex items-center justify-center shrink-0" style="background: #f15153;">
                                    {{ strtoupper(substr($instructorName, 0, 1)) }}
                                </div>
                                <span class="text-xs font-semibold" style="color: #d4c5e2;">{{ $instructorName }}</span>
                            </div>

                            <div class="flex items-center gap-1.5 text-xs">
                                <span class="text-amber-400 font-extrabold">★ 4.8</span>
                                <span style="color: #8e7c9f;">(1,234)</span>
                            </div>

                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-lg font-black text-white">₹{{ number_format($priceVal) }}</span>
                                <span class="text-xs line-through" style="color: #8e7c9f;">₹{{ number_format($origPrice) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="{{ route('courses.show', $course->id) }}" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="w-full py-2.5 rounded-xl text-white font-extrabold text-xs hover:opacity-90 transition-opacity text-center block text-decoration-none">
                            Enroll Now ➔
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl p-12 col-span-full text-center text-xs" style="background: #251237; border: 1px solid rgba(241,81,83,0.2); color: #a997be;">
                    No active courses found in database.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 3. HOW IT WORKS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest" style="color: #f15153;">3 Simple Steps</span>
            <h2 class="text-3xl font-black text-white tracking-tight mt-1">How It Works</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Step 1 -->
            <div class="rounded-3xl text-center space-y-4 shadow-lg transition-all" style="background: #251237; border: 1px solid rgba(241,81,83,0.2); padding: 2rem !important;">
                <div class="w-16 h-16 rounded-full text-white flex items-center justify-center mx-auto" style="background: #f15153; box-shadow: 0 6px 20px rgba(241,81,83,0.35);">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                </div>
                <div class="font-extrabold text-xs px-3 py-1 rounded-full inline-block" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                    Step 1
                </div>
                <h3 class="text-lg font-black text-white">Choose Your Course</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">
                    Select from industry-designed software engineering courses built for real career growth.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="rounded-3xl text-center space-y-4 shadow-lg transition-all" style="background: #251237; border: 1px solid rgba(241,81,83,0.2); padding: 2rem !important;">
                <div class="w-16 h-16 rounded-full text-white flex items-center justify-center mx-auto" style="background: #f15153; box-shadow: 0 6px 20px rgba(241,81,83,0.35);">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div class="font-extrabold text-xs px-3 py-1 rounded-full inline-block" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                    Step 2
                </div>
                <h3 class="text-lg font-black text-white">Learn with Expert Trainers</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">
                    Master production code, architecture patterns, and live projects guided by senior engineers.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="rounded-3xl text-center space-y-4 shadow-lg transition-all" style="background: #251237; border: 1px solid rgba(241,81,83,0.2); padding: 2rem !important;">
                <div class="w-16 h-16 rounded-full text-white flex items-center justify-center mx-auto" style="background: #f15153; box-shadow: 0 6px 20px rgba(241,81,83,0.35);">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="font-extrabold text-xs px-3 py-1 rounded-full inline-block" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                    Step 3
                </div>
                <h3 class="text-lg font-black text-white">Get Placed in Top Companies</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">
                    Get direct referrals, resume reviews, and placement opportunities at leading tech companies.
                </p>
            </div>
        </div>
    </section>

    <!-- 4. RECENT JOB OPENINGS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl p-8 space-y-6 shadow-xl" style="background: #251237; border: 1px solid rgba(241,81,83,0.25);">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest" style="color: #f15153;">Career Opportunities</span>
                    <h3 class="text-2xl font-black text-white mt-1 flex items-center gap-2.5">
                        <svg class="w-6 h-6 shrink-0" style="color: #f15153; width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Latest Job Openings</span>
                    </h3>
                </div>
                <a href="{{ route('jobs.index') }}" style="color: #f15153;" class="text-xs font-black uppercase tracking-wider hover:underline flex items-center gap-1">
                    <span>View All Jobs</span>
                    <span>➔</span>
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($latestJobs as $idx => $j)
                    @php
                        $companyName = $j->company?->name ?? 'Tech Company';
                        $salaryText = ($j->salary_min && $j->salary_max) 
                            ? ('₹' . round($j->salary_min / 100000, 1) . 'L - ' . round($j->salary_max / 100000, 1) . 'L') 
                            : ($j->salary_range ?? 'Competitive Package');
                        $jobType = ucfirst($j->job_type ?? 'Full-time');
                        $workplace = ucfirst($j->workplace_type ?? 'Remote');
                    @endphp
                    <div class="rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-5 transition-all hover:border-[#f15153]" style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);">
                        
                        <div class="flex items-center gap-4">
                            <!-- Company Logo Badge -->
                            <div class="w-12 h-12 rounded-2xl text-white font-black text-lg flex items-center justify-center shrink-0 shadow-lg" style="background: linear-gradient(135deg, #f15153, #c92f31);">
                                {{ strtoupper(substr($companyName, 0, 1)) }}
                            </div>
                            
                            <div class="space-y-1">
                                <h4 class="text-base sm:text-lg font-black text-white tracking-tight leading-snug">{{ $j->title }}</h4>
                                <div class="text-xs flex items-center flex-wrap gap-4" style="color: #d4c5e2;">
                                    <span class="font-extrabold text-white">{{ $companyName }}</span>
                                    
                                    <span class="inline-flex items-center gap-1.5 font-medium">
                                        <svg class="shrink-0" style="color: #f15153; width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $j->location ?? 'India' }}
                                    </span>
                                    
                                    <span class="inline-flex items-center gap-1.5 font-medium">
                                        <svg class="shrink-0 text-emerald-400" style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-emerald-400 font-bold">{{ $salaryText }}</span>
                                    </span>
                                    
                                    <span class="inline-flex items-center gap-1.5 font-medium">
                                        <svg class="shrink-0 text-purple-300" style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                        {{ $j->experience_level ?? '1+ yrs' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0 self-start md:self-center">
                            <span class="font-extrabold text-[11px] px-3 py-1 rounded-full uppercase tracking-wider" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                                {{ $workplace }}
                            </span>
                            <span class="font-extrabold text-[11px] px-3 py-1 rounded-full uppercase tracking-wider" style="background: rgba(255,255,255,0.08); color: #d4c5e2;">
                                {{ $jobType }}
                            </span>
                            <a href="{{ route('jobs.show', $j->id) }}" style="background: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="font-black text-xs px-5 py-2.5 rounded-xl text-white hover:opacity-90 transition-all text-decoration-none shrink-0">
                                Apply Now ➔
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="p-8 text-center text-xs rounded-2xl" style="background: #1e0d2d; color: #a997be;">No active job postings available at this moment.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. TESTIMONIALS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest" style="color: #f15153;">Student Feedback</span>
            <h2 class="text-3xl font-black text-white tracking-tight mt-1">What Our Students Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($successStories as $s)
                <div class="rounded-3xl shadow-xl flex flex-col justify-between min-h-[260px] transition-all hover:border-[#f15153]" style="background: #251237; border: 1px solid rgba(241,81,83,0.25); padding: 2rem !important;">
                    <div class="space-y-4 mb-6">
                        <div class="text-base font-bold tracking-wider" style="color: #f59e0b !important;">★★★★★</div>
                        <p class="text-sm leading-relaxed italic font-medium" style="color: #ffffff !important; opacity: 0.95;">
                            "{{ $s->testimonial }}"
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-5 mt-auto" style="border-top: 1px solid rgba(255,255,255,0.12);">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl text-white font-black text-sm flex items-center justify-center shrink-0 shadow-md" style="background: linear-gradient(135deg, #f15153, #c92f31);">
                                {{ strtoupper(substr($s->student_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-extrabold" style="color: #ffffff !important;">{{ $s->student_name }}</div>
                                <div class="text-xs font-medium" style="color: #f15153 !important;">Placed at {{ $s->company_name }}</div>
                            </div>
                        </div>
                        <span class="font-black text-xs px-3 py-1.5 rounded-full shrink-0" style="background: rgba(16,185,129,0.2); color: #34d399 !important; border: 1px solid rgba(16,185,129,0.4);">
                            {{ $s->salary_package ?? 'Placed' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-xs p-8 rounded-2xl" style="background: #1e0d2d; color: #a997be;">No success stories available yet.</div>
            @endforelse
        </div>
    </section>

    <!-- 6. CTA SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="margin-top: 6rem !important; margin-bottom: 6rem !important;">
        <div class="rounded-3xl p-12 text-center shadow-2xl max-w-4xl mx-auto space-y-6" style="background: linear-gradient(135deg, #2e1642 0%, #1a0b27 100%); border: 1.5px solid rgba(241,81,83,0.35); box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Ready to Start Your Learning Journey?
            </h2>
            <p class="text-base sm:text-lg max-w-2xl mx-auto font-medium" style="color: #e5d8f6 !important;">
                Join 10,000+ students and get placed in your dream company with production-ready software engineering skills.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-3">
                <a href="{{ route('courses.index') }}" style="background-color: #f15153; box-shadow: 0 6px 20px rgba(241,81,83,0.45);" class="px-8 py-4 rounded-2xl text-white font-extrabold text-sm hover:opacity-90 transition-all text-decoration-none">
                    Browse Courses ➔
                </a>
                <a href="{{ route('jobs.index') }}" class="px-8 py-4 rounded-2xl text-white font-extrabold text-sm hover:bg-white/20 transition-all text-decoration-none" style="background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.35);">
                    View Jobs
                </a>
            </div>
        </div>
    </section>

    <!-- 7. FAQ PREVIEW -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" style="margin-top: 6rem !important; margin-bottom: 4rem !important;">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-white">Frequently Asked Questions</h2>
            <p class="text-xs sm:text-sm font-medium" style="color: #c4b0dc !important;">Got questions? We have answers.</p>
        </div>

        <div class="space-y-4" x-data="{ activeFaq: null }">
            @forelse ($faqs as $index => $faq)
                <div class="rounded-2xl overflow-hidden shadow-md transition-all hover:border-[#f15153]" style="background: #251237; border: 1px solid rgba(241,81,83,0.25);">
                    <button @click="activeFaq = activeFaq === {{ $index }} ? null : {{ $index }}" class="w-full p-5 text-left font-extrabold text-sm sm:text-base flex items-center justify-between" style="color: #ffffff !important;">
                        <span>{{ $faq->question }}</span>
                        <span class="font-black text-lg" style="color: #f15153 !important;" x-text="activeFaq === {{ $index }} ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === {{ $index }}" x-cloak class="p-5 pt-0 text-sm leading-relaxed font-medium" style="color: #e5d8f6 !important; border-top: 1px solid rgba(255,255,255,0.1);">
                        {{ $faq->answer }}
                    </div>
                </div>
            @empty
                <div class="text-center text-xs p-6 rounded-2xl" style="background: #1e0d2d; color: #a997be;">No FAQs available.</div>
            @endforelse
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('faq') }}" style="color: #f15153;" class="text-xs font-bold hover:underline">View All FAQs ➔</a>
        </div>
    </section>
</div>
