<div class="min-h-screen pb-24" style="background-color: #321847; color: #d4c5e2;">

    <style>
        .job-detail-layout {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        @media (min-width: 1024px) {
            .job-detail-layout {
                display: grid;
                grid-template-columns: 1fr 340px;
                gap: 36px;
                align-items: start;
            }
        }
    </style>

    <!-- HEADER / BREADCRUMB SECTION -->
    <div style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25); padding: 24px 0 28px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-purple-300 mb-3">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-purple-400">></span>
                <a href="{{ route('jobs.index') }}" class="hover:text-white transition-colors">Jobs</a>
                <span class="text-purple-400">></span>
                <span style="color: #d4c5e2;">{{ $job->title }}</span>
                <span class="text-purple-400">></span>
                <span class="text-[#f15153] font-bold">{{ $job->company?->name ?? 'TCS' }}</span>
            </nav>

            <div class="max-w-4xl space-y-4">
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                    {{ $job->title }}
                </h1>

                <!-- Company Info Row -->
                <div class="flex flex-wrap items-center gap-5 pt-1">
                    <div class="flex items-center gap-3">
                        <div style="width: 54px; height: 54px; border-radius: 14px; background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white; font-weight: 900; font-size: 22px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3);" class="shrink-0">
                            {{ strtoupper(substr($job->company?->name ?? 'TCS', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-white">{{ $job->company?->name ?? 'TCS' }}</div>
                            <div class="text-xs text-amber-400 font-bold">4.2 ★★★★☆ <span class="font-normal ml-1" style="color: #a997be;">(1,234 reviews)</span></div>
                        </div>
                    </div>

                    <button style="background: transparent; border: 1px solid rgba(241,81,83,0.3); color: white;" class="px-4 py-2 rounded-xl text-xs font-bold hover:bg-white/10 transition-all">
                        + Follow Company
                    </button>
                </div>

                <!-- Job Meta Info Bar (Horizontal with SVG Icons) -->
                <div class="flex flex-wrap items-center gap-5 pt-3 text-xs text-purple-200 border-t border-purple-800/40">
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> {{ $job->location ?? 'Chennai, Tamil Nadu' }}</span>
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> 2+ years experience</span>
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> <strong class="text-white">₹5L - ₹8L per annum</strong></span>
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Full-time</span>
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> Onsite</span>
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Posted 2 days ago</span>
                    <span class="flex items-center gap-1.5"><svg style="width: 13.5px; height: 13.5px;" class="text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Apply by: 30 August 2026</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT TWO COLUMNS -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="job-detail-layout">

            <!-- LEFT COLUMN (65% Width) -->
            <div class="space-y-10">

                @if (session()->has('status'))
                    <div style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399;" class="p-4 rounded-2xl text-xs font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- 1. JOB DESCRIPTION -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">About the Role</h2>
                    <div class="text-xs leading-relaxed space-y-4" style="color: #d4c5e2;">
                        <p>
                            Tata Consultancy Services (TCS) is hiring a talented <strong>Laravel Developer</strong> to join our high-performing Enterprise Software Engineering team in Chennai. In this role, you will be responsible for building, optimizing, and maintaining mission-critical backend web applications, REST APIs, and microservices that power enterprise clients globally.
                        </p>
                        <p>
                            You will work closely with senior software architects, database administrators, and frontend engineers (React / Livewire) to design scalable database schemas, implement token authentication, write unit tests, and deploy applications using modern CI/CD pipelines. If you have a passion for clean PHP 8.3 code, modern Laravel architecture, and robust problem-solving, we would love to hear from you.
                        </p>
                    </div>
                </div>

                <!-- 2. KEY RESPONSIBILITIES -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">Key Responsibilities</h2>
                    <div class="space-y-2.5 text-xs" style="color: #d4c5e2;">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Develop and maintain scalable web applications using Laravel 12 and PHP 8.3</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Write clean, well-tested, and efficient backend code adhering to PSR standards</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Design and implement high-performance RESTful APIs for mobile and frontend integration</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Optimize MySQL database schemas, complex SQL queries, and Eloquent relationships</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Collaborate with frontend engineers (React / Livewire) to deliver responsive interfaces</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Participate in peer code reviews, sprint planning, and architectural discussions</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Troubleshoot, debug, and resolve technical issues in production environments</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Stay updated with modern Laravel ecosystem developments and security best practices</span>
                        </div>
                    </div>
                </div>

                <!-- 3. REQUIREMENTS -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">Requirements</h2>
                    <div class="space-y-2.5 text-xs" style="color: #d4c5e2;">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>2+ years of professional hands-on software development experience with Laravel</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Strong command of PHP 8.3, object-oriented programming (OOP), and MySQL design</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Demonstrated experience building RESTful APIs and API authentication (Sanctum/OAuth)</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Familiarity with modern frontend libraries (Livewire 3, React, or Vue.js)</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Practical understanding of Git version control, Docker containers, and CI/CD pipelines</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Excellent problem-solving skills and communication skills</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#f15153] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Bachelor's degree in Computer Science, Information Technology, or equivalent</span>
                        </div>
                    </div>
                </div>

                <!-- 4. PREFERRED SKILLS -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">Preferred Skills</h2>
                    <div class="space-y-2.5 text-xs" style="color: #d4c5e2;">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-purple-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Experience building reactive single-page applications with Livewire 3</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-purple-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Working knowledge of Redis caching, Horizon queues, and Elasticsearch</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-purple-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Cloud deployment familiarity with AWS (EC2, S3, RDS) or Azure</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-purple-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Experience working in Agile / Scrum development environments</span>
                        </div>
                    </div>
                </div>

                <!-- 5. BENEFITS -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-4">
                    <h2 class="text-2xl font-black text-white">Benefits</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs" style="color: #d4c5e2;">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span>Health & Medical Insurance</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Competitive Industry Salary</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Learning & Development Budget</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            <span>Flexible Paid Vacation Leave</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Work From Home Options</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Annual Performance Bonuses</span>
                        </div>
                    </div>
                </div>

                <!-- 6. ABOUT THE COMPANY -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-6">
                    <h2 class="text-2xl font-black text-white">About the Company</h2>
                    <div class="flex flex-col sm:flex-row items-start gap-6">
                        <div style="width: 80px; height: 80px; border-radius: 20px; background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white; font-weight: 900; font-size: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(0,0,0,0.3);" class="shrink-0">
                            {{ strtoupper(substr($job->company?->name ?? 'TCS', 0, 1)) }}
                        </div>
                        <div class="space-y-3 flex-1">
                            <div>
                                <h3 class="text-xl font-extrabold text-white">{{ $job->company?->name ?? 'TCS' }}</h3>
                                <div class="text-xs" style="color: #a997be;">Tata Consultancy Services • IT Services & Consulting</div>
                            </div>
                            <p class="text-xs leading-relaxed" style="color: #d4c5e2;">
                                Tata Consultancy Services is a global leader in IT services, consulting, and business solutions. Operating in over 55 countries with over 500,000 employees worldwide, TCS powers digital transformation for global enterprises.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2 text-xs border-t border-purple-800/40">
                                <div><span class="block text-[10.5px]" style="color: #a997be;">Company Size</span><strong class="text-white font-bold">10,000+ employees</strong></div>
                                <div><span class="block text-[10.5px]" style="color: #a997be;">Industry</span><strong class="text-white font-bold">IT Services</strong></div>
                                <div><span class="block text-[10.5px]" style="color: #a997be;">Founded</span><strong class="text-white font-bold">1968</strong></div>
                                <div><span class="block text-[10.5px]" style="color: #a997be;">Website</span><a href="https://www.tcs.com" target="_blank" style="color: #f15153;" class="font-bold hover:underline">www.tcs.com</a></div>
                            </div>

                            <div class="pt-2">
                                <a href="{{ route('jobs.index') }}" style="color: #f15153;" class="text-xs font-bold hover:underline">View all jobs by this company ➔</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. REVIEWS -->
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;" class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-black text-white">Employee Reviews</h2>
                        <div class="text-amber-400 text-sm font-bold">4.2 ★★★★☆ <span class="font-normal text-xs ml-1" style="color: #a997be;">(1,234 reviews)</span></div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px;" class="space-y-2.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #f15153; color: white; font-weight: 800; display: flex; align-items: center; justify-content: center;">
                                        R
                                    </div>
                                    <div>
                                        <div class="font-bold text-white">Rajesh K.</div>
                                        <div class="text-[11px]" style="color: #a997be;">Senior Developer • <span class="text-amber-400">★★★★☆</span> • 1 month ago</div>
                                    </div>
                                </div>
                                <button style="background: rgba(255,255,255,0.08); color: #d4c5e2;" class="px-3 py-1 rounded-lg text-xs font-semibold flex items-center gap-1 hover:bg-white/15">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                    Helpful (89)
                                </button>
                            </div>
                            <p class="leading-relaxed italic" style="color: #d4c5e2;">
                                "Great company to work for. Good learning opportunities, enterprise projects, and supportive engineering leadership."
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (35% Width Sticky Sidebar) -->
            <div style="position: sticky; top: 90px; z-index: 10;">
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 28px; box-shadow: 0 12px 36px rgba(0,0,0,0.35);" class="space-y-6 text-center">

                    <!-- Large Company Logo Badge -->
                    <div style="width: 90px; height: 90px; border-radius: 24px; background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white; font-weight: 900; font-size: 36px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
                        {{ strtoupper(substr($job->company?->name ?? 'TCS', 0, 1)) }}
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-xl font-extrabold text-white">{{ $job->company?->name ?? 'TCS' }}</h3>
                        <div class="text-xs text-amber-400 font-bold">4.2 ★★★★☆ <span class="font-normal" style="color: #a997be;">(1,234 reviews)</span></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-2">
                        @if ($applied)
                            <div style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399;" class="w-full py-3.5 rounded-xl font-extrabold text-xs text-center flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Application Submitted!
                            </div>
                        @else
                            <button wire:click="apply" style="background: #f15153; color: white; box-shadow: 0 4px 16px rgba(241,81,83,0.4);" class="w-full py-3.5 rounded-xl font-extrabold text-sm hover:opacity-90 transition-all text-center block">
                                Apply Now ➔
                            </button>
                        @endif

                        <div class="grid grid-cols-2 gap-2">
                            <button style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white;" class="py-2.5 rounded-xl font-bold text-xs hover:bg-white/15 transition-all flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                Save Job
                            </button>
                            <button style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white;" class="py-2.5 rounded-xl font-bold text-xs hover:bg-white/15 transition-all flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                Share
                            </button>
                        </div>
                    </div>

                    <!-- Job Overview Box -->
                    <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 16px;" class="space-y-3 text-left text-xs">
                        <h4 class="font-extrabold text-white text-xs uppercase tracking-wider mb-3">Job Overview</h4>
                        <div class="flex justify-between border-b border-purple-800/40 pb-2">
                            <span style="color: #a997be;">Employment Type</span>
                            <strong class="text-white">Full-time</strong>
                        </div>
                        <div class="flex justify-between border-b border-purple-800/40 pb-2">
                            <span style="color: #a997be;">Experience</span>
                            <strong class="text-white">2+ years</strong>
                        </div>
                        <div class="flex justify-between border-b border-purple-800/40 pb-2">
                            <span style="color: #a997be;">Salary</span>
                            <strong class="text-emerald-400">₹5L - ₹8L</strong>
                        </div>
                        <div class="flex justify-between border-b border-purple-800/40 pb-2">
                            <span style="color: #a997be;">Location</span>
                            <strong class="text-white">Chennai</strong>
                        </div>
                        <div class="flex justify-between border-b border-purple-800/40 pb-2">
                            <span style="color: #a997be;">Work Mode</span>
                            <strong class="text-white">Onsite</strong>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: #a997be;">Deadline</span>
                            <strong class="text-[#f15153]">30 Aug 2026</strong>
                        </div>
                    </div>

                    <!-- Report Job -->
                    <div class="pt-2">
                        <a href="#" class="text-[11px] hover:text-[#f15153] transition-colors" style="color: #a997be;">Report this job posting</a>
                    </div>

                </div>
            </div>

        </div>

        <!-- HOW TO APPLY SECTION (Full Width) -->
        <div style="background: linear-gradient(135deg, #251237 0%, #210f30 100%); border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 40px 32px; margin-top: 64px;" class="space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <span class="text-xs font-bold text-[#f15153] uppercase tracking-widest">Application Guide</span>
                <h2 class="text-3xl font-black text-white">How to Apply</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 text-center">
                <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px;" class="space-y-2">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f15153; color: white;" class="font-black text-xs flex items-center justify-center mx-auto">1</div>
                    <div class="text-xs font-bold text-white">Click Apply</div>
                    <div class="text-[11px]" style="color: #a997be;">Click the "Apply Now" button</div>
                </div>

                <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px;" class="space-y-2">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f15153; color: white;" class="font-black text-xs flex items-center justify-center mx-auto">2</div>
                    <div class="text-xs font-bold text-white">Upload Resume</div>
                    <div class="text-[11px]" style="color: #a997be;">Upload PDF or DOCX file</div>
                </div>

                <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px;" class="space-y-2">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f15153; color: white;" class="font-black text-xs flex items-center justify-center mx-auto">3</div>
                    <div class="text-xs font-bold text-white">Cover Letter</div>
                    <div class="text-[11px]" style="color: #a997be;">AI cover letter generator available</div>
                </div>

                <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px;" class="space-y-2">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f15153; color: white;" class="font-black text-xs flex items-center justify-center mx-auto">4</div>
                    <div class="text-xs font-bold text-white">Submit App</div>
                    <div class="text-[11px]" style="color: #a997be;">Instant application submission</div>
                </div>

                <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px;" class="space-y-2">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f15153; color: white;" class="font-black text-xs flex items-center justify-center mx-auto">5</div>
                    <div class="text-xs font-bold text-white">Track Status</div>
                    <div class="text-[11px]" style="color: #a997be;">Track directly in dashboard</div>
                </div>
            </div>
        </div>

        <!-- SIMILAR JOBS SECTION (4 Cards Row) -->
        <div class="mt-16 pt-10 border-t border-purple-800/40 space-y-8">
            <h2 class="text-2xl font-black text-white">Similar Jobs</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($similarJobs as $sim)
                    <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;" class="space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div style="width: 40px; height: 40px; border-radius: 12px; background: #1e0d2d; color: white; font-weight: 800; font-size: 16px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(241,81,83,0.25);">
                                    {{ strtoupper(substr($sim->company?->name ?? 'T', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-white">{{ $sim->company?->name ?? 'TCS' }}</div>
                                    <div class="text-[11px]" style="color: #a997be;">{{ $sim->location ?? 'Chennai' }}</div>
                                </div>
                            </div>
                            <h4 class="text-sm font-extrabold text-white line-clamp-2">{{ $sim->title }}</h4>
                            <div class="text-xs font-bold text-emerald-400">₹5L - ₹8L per annum</div>
                        </div>

                        <a href="{{ route('jobs.show', $sim->id) }}" style="background: #f15153; color: white;" class="w-full py-2 rounded-xl text-xs font-extrabold text-center block hover:opacity-90 transition-all">
                            View Job Details ➔
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-xs text-center py-4" style="color: #a997be;">No similar jobs found.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
