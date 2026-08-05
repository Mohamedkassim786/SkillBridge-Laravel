<div class="space-y-6">

    <!-- HERO WELCOME BANNER (Matching Student Portal Hero Box style) -->
    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #112240 100%); border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;"
        class="text-white relative overflow-hidden shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-3 max-w-2xl relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold"
                style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>System Operational • Cohort 2026 Admin Suite</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Welcome back, Admin! 👋
            </h1>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                Ready to manage your software learning platform? You have <strong class="text-white">4 pending course
                    reviews</strong> and <strong class="text-white">5 unread system alerts</strong> today.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 shrink-0 relative z-10">
            <select wire:model.live="period"
                style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;"
                class="px-4 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
                <option value="today" class="text-slate-900">Today</option>
                <option value="this_week" class="text-slate-900">This Week</option>
                <option value="this_month" class="text-slate-900">This Month</option>
                <option value="this_year" class="text-slate-900">This Year</option>
            </select>

            <a href="{{ route('admin.courses.manage') }}"
                style="background: #D62828; color: white; box-shadow: 0 4px 16px rgba(214,40,40,0.4);"
                class="px-5 py-2.5 rounded-xl text-xs font-extrabold hover:bg-red-700 transition-all flex items-center gap-2 text-decoration-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Manage Courses ➔
            </a>
        </div>
    </div>

    <!-- 4 WHITE KPI STAT CARDS (Light White Theme matching Student Portal stat row) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Stat Card 1: Revenue -->
        <div
            class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Revenue</span>
                <div
                    class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">₹{{ number_format($totalRevenue) }}</div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2 py-0.5 rounded-md font-extrabold bg-emerald-100 text-emerald-800">+18.4%</span>
                <span class="text-slate-500 font-medium">vs last month</span>
            </div>
        </div>

        <!-- Stat Card 2: Active Students -->
        <div
            class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Students</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ number_format($totalStudents) }}</div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2 py-0.5 rounded-md font-extrabold bg-blue-100 text-blue-800">+1,200</span>
                <span class="text-slate-500 font-medium">new this month</span>
            </div>
        </div>

        <!-- Stat Card 3: Published Courses -->
        <div
            class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Courses Catalog</span>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $totalCourses }}</div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2 py-0.5 rounded-md font-extrabold bg-amber-100 text-amber-800">4 Pending</span>
                <span class="text-slate-500 font-medium">review</span>
            </div>
        </div>

        <!-- Stat Card 4: Job Applications -->
        <div
            class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Job Applications</span>
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">3,890</div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2 py-0.5 rounded-md font-extrabold bg-purple-100 text-purple-800">+450</span>
                <span class="text-slate-500 font-medium">this week</span>
            </div>
        </div>

    </div>

    <!-- WHITE ANALYTICS CHARTS & GRAPHS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Revenue Bar Chart (2 Cols) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Monthly Revenue & Enrollments</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Platform growth trajectory over the past 6 months</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                    Target: ₹20L / Mo
                </span>
            </div>

            <!-- Bar Chart Graphic -->
            <div class="space-y-4 pt-2">
                @php
                    $monthsData = [
                        ['month' => 'Mar', 'rev' => '₹8.2L', 'pct' => 45],
                        ['month' => 'Apr', 'rev' => '₹9.8L', 'pct' => 58],
                        ['month' => 'May', 'rev' => '₹11.4L', 'pct' => 68],
                        ['month' => 'Jun', 'rev' => '₹12.9L', 'pct' => 78],
                        ['month' => 'Jul', 'rev' => '₹13.8L', 'pct' => 85],
                        ['month' => 'Aug', 'rev' => '₹14.85L', 'pct' => 92],
                    ];
                @endphp

                <div class="grid grid-cols-6 items-end gap-4 h-44 pt-6 border-b border-slate-100 pb-2">
                    @foreach ($monthsData as $mData)
                        <div class="flex flex-col items-center gap-2 h-full justify-end">
                            <span class="text-[11px] text-slate-700 font-bold">{{ $mData['rev'] }}</span>
                            <div style="height: {{ $mData['pct'] }}%; width: 100%; max-width: 44px; background: linear-gradient(180deg, #D62828 0%, #0B1F3A 100%); border-radius: 8px 8px 0 0;"
                                class="shadow-sm"></div>
                            <span class="text-xs text-slate-500 font-bold mt-1">{{ $mData['month'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Student Placement Ratio Card (1 Col) -->
        <div
            class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <h3 class="text-base font-extrabold text-slate-900">Student Placement Ratio</h3>

                <div class="space-y-4 pt-1">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">Placed in TCS / Infosys</span>
                            <span class="text-emerald-600">94.2%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: 94.2%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">Course Completion Rate</span>
                            <span class="text-blue-600">88.5%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 88.5%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">Certificates Verified (QR)</span>
                            <span class="text-rose-600">99.8%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-rose-600 h-full rounded-full" style="width: 99.8%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200/80 p-4 rounded-xl space-y-1.5">
                <div class="flex items-center justify-between text-xs font-bold text-slate-900">
                    <span>System API Latency</span>
                    <span class="text-emerald-600">42 ms (Operational)</span>
                </div>
                <div class="text-[11px] text-slate-500">MySQL Database load: 14% | Redis Cache hit: 98.4%</div>
            </div>
        </div>

    </div>

    <!-- WHITE DATA TABLE 1: RECENT ENROLLMENTS -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Recent Student Enrollments</h3>
                <p class="text-xs text-slate-500 mt-0.5">Latest course subscriptions processed via Razorpay & Stripe</p>
            </div>
            <a href="{{ route('admin.enrollments.manage') }}" class="text-xs font-bold text-rose-600 hover:underline">
                View All Enrollments ➔
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-900">
                        <th class="p-4 font-bold">Student Name</th>
                        <th class="p-4 font-bold">Course Title</th>
                        <th class="p-4 font-bold">Amount Paid</th>
                        <th class="p-4 font-bold">Gateway</th>
                        <th class="p-4 font-bold">Date</th>
                        <th class="p-4 font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $sampleEnrollments = [
                            ['name' => 'Priya Sharma', 'course' => 'Complete Laravel 12 Development Course 2026', 'amount' => '₹2,999', 'gw' => 'Razorpay', 'date' => 'Today, 2:15 PM', 'status' => 'Completed'],
                            ['name' => 'Rahul Verma', 'course' => 'Full-Stack Web Development Bootcamp', 'amount' => '₹3,499', 'gw' => 'Stripe', 'date' => 'Today, 1:40 PM', 'status' => 'Completed'],
                            ['name' => 'Ananya Roy', 'course' => 'Mastering Redis & High-Scale Microservices', 'amount' => '₹2,499', 'gw' => 'Razorpay', 'date' => 'Yesterday, 6:10 PM', 'status' => 'Completed'],
                            ['name' => 'Kavitha R.', 'course' => 'Advanced React & Livewire 3 Enterprise Architecture', 'amount' => '₹1,999', 'gw' => 'UPI', 'date' => 'Yesterday, 4:05 PM', 'status' => 'Completed'],
                            ['name' => 'David Miller', 'course' => 'Python for Data Science & AI Machine Learning', 'amount' => '₹4,999', 'gw' => 'Razorpay', 'date' => '2 days ago', 'status' => 'Completed'],
                        ];
                    @endphp

                    @foreach ($sampleEnrollments as $eRow)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 font-bold text-slate-900 flex items-center gap-3">
                                <div style="width: 28px; height: 28px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 11px;"
                                    class="flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($eRow['name'], 0, 1)) }}
                                </div>
                                {{ $eRow['name'] }}
                            </td>
                            <td class="p-4 text-slate-800 font-semibold">{{ $eRow['course'] }}</td>
                            <td class="p-4 font-bold text-emerald-600">{{ $eRow['amount'] }}</td>
                            <td class="p-4 text-slate-500 font-medium">{{ $eRow['gw'] }}</td>
                            <td class="p-4 text-slate-500 font-medium">{{ $eRow['date'] }}</td>
                            <td class="p-4 text-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $eRow['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- WHITE DATA TABLE 2: RECENT JOB APPLICATIONS -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Recent Job Applications</h3>
                <p class="text-xs text-slate-500 mt-0.5">Software candidates applying to enterprise hiring partners</p>
            </div>
            <a href="{{ route('admin.jobs.manage') }}" class="text-xs font-bold text-rose-600 hover:underline">
                Manage Job Board ➔
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-900">
                        <th class="p-4 font-bold">Candidate</th>
                        <th class="p-4 font-bold">Job Title</th>
                        <th class="p-4 font-bold">Company</th>
                        <th class="p-4 font-bold">Applied On</th>
                        <th class="p-4 font-bold text-center">Stage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $sampleApps = [
                            ['applicant' => 'Rajesh Kumar', 'title' => 'Laravel Developer', 'company' => 'TCS', 'date' => 'Today', 'stage' => 'Under Review'],
                            ['applicant' => 'Siddharth V.', 'title' => 'Senior PHP Engineer', 'company' => 'Infosys', 'date' => 'Today', 'stage' => 'Interview Scheduled'],
                            ['applicant' => 'Meera Patel', 'title' => 'Backend Architect', 'company' => 'Wipro', 'date' => 'Yesterday', 'stage' => 'Shortlisted'],
                            ['applicant' => 'Arun Prakash', 'title' => 'Full-Stack Developer', 'company' => 'Zoho', 'date' => '2 days ago', 'stage' => 'Offer Extended'],
                        ];
                    @endphp

                    @foreach ($sampleApps as $appRow)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 font-bold text-slate-900">{{ $appRow['applicant'] }}</td>
                            <td class="p-4 font-semibold text-rose-600">{{ $appRow['title'] }}</td>
                            <td class="p-4 text-slate-700 font-medium">{{ $appRow['company'] }}</td>
                            <td class="p-4 text-slate-500 font-medium">{{ $appRow['date'] }}</td>
                            <td class="p-4 text-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $appRow['stage'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>