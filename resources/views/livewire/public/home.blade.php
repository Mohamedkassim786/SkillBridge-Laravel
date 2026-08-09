<div class="space-y-28 pb-28" style="background-color: #0B1F3A;">
    <!-- 1. HERO SECTION -->
    <section class="relative overflow-hidden" style="background: linear-gradient(180deg, #0B1F3A 0%, #081628 100%); padding-top: 70px; padding-bottom: 70px; border-bottom: 1px solid #1e3a5f;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto space-y-8">
                <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight" style="margin-top: 10px;">
                    {{ $heroHeadline }}
                </h1>

                <p class="text-base sm:text-xl text-slate-300 font-normal leading-relaxed max-w-3xl mx-auto">
                    {{ $heroSubheading }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('courses.index') }}" style="background-color: #D62828; font-weight: 800;" class="w-full sm:w-auto px-8 py-4 rounded-2xl hover:bg-red-700 text-white text-sm shadow-2xl transition-all text-center">
                        Explore All Courses ➔
                    </a>
                </div>

                <!-- Live Metrics Bar -->
                <div class="pt-12 grid grid-cols-2 md:grid-cols-4 gap-6 border-t border-slate-800/80 text-center max-w-3xl mx-auto">
                    <div>
                        <div class="text-3xl font-black text-white">{{ number_format(max(1000, $totalStudents * 50)) }}+</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Active Students</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white">{{ $totalCourses > 0 ? $totalCourses : 12 }}+</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Enterprise Modules</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white">{{ $totalJobs > 0 ? $totalJobs : 40 }}+</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Active Job Postings</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white">Verified</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase mt-1">Certifications</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. POPULAR COURSES SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top: 56px; padding-bottom: 56px;">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">Popular Courses</h2>
                <p class="text-xs text-slate-400 mt-1">Explore our database courses curated for software engineers.</p>
            </div>
            <a href="{{ route('courses.index') }}" style="color: #f87171;" class="text-sm font-bold hover:underline flex items-center gap-1">
                <span>View All ➔</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($featuredCourses as $course)
                @php
                    $priceVal = $course->currentVersion?->price ?? 2999;
                    $origPrice = $priceVal * 1.6;
                    $instructorName = $course->trainer?->name ?? 'John Doe';
                @endphp
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div>
                        <div style="padding: 16px 16px 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                            <span style="background: #1e3a5f; color: #60a5fa; font-weight: 700; font-size: 10.5px; padding: 4px 10px; border-radius: 20px;">
                                {{ $course->category?->name ?? 'Software Engineering' }}
                            </span>
                            <span style="background: rgba(214,40,40,0.18); color: #ff6b6b; font-weight: 700; font-size: 10.5px; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(214,40,40,0.3);">
                                {{ $course->currentVersion?->level ?? 'Intermediate' }}
                            </span>
                        </div>

                        <div style="padding: 8px 16px 12px; display: flex; flex-direction: column; gap: 10px;">
                            <h3 style="font-size: 15px; font-weight: 800; color: white; line-height: 1.4; margin: 0; min-height: 42px;">
                                {{ $course->title }}
                            </h3>

                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 11px; flex-shrink: 0;">
                                    {{ strtoupper(substr($instructorName, 0, 1)) }}
                                </div>
                                <span style="font-size: 12px; font-weight: 600; color: #cbd5e1;">{{ $instructorName }}</span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 6px; font-size: 12px;">
                                <span style="color: #f59e0b; font-weight: 800;">★ 4.8</span>
                                <span style="color: #94a3b8;">(1,234)</span>
                            </div>

                            <div style="display: flex; align-items: baseline; gap: 8px; margin-top: 2px;">
                                <span style="font-size: 18px; font-weight: 900; color: white;">₹{{ number_format($priceVal) }}</span>
                                <span style="font-size: 12.5px; color: #64748b; text-decoration: line-through;">₹{{ number_format($origPrice) }}</span>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 0 16px 16px;">
                        <a href="{{ route('courses.show', $course->id) }}" style="background: #D62828; color: white; font-weight: 800; font-size: 13px; padding: 10px; border-radius: 10px; text-align: center; text-decoration: none; display: block; box-shadow: 0 4px 14px rgba(214,40,40,0.35); transition: background 0.15s;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#D62828'">
                            Enroll Now ➔
                        </a>
                    </div>
                </div>
            @empty
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px; padding: 48px;" class="col-span-full text-center text-slate-400">
                    No active courses found in database.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 3. HOW IT WORKS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top: 56px; padding-bottom: 56px;">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-[#D62828] uppercase tracking-widest">3 Simple Steps</span>
            <h2 class="text-3xl font-black text-white tracking-tight mt-1">How It Works</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Step 1 -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 32px; text-align: center;" class="space-y-4 relative z-10">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 6px 20px rgba(214,40,40,0.35);">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                </div>
                <div style="background: #1e3a5f; color: #60a5fa; font-weight: 800; font-size: 11px; padding: 3px 12px; border-radius: 20px; display: inline-block;">
                    Step 1
                </div>
                <h3 class="text-lg font-black text-white">Choose Your Course</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Select from industry-designed software engineering courses built for real career growth.
                </p>
            </div>

            <!-- Step 2 -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 32px; text-align: center;" class="space-y-4 relative z-10">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 6px 20px rgba(214,40,40,0.35);">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 002-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div style="background: #1e3a5f; color: #60a5fa; font-weight: 800; font-size: 11px; padding: 3px 12px; border-radius: 20px; display: inline-block;">
                    Step 2
                </div>
                <h3 class="text-lg font-black text-white">Learn with Expert Trainers</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Master production code, architecture patterns, and live projects guided by senior engineers.
                </p>
            </div>

            <!-- Step 3 -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 32px; text-align: center;" class="space-y-4 relative z-10">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 6px 20px rgba(214,40,40,0.35);">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div style="background: #1e3a5f; color: #60a5fa; font-weight: 800; font-size: 11px; padding: 3px 12px; border-radius: 20px; display: inline-block;">
                    Step 3
                </div>
                <h3 class="text-lg font-black text-white">Get Placed in Top Companies</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Get direct referrals, resume reviews, and placement opportunities at leading tech companies.
                </p>
            </div>
        </div>
    </section>

    <!-- 4. RECENT JOB OPENINGS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top: 56px; padding-bottom: 56px;">
        <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-[#D62828] uppercase tracking-widest">Career Opportunities</span>
                    <h3 class="text-2xl font-black text-white mt-1 flex items-center gap-2">
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Latest Job Openings</span>
                    </h3>
                </div>
                <a href="{{ route('jobs.index') }}" style="color: #f87171;" class="text-xs font-bold hover:underline">View All Jobs ➔</a>
            </div>

            <div class="space-y-3">
                @forelse ($latestJobs as $idx => $j)
                    @php
                        $companyName = $j->company?->name ?? 'Tech Company';
                        $salaryText = ($j->salary_min && $j->salary_max) 
                            ? ('₹' . round($j->salary_min / 100000, 1) . 'L - ' . round($j->salary_max / 100000, 1) . 'L') 
                            : ($j->salary_range ?? 'Competitive Package');
                        $jobType = ucfirst($j->job_type ?? 'Full-time');
                        $workplace = ucfirst($j->workplace_type ?? 'Remote');
                    @endphp
                    <div style="background: {{ $idx % 2 == 0 ? '#0b192c' : '#081628' }}; border: 1px solid #1e3a5f; border-radius: 14px; padding: 16px 20px;" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- Company Logo Badge -->
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: #1e3a5f; color: white; font-weight: 900; font-size: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                {{ strtoupper(substr($companyName, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size: 15px; font-weight: 800; color: white;">{{ $j->title }}</div>
                                <div style="font-size: 12px; color: #94a3b8; margin-top: 2px; display: flex; align-items: center; flex-wrap: wrap; gap: 12px;">
                                    <strong style="color: #cbd5e1;">{{ $companyName }}</strong>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $j->location ?? 'India' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $salaryText }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                        {{ $j->experience_level ?? '1+ yrs' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span style="background: rgba(96,165,250,0.1); color: #60a5fa; border: 1px solid rgba(96,165,250,0.2); font-weight: 700; font-size: 10.5px; padding: 3px 10px; border-radius: 20px;">
                                {{ $workplace }}
                            </span>
                            <span style="background: rgba(96,165,250,0.1); color: #60a5fa; border: 1px solid rgba(96,165,250,0.2); font-weight: 700; font-size: 10.5px; padding: 3px 10px; border-radius: 20px;">
                                {{ $jobType }}
                            </span>
                            <a href="{{ route('jobs.show', $j->id) }}" style="background: transparent; border: 1px solid #1e3a5f; color: white; font-weight: 700; font-size: 12px; padding: 8px 16px; border-radius: 10px; text-decoration: none;" onmouseover="this.style.background='#D62828'; this.style.borderColor='#D62828';" onmouseout="this.style.background='transparent'; this.style.borderColor='#1e3a5f';">
                                Apply Now ➔
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">No active job postings available at this moment.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. TESTIMONIALS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top: 56px; padding-bottom: 56px;">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-[#D62828] uppercase tracking-widest">Student Feedback</span>
            <h2 class="text-3xl font-black text-white tracking-tight mt-1">What Our Students Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($successStories as $s)
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.25);" class="flex flex-col justify-between space-y-4 text-white">
                    <div class="space-y-3">
                        <div style="color: #f59e0b; font-size: 16px;">★★★★★</div>
                        <p style="font-size: 13px; color: #cbd5e1; line-height: 1.6; font-style: italic;">
                            "{{ $s->testimonial }}"
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid #1e3a5f;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center;">
                                {{ strtoupper(substr($s->student_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size: 13.5px; font-weight: 800; color: white;">{{ $s->student_name }}</div>
                                <div style="font-size: 11px; color: #94a3b8;">Placed at {{ $s->company_name }}</div>
                            </div>
                        </div>
                        <span style="background: rgba(16,185,129,0.15); color: #34d399; font-weight: 800; font-size: 10.5px; padding: 3px 10px; border-radius: 20px; border: 1px solid rgba(16,185,129,0.3);">
                            {{ $s->salary_package ?? 'Placed' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-xs text-slate-400 p-6">No success stories available yet.</div>
            @endforelse
        </div>
    </section>

    <!-- 6. CTA SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top: 56px; padding-bottom: 56px;">
        <div style="background: linear-gradient(135deg, #112240 0%, #081628 100%); border: 1px solid #1e3a5f; border-radius: 28px; padding: 48px 32px; text-align: center; box-shadow: 0 12px 40px rgba(0,0,0,0.4);" class="space-y-6 max-w-4xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Ready to Start Your Learning Journey?
            </h2>
            <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto">
                Join 10,000+ students and get placed in your dream company with production-ready software engineering skills.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('courses.index') }}" style="background: #D62828; color: white; font-weight: 800; font-size: 14px; padding: 12px 28px; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 16px rgba(214,40,40,0.4);">
                    Browse Courses ➔
                </a>
                <a href="{{ route('jobs.index') }}" style="background: transparent; border: 1px solid #334155; color: white; font-weight: 700; font-size: 14px; padding: 12px 28px; border-radius: 12px; text-decoration: none;" onmouseover="this.style.background='rgba(255,255,255,0.07)';" onmouseout="this.style.background='transparent';">
                    View Jobs
                </a>
            </div>
        </div>
    </section>

    <!-- 7. FAQ PREVIEW -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" style="padding-top: 56px; padding-bottom: 56px;">
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-black text-white">Frequently Asked Questions</h2>
            <p class="text-xs text-slate-400">Got questions? We have answers.</p>
        </div>

        <div class="space-y-3" x-data="{ activeFaq: null }">
            @forelse ($faqs as $index => $faq)
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px;" class="overflow-hidden">
                    <button @click="activeFaq = activeFaq === {{ $index }} ? null : {{ $index }}" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-white flex items-center justify-between">
                        <span>{{ $faq->question }}</span>
                        <span class="text-rose-400 font-black" x-text="activeFaq === {{ $index }} ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === {{ $index }}" x-cloak class="p-4 pt-0 text-xs text-slate-300 leading-relaxed border-t border-slate-800">
                        {{ $faq->answer }}
                    </div>
                </div>
            @empty
                <div class="text-center text-xs text-slate-500">No FAQs available.</div>
            @endforelse
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('faq') }}" class="text-xs font-bold text-rose-400 hover:underline">View All FAQs ➔</a>
        </div>
    </section>
</div>
