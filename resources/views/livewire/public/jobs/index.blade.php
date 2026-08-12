<div class="min-h-screen pb-24" style="background-color: #321847; color: #d4c5e2;">

    <!-- TOP HERO SECTION -->
    <div style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25); padding: 24px 0 28px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-purple-300 mb-3">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-purple-400">></span>
                <span class="text-[#f15153] font-bold">Jobs</span>
            </nav>

            <div class="text-center max-w-3xl mx-auto space-y-4">
                <h1 class="text-4xl font-black text-white tracking-tight">Find Your Dream Job</h1>
                <p class="text-sm" style="color: #d4c5e2;">
                    2,000+ software engineering jobs from top companies actively hiring certified graduates.
                </p>

                <!-- Centered Large Search Bar (600px) -->
                <div class="max-w-2xl mx-auto pt-2">
                    <form onsubmit="event.preventDefault();" class="flex flex-col sm:flex-row items-center gap-2" style="background: #251237; border: 1px solid rgba(241,81,83,0.25); border-radius: 16px; padding: 6px 8px;">
                        <div class="relative flex-1 w-full" style="display: flex; align-items: center;">
                            <svg style="width: 15px; height: 15px; color: #a997be; position: absolute; left: 14px; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by job title, company, or skills..." style="background: transparent; border: none; color: white; padding-left: 40px; padding-right: 16px; padding-top: 10px; padding-bottom: 10px; font-size: 13px; width: 100%; outline: none;">
                        </div>
                        <button type="submit" style="background: #f15153; color: white; box-shadow: 0 4px 14px rgba(241,81,83,0.4);" class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-extrabold text-xs hover:opacity-90 transition-all shrink-0">
                            Search Jobs
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA (Full Width) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        <!-- Control Bar: Results Counter & Sort Dropdown -->
        <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 16px; padding: 14px 24px;" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <p class="text-xs font-medium" style="color: #d4c5e2;">
                Showing <strong class="text-white font-bold">{{ $jobs->firstItem() ?? 1 }}-{{ $jobs->lastItem() ?? count($jobs) }}</strong> of <strong class="text-white font-bold">{{ $jobs->total() ?? 2145 }}</strong> jobs
            </p>

            <div class="flex items-center gap-2 text-xs">
                <span class="font-semibold whitespace-nowrap" style="color: #a997be;">Sort by:</span>
                <select wire:model.live="sort" style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.12); color: white;" class="px-3 py-1.5 rounded-xl text-xs focus:outline-none focus:border-[#f15153]">
                    <option value="newest">Newest</option>
                    <option value="relevance">Relevance</option>
                    <option value="salary_high">Salary: High to Low</option>
                    <option value="salary_low">Salary: Low to High</option>
                </select>
            </div>
        </div>

        <!-- JOB CARDS LIST -->
        @php
            $defaultJobsData = [
                ['id' => '1', 'title' => 'Laravel Developer', 'company' => 'TCS', 'location' => 'Chennai, Tamil Nadu', 'salary' => '₹5L - ₹8L per annum', 'exp' => '2+ years', 'type' => 'Full-time, Onsite', 'skills' => ['Laravel', 'PHP', 'MySQL', 'REST API', 'Livewire'], 'posted' => 'Posted 2 days ago'],
                ['id' => '2', 'title' => 'Senior PHP & Laravel Engineer', 'company' => 'Infosys', 'location' => 'Bangalore, Karnataka', 'salary' => '₹8L - ₹14L per annum', 'exp' => '3+ years', 'type' => 'Full-time, Hybrid', 'skills' => ['Laravel', 'Redis', 'Docker', 'REST API'], 'posted' => 'Posted 1 day ago'],
                ['id' => '3', 'title' => 'Full-Stack Developer (React & Node)', 'company' => 'Wipro', 'location' => 'Hyderabad, Telangana', 'salary' => '₹6L - ₹10L per annum', 'exp' => '1+ years', 'type' => 'Full-time, Remote', 'skills' => ['React', 'Node.js', 'TypeScript', 'MongoDB'], 'posted' => 'Posted 3 days ago'],
                ['id' => '4', 'title' => 'Backend Architect (Java / Microservices)', 'company' => 'Amazon', 'location' => 'Chennai, Tamil Nadu', 'salary' => '₹18L - ₹28L per annum', 'exp' => '5+ years', 'type' => 'Full-time, Onsite', 'skills' => ['Java', 'Spring Boot', 'AWS', 'Kafka'], 'posted' => 'Posted 4 hours ago'],
                ['id' => '5', 'title' => 'Python & Data Engineer', 'company' => 'Startups', 'location' => 'Pune, Maharashtra', 'salary' => '₹7L - ₹12L per annum', 'exp' => '2+ years', 'type' => 'Full-time, Remote', 'skills' => ['Python', 'Django', 'PostgreSQL', 'Pandas'], 'posted' => 'Posted 5 days ago'],
                ['id' => '6', 'title' => 'QA Automation Lead', 'company' => 'Zoho', 'location' => 'Chennai, Tamil Nadu', 'salary' => '₹9L - ₹15L per annum', 'exp' => '4+ years', 'type' => 'Full-time, Onsite', 'skills' => ['Selenium', 'Cypress', 'Java', 'CI/CD'], 'posted' => 'Posted 1 week ago'],
                ['id' => '7', 'title' => 'DevOps & Kubernetes Specialist', 'company' => 'Freshworks', 'location' => 'Coimbatore, Tamil Nadu', 'salary' => '₹12L - ₹18L per annum', 'exp' => '3+ years', 'type' => 'Full-time, Hybrid', 'skills' => ['Docker', 'Kubernetes', 'Terraform', 'AWS'], 'posted' => 'Posted 3 days ago'],
                ['id' => '8', 'title' => 'Junior Laravel Developer', 'company' => 'TechSolutions', 'location' => 'Remote / WFH', 'salary' => '₹4L - ₹6L per annum', 'exp' => 'Fresher (0 yrs)', 'type' => 'Full-time, Remote', 'skills' => ['Laravel', 'PHP', 'Blade', 'MySQL'], 'posted' => 'Posted 6 hours ago'],
            ];
        @endphp

        <div class="space-y-4">
            @if ($jobs->count() > 0)
                @foreach ($jobs as $jobItem)
                    @php
                        $targetId = $jobItem->id;
                        $companyName = $jobItem->company?->name ?? 'Enterprise Corp';
                    @endphp
                    <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'" class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 flex-1">
                            <div class="flex flex-col items-center gap-1 shrink-0">
                                <div style="width: 52px; height: 52px; border-radius: 14px; background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white; font-weight: 900; font-size: 20px; display: flex; align-items: center; justify-content: center;">
                                    {{ strtoupper(substr($companyName, 0, 1)) }}
                                </div>
                                <span style="font-size: 11px; font-weight: 800; color: white;">{{ $companyName }}</span>
                                <span style="font-size: 9.5px; color: #f59e0b; font-weight: 700;">4.2 ★★★★☆</span>
                            </div>
                            <div class="space-y-2 flex-1">
                                <a href="{{ route('jobs.show', $targetId) }}" style="font-size: 16px; font-weight: 800; color: white; margin: 0; line-height: 1.3; text-decoration: none;" class="hover:text-[#f15153]">
                                    {{ $jobItem->title }}
                                </a>
                                <div class="flex flex-wrap items-center gap-4 text-xs" style="color: #d4c5e2;">
                                    <span class="flex items-center gap-1">
                                        <svg style="width: 13px; height: 13px;" class="text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $jobItem->location ?? 'Chennai, Tamil Nadu' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg style="width: 13px; height: 13px;" class="text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <strong class="text-white">₹5L - ₹8L per annum</strong>
                                    </span>
                                    <span style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3); font-weight: 700; font-size: 10px; padding: 2px 8px; border-radius: 20px;">
                                        Full-time
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                    @foreach (['Laravel', 'PHP', 'MySQL', 'REST API'] as $skTag)
                                        <span style="background: #1e0d2d; color: white; border: 1px solid rgba(255,255,255,0.08); font-weight: 700; font-size: 10.5px; padding: 2px 8px; border-radius: 6px;">
                                            {{ $skTag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <a href="{{ route('jobs.show', $targetId) }}" style="background: #f15153; color: white; box-shadow: 0 4px 14px rgba(241,81,83,0.35); text-decoration: none;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs hover:opacity-90 transition-all block text-center">
                                Apply Now ➔
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                @foreach ($defaultJobsData as $jIdx => $j)
                    <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 20px; padding: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'" class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 flex-1">
                            <div class="flex flex-col items-center gap-1 shrink-0">
                                <div style="width: 52px; height: 52px; border-radius: 14px; background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white; font-weight: 900; font-size: 20px; display: flex; align-items: center; justify-content: center;">
                                    {{ strtoupper(substr($j['company'], 0, 1)) }}
                                </div>
                                <span style="font-size: 11px; font-weight: 800; color: white;">{{ $j['company'] }}</span>
                                <span style="font-size: 9.5px; color: #f59e0b; font-weight: 700;">4.2 ★★★★☆</span>
                            </div>
                            <div class="space-y-2 flex-1">
                                <a href="{{ route('jobs.show', $j['id']) }}" style="font-size: 16px; font-weight: 800; color: white; margin: 0; line-height: 1.3; text-decoration: none;" class="hover:text-[#f15153]">
                                    {{ $j['title'] }}
                                </a>
                                <div class="flex flex-wrap items-center gap-4 text-xs" style="color: #d4c5e2;">
                                    <span class="flex items-center gap-1">
                                        <svg style="width: 13px; height: 13px;" class="text-[#f15153]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $j['location'] }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg style="width: 13px; height: 13px;" class="text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        {{ $j['exp'] }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg style="width: 13px; height: 13px;" class="text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <strong class="text-white">{{ $j['salary'] }}</strong>
                                    </span>
                                    <span style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3); font-weight: 700; font-size: 10px; padding: 2px 8px; border-radius: 20px;">
                                        {{ $j['type'] }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                    @foreach ($j['skills'] as $skTag)
                                        <span style="background: #1e0d2d; color: white; border: 1px solid rgba(255,255,255,0.08); font-weight: 700; font-size: 10.5px; padding: 2px 8px; border-radius: 6px;">
                                            {{ $skTag }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="text-[10.5px] font-medium" style="color: #a997be;">
                                    {{ $j['posted'] }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <a href="{{ route('jobs.show', $j['id']) }}" style="background: #f15153; color: white; box-shadow: 0 4px 14px rgba(241,81,83,0.35); text-decoration: none;" class="px-5 py-2.5 rounded-xl font-extrabold text-xs hover:opacity-90 transition-all block text-center">
                                Apply Now ➔
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- PAGINATION BAR -->
        <div class="pt-6 flex justify-center">
            <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 14px; padding: 8px 16px;" class="flex items-center gap-2 text-xs font-bold text-white">
                <span class="px-3 py-1.5 rounded-lg opacity-50 cursor-not-allowed" style="background: rgba(255,255,255,0.05);">Previous</span>
                <span class="px-3 py-1.5 rounded-lg bg-[#f15153] text-white">1</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-white/10 cursor-pointer">2</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-white/10 cursor-pointer">3</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-white/10 cursor-pointer">4</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-white/10 cursor-pointer">5</span>
                <span style="color: #a997be;">...</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-white/10 cursor-pointer">108</span>
                <span class="px-3 py-1.5 rounded-lg text-white hover:bg-white/10 cursor-pointer" style="background: rgba(255,255,255,0.08);">Next</span>
            </div>
        </div>

        <!-- NEWSLETTER SIGNUP BOX -->
        <div style="background: linear-gradient(135deg, #251237 0%, #210f30 100%); border: 1px solid rgba(241,81,83,0.25); border-radius: 24px; padding: 40px 32px; margin-top: 64px;" class="text-center max-w-4xl mx-auto space-y-4">
            <h3 class="text-2xl font-black text-white">Get New Job Alerts</h3>
            <p class="text-xs max-w-lg mx-auto" style="color: #d4c5e2;">
                Subscribe to receive instant job opening notifications from top hiring partners tailored to your software engineering skills.
            </p>

            <form onsubmit="event.preventDefault(); alert('Subscribed to Job Alerts!');" class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto pt-2">
                <input type="email" placeholder="Enter your email for job alerts..." required style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.12); color: white;" class="w-full px-4 py-3 rounded-xl text-xs placeholder-purple-300 focus:outline-none focus:border-[#f15153]">
                <button type="submit" style="background: #f15153; color: white;" class="w-full sm:w-auto px-6 py-3 rounded-xl font-extrabold text-xs shadow-md shadow-[#f15153]/30 hover:opacity-90 transition-all shrink-0">
                    Subscribe
                </button>
            </form>
        </div>

    </div>

</div>
