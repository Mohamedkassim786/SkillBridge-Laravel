<div class="min-h-screen pb-24" style="background-color: #321847; color: #d4c5e2;">

    <!-- TOP HERO SECTION -->
    <div
        style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25); padding: 24px 0 32px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-purple-300 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-purple-400">></span>
                <span class="text-[#f15153] font-bold">About Us</span>
            </nav>

            <div class="text-center max-w-3xl mx-auto space-y-4">
                <h1 class="text-4xl font-black text-white tracking-tight">About SkillBridge</h1>
                <p class="text-sm sm:text-base leading-relaxed" style="color: #d4c5e2;">
                    Empowering students with in-demand software engineering skills and connecting them with top hiring
                    companies since 2020.
                </p>
            </div>
        </div>
    </div>

    <!-- SECTION 1: OUR MISSION & VISION (Two-Column Layout) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: Mission -->
            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;"
                class="space-y-4">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(241,81,83,0.15); border: 1px solid rgba(241,81,83,0.3); color: #f15153;"
                    class="flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-white">Our Mission</h2>
                <p class="text-xs sm:text-sm leading-relaxed" style="color: #d4c5e2;">
                    To provide affordable, high-quality technical education to everyone and help them secure rewarding,
                    high-growth careers in the software engineering industry.
                </p>
            </div>

            <!-- Right Column: Vision -->
            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 32px;"
                class="space-y-4">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(192,132,252,0.15); border: 1px solid rgba(192,132,252,0.3); color: #c084fc;"
                    class="flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-white">Our Vision</h2>
                <p class="text-xs sm:text-sm leading-relaxed" style="color: #d4c5e2;">
                    To become India's most trusted learning and placement platform, seamlessly bridging the gap between
                    computer science education and real-world enterprise employment.
                </p>
            </div>
        </div>
    </div>



    <!-- SECTION 3: OUR CORE VALUES (4 Cards in a Row) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold text-[#f15153] uppercase tracking-widest">Guiding Principles</span>
            <h2 class="text-3xl font-black text-white">Our Core Values</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 28px;"
                class="space-y-3 text-center">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(245,158,11,0.15); color: #f59e0b;"
                    class="flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-white">Quality</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">We deliver top-quality software architecture content
                    and hands-on training.</p>
            </div>

            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 28px;"
                class="space-y-3 text-center">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(16,185,129,0.15); color: #34d399;"
                    class="flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-white">Integrity</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">Honesty, transparency, and authentic code standards in
                    everything we do.</p>
            </div>

            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 28px;"
                class="space-y-3 text-center">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(192,132,252,0.15); color: #c084fc;"
                    class="flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 01-2 2h-4a2 2 0 01-2-2v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-white">Innovation</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">Constantly evolving with latest tech stacks like
                    Laravel 12, Livewire 3 & AI.</p>
            </div>

            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 28px;"
                class="space-y-3 text-center">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(241,81,83,0.15); color: #f15153;"
                    class="flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-white">Support</h3>
                <p class="text-xs leading-relaxed" style="color: #a997be;">Dedicated mentorship and career support for students
                    and hiring partners.</p>
            </div>
        </div>
    </div>

    <!-- SECTION 4: MEET OUR TEAM (2 Rows x 3 Columns) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-purple-800/40 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold text-[#f15153] uppercase tracking-widest">Leadership</span>
            <h2 class="text-3xl font-black text-white">Meet Our Team</h2>
        </div>

        @php
            $teamMembers = [
                ['name' => 'John Doe', 'role' => 'Founder & CEO', 'bio' => '15+ years in EdTech & Enterprise Software. Ex-TCS Lead Architect.'],
                ['name' => 'Priya Sharma', 'role' => 'Head of Curriculum', 'bio' => 'Ex-Infosys Senior PHP Architect. Author of 12 software engineering books.'],
                ['name' => 'Marcus Vance', 'role' => 'Principal Architect', 'bio' => 'Specializes in high-throughput Redis queues, Laravel 12 & microservices.'],
                ['name' => 'Rajesh Kumar', 'role' => 'VP of Engineering', 'bio' => '12+ years in cloud infrastructure, Docker containerization & CI/CD pipelines.'],
                ['name' => 'Ananya Roy', 'role' => 'Lead AI Researcher', 'bio' => 'Pioneer in AI-assisted code review and automated placement assessment.'],
                ['name' => 'David Miller', 'role' => 'Head of Placements', 'bio' => 'Connected 5,000+ engineering graduates with top technology companies.'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($teamMembers as $m)
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 28px; text-align: center;"
                    class="space-y-3">
                    <div
                        style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #f15153, #ff7b7d); color: white; font-weight: 800; font-size: 15px; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 4px 10px rgba(241,81,83,0.3);"
                        class="shrink-0">
                        {{ strtoupper(substr($m['name'], 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-white">{{ $m['name'] }}</h4>
                        <div class="text-xs text-[#f15153] font-semibold mt-0.5">{{ $m['role'] }}</div>
                    </div>
                    <p class="text-xs leading-relaxed" style="color: #a997be;">{{ $m['bio'] }}</p>
                    <div class="flex items-center justify-center gap-3 pt-1">
                        <a href="#" style="color: #c084fc;" class="text-xs font-bold hover:underline">LinkedIn</a>
                        <a href="#" style="color: #f15153;" class="text-xs font-bold hover:underline">Twitter</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- SECTION 5: STATISTICS BAR -->
    <div
        style="background: linear-gradient(135deg, #251237 0%, #210f30 100%); border-y: 1px solid rgba(241,81,83,0.25); padding: 48px 0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-1">
                <div class="text-4xl sm:text-5xl font-black text-white">50,000+</div>
                <div class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">Active Students</div>
            </div>
            <div class="space-y-1">
                <div class="text-4xl sm:text-5xl font-black text-[#f15153]">500+</div>
                <div class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">Software Courses</div>
            </div>
            <div class="space-y-1">
                <div class="text-4xl sm:text-5xl font-black text-purple-300">2,000+</div>
                <div class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">Job Openings</div>
            </div>
            <div class="space-y-1">
                <div class="text-4xl sm:text-5xl font-black text-emerald-400">5,000+</div>
                <div class="text-xs font-bold uppercase tracking-wider" style="color: #a997be;">Successful Placements</div>
            </div>
        </div>
    </div>

    <!-- SECTION 6: SUCCESS STORIES (3 Testimonial Cards) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold text-[#f15153] uppercase tracking-widest">Student Outcomes</span>
            <h2 class="text-3xl font-black text-white">Our Students' Success Stories</h2>
        </div>

        @php
            $aboutTestimonials = [
                ['name' => 'Priya S.', 'company' => 'Infosys', 'role' => 'Laravel Developer', 'course' => 'Laravel 12 Course', 'quote' => 'I got placed at Infosys with 8 LPA package after completing the Laravel course. The training and placement support was excellent!'],
                ['name' => 'Rahul M.', 'company' => 'TCS', 'role' => 'Senior Developer', 'course' => 'Full-Stack Architecture', 'quote' => 'The production architecture and repository pattern modules gave me the confidence to crack senior technical interview rounds easily.'],
                ['name' => 'Kavitha R.', 'company' => 'Zoho', 'role' => 'Backend Engineer', 'course' => 'Redis & Microservices', 'quote' => 'Real code, zero fake projects. Learning Redis queues and microservices directly helped me land a backend role at Zoho.'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($aboutTestimonials as $t)
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 28px;"
                    class="flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="text-amber-400 text-sm">★★★★★</div>
                        <p class="text-xs italic leading-relaxed" style="color: #d4c5e2;">
                            "{{ $t['quote'] }}"
                        </p>
                    </div>

                    <div style="border-top: 1px solid rgba(241,81,83,0.2);" class="pt-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #f15153, #ff7b7d); color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center;">
                                {{ strtoupper(substr($t['name'], 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">{{ $t['name'] }}</div>
                                <div class="text-[11px]" style="color: #a997be;">{{ $t['role'] }} @
                                    <strong>{{ $t['company'] }}</strong></div>
                            </div>
                        </div>
                        <span
                            style="background: rgba(16,185,129,0.15); color: #34d399; font-weight: 800; font-size: 10px; padding: 2px 8px; border-radius: 20px;">
                            {{ $t['course'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- SECTION 7: OUR PARTNERS (12 Company Logos Grid) -->
    <div style="background: #1e0d2d; border-y: 1px solid rgba(241,81,83,0.25); padding: 56px 0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-center">
            <div class="space-y-2">
                <span class="text-xs font-bold text-[#f15153] uppercase tracking-widest">Hiring Network</span>
                <h2 class="text-3xl font-black text-white">Companies That Hire Our Students</h2>
            </div>

            @php
                $partnerLogos = ['TCS', 'Infosys', 'Wipro', 'Amazon', 'Microsoft', 'Google', 'Zoho', 'Freshworks', 'Cognizant', 'Tech Mahindra', 'HCL', 'Accenture'];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 max-w-5xl mx-auto">
                @foreach ($partnerLogos as $pName)
                    <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 14px; padding: 16px;"
                        class="flex items-center justify-center font-extrabold text-sm text-purple-200 hover:text-white hover:border-[#f15153] transition-all cursor-pointer">
                        {{ $pName }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- SECTION 8: BOTTOM CTA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">
        <div style="background: linear-gradient(135deg, #251237 0%, #210f30 100%); border: 1px solid rgba(241,81,83,0.25); border-radius: 28px; padding: 48px 32px; text-align: center; box-shadow: 0 12px 40px rgba(0,0,0,0.4);"
            class="space-y-6 max-w-4xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Ready to Start Your Learning Journey?
            </h2>
            <p class="text-xs sm:text-sm max-w-xl mx-auto leading-relaxed" style="color: #d4c5e2;">
                Join 50,000+ students and get placed in your dream company with production-ready software engineering
                skills.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('courses.index') }}"
                    style="background: #f15153; color: white; font-weight: 800; font-size: 13px; padding: 12px 28px; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 16px rgba(241,81,83,0.4);" class="hover:opacity-90 transition-all">
                    Browse Courses ➔
                </a>
                <a href="{{ route('jobs.index') }}"
                    style="background: transparent; border: 1px solid rgba(255,255,255,0.15); color: white; font-weight: 700; font-size: 13px; padding: 12px 28px; border-radius: 12px; text-decoration: none;"
                    onmouseover="this.style.background='rgba(255,255,255,0.07)';"
                    onmouseout="this.style.background='transparent';">
                    View Jobs
                </a>
            </div>
        </div>
    </div>

</div>