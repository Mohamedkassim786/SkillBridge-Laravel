<div class="space-y-8 bg-white" x-data="{ createModalOpen: @entangle('showModal') }">

    <!-- TOP SECTION: Breadcrumb, Page Heading & Subheading -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-rose-600 font-bold">Courses</span>
            </nav>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight" style="color: #0B1F3A;">Course Management</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Manage all courses, instructors, and enrollments</p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="createModalOpen = true" style="background: #D62828; color: white;" class="px-5 py-2.5 rounded-xl text-xs font-black shadow-md hover:bg-rose-700 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Create Course
            </button>
        </div>
    </div>

    <!-- ACTION BAR (White Card) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">

        <!-- Left Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button @click="createModalOpen = true" style="background: #D62828; color: white;" class="px-4 py-2 rounded-xl text-xs font-black shadow-sm hover:bg-rose-700 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Create Course
            </button>

            <button style="color: #0B1F3A; border: 1.5px solid #0B1F3A;" class="px-4 py-2 rounded-xl text-xs font-black hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Bulk Upload
            </button>

            <button style="color: #0B1F3A; border: 1.5px solid #0B1F3A;" class="px-4 py-2 rounded-xl text-xs font-black hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </button>
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">

            <!-- Search bar (300px) -->
            <div class="relative w-full sm:w-[300px]">
                <svg style="width: 15px; height: 15px; min-width: 15px;" class="text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search courses, instructors..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-rose-600 font-medium">
            </div>

            <!-- Category Filter Dropdown -->
            <select wire:model.live="selectedCategory" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-extrabold text-slate-700 focus:outline-none focus:border-rose-600">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <!-- Status Filter Dropdown -->
            <select wire:model.live="selectedStatus" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-extrabold text-slate-700 focus:outline-none focus:border-rose-600">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>

            <!-- Sort Dropdown -->
            <select wire:model.live="sortBy" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-extrabold text-slate-700 focus:outline-none focus:border-rose-600">
                <option value="newest">Sort by: Newest</option>
                <option value="popular">Sort by: Popular</option>
                <option value="revenue">Sort by: Revenue</option>
            </select>
        </div>

    </div>

    <!-- SECTION 1: COURSE STATISTICS (4 cards in a row) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card 1: Total Courses -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Total Courses</span>
                <div style="color: #0B1F3A; background: rgba(11,31,58,0.1); width: 44px; height: 44px; min-width: 44px;" class="rounded-xl flex items-center justify-center shrink-0">
                    <svg style="width: 22px; height: 22px; min-width: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black" style="color: #0B1F3A;">523</div>
            <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                <svg style="width: 14px; height: 14px; min-width: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+12 this month</span>
            </div>
        </div>

        <!-- Card 2: Total Enrollments -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Total Enrollments</span>
                <div style="color: #D62828; background: rgba(214,40,40,0.1); width: 44px; height: 44px; min-width: 44px;" class="rounded-xl flex items-center justify-center shrink-0">
                    <svg style="width: 22px; height: 22px; min-width: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black" style="color: #0B1F3A;">50,234</div>
            <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                <svg style="width: 14px; height: 14px; min-width: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+1,234 this month</span>
            </div>
        </div>

        <!-- Card 3: Total Revenue -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Total Revenue</span>
                <div style="color: #0B1F3A; background: rgba(11,31,58,0.1); width: 44px; height: 44px; min-width: 44px;" class="rounded-xl flex items-center justify-center shrink-0">
                    <span class="text-xl font-black">₹</span>
                </div>
            </div>
            <div class="text-3xl font-black" style="color: #0B1F3A;">₹1.25 Cr</div>
            <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                <svg style="width: 14px; height: 14px; min-width: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+₹12.5L this month</span>
            </div>
        </div>

        <!-- Card 4: Average Rating -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Average Rating</span>
                <div style="color: #D62828; background: rgba(214,40,40,0.1); width: 44px; height: 44px; min-width: 44px;" class="rounded-xl flex items-center justify-center shrink-0">
                    <svg style="width: 22px; height: 22px; min-width: 22px;" class="text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black" style="color: #0B1F3A;">4.6★</div>
            <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                <svg style="width: 14px; height: 14px; min-width: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+0.2 from last month</span>
            </div>
        </div>

    </div>

    <!-- SECTION 2: COURSES TABLE (White Card, Shadow) -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden space-y-4">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <!-- Table Header (Navy Blue Background #0B1F3A, White Text) -->
                <thead>
                    <tr style="background-color: #0B1F3A; color: white;" class="text-xs uppercase tracking-wider">
                        <th class="p-4 font-black">Course</th>
                        <th class="p-4 font-black">Instructor</th>
                        <th class="p-4 font-black">Category</th>
                        <th class="p-4 font-black">Students</th>
                        <th class="p-4 font-black">Revenue</th>
                        <th class="p-4 font-black">Rating</th>
                        <th class="p-4 font-black">Status</th>
                        <th class="p-4 font-black text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $sampleCoursesList = [
                            [
                                'id' => '1',
                                'title' => 'Complete Laravel 12 Development Course',
                                'sub' => '42 hours, 156 lectures',
                                'featured' => true,
                                'instructor' => 'John Doe',
                                'role' => 'Senior Laravel Developer',
                                'category' => 'Web Development',
                                'students' => '5,432',
                                'revenue' => '₹12.5L',
                                'rating' => '4.8★',
                                'reviews' => '1,234 reviews',
                                'status' => 'Published',
                            ],
                            [
                                'id' => '2',
                                'title' => 'Full-Stack Web Development Bootcamp',
                                'sub' => '58 hours, 210 lectures',
                                'featured' => true,
                                'instructor' => 'Priya Sharma',
                                'role' => 'Principal Web Architect',
                                'category' => 'Full Stack',
                                'students' => '4,120',
                                'revenue' => '₹9.8L',
                                'rating' => '4.9★',
                                'reviews' => '980 reviews',
                                'status' => 'Published',
                            ],
                            [
                                'id' => '3',
                                'title' => 'Mastering Redis & Microservices Architecture',
                                'sub' => '32 hours, 98 lectures',
                                'featured' => true,
                                'instructor' => 'Rahul Verma',
                                'role' => 'DevOps & Backend Engineer',
                                'category' => 'Backend',
                                'students' => '3,890',
                                'revenue' => '₹8.4L',
                                'rating' => '4.7★',
                                'reviews' => '745 reviews',
                                'status' => 'Published',
                            ],
                            [
                                'id' => '4',
                                'title' => 'React 19 & Livewire 3 Architecture Masterclass',
                                'sub' => '28 hours, 85 lectures',
                                'featured' => false,
                                'instructor' => 'Ananya Roy',
                                'role' => 'UI/UX & Frontend Specialist',
                                'category' => 'Frontend',
                                'students' => '3,100',
                                'revenue' => '₹6.2L',
                                'rating' => '4.8★',
                                'reviews' => '620 reviews',
                                'status' => 'Published',
                            ],
                            [
                                'id' => '5',
                                'title' => 'Python for Data Science & AI Engineer',
                                'sub' => '45 hours, 140 lectures',
                                'featured' => false,
                                'instructor' => 'Kavitha R.',
                                'role' => 'AI Research Scientist',
                                'category' => 'Data Science',
                                'students' => '2,850',
                                'revenue' => '₹5.5L',
                                'rating' => '4.6★',
                                'reviews' => '510 reviews',
                                'status' => 'Published',
                            ],
                            [
                                'id' => '6',
                                'title' => 'Docker & Kubernetes for Production Engineers',
                                'sub' => '24 hours, 75 lectures',
                                'featured' => false,
                                'instructor' => 'David Miller',
                                'role' => 'Cloud Solutions Architect',
                                'category' => 'DevOps',
                                'students' => '1,940',
                                'revenue' => '₹3.8L',
                                'rating' => '4.7★',
                                'reviews' => '410 reviews',
                                'status' => 'Draft',
                            ],
                            [
                                'id' => '7',
                                'title' => 'Flutter & Dart Cross-Platform Mobile Apps',
                                'sub' => '36 hours, 115 lectures',
                                'featured' => false,
                                'instructor' => 'Rajesh Kumar',
                                'role' => 'Lead Mobile Engineer',
                                'category' => 'Mobile Dev',
                                'students' => '1,650',
                                'revenue' => '₹3.1L',
                                'rating' => '4.5★',
                                'reviews' => '320 reviews',
                                'status' => 'Archived',
                            ],
                        ];
                    @endphp

                    @foreach ($courses as $cItem)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Course Thumbnail (80x50px) + Title + Subtext + Featured Star -->
                            <td class="p-4 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div style="width: 80px; height: 50px; background: #0B1F3A; color: white;" class="rounded-xl flex items-center justify-center font-black text-xs shrink-0 shadow-sm relative overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-rose-600/40 to-transparent"></div>
                                        <span class="relative z-10 text-[10px] uppercase font-black tracking-wider px-1 text-center">Course</span>
                                    </div>
                                    <div class="space-y-0.5 max-w-xs">
                                        <div class="flex items-center gap-1.5 font-black text-slate-900 text-xs">
                                            <span>{{ $cItem->title }}</span>
                                            <svg style="width: 14px; height: 14px; min-width: 14px;" class="text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-medium">42 hours, 156 lectures</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Instructor Avatar + Name + Subtitle -->
                            <td class="p-4">
                                <div class="flex items-center gap-2.5">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #0B1F3A; color: white; font-weight: 800; font-size: 13px;" class="flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($cItem->trainer?->name ?? 'John Doe', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-slate-900">{{ $cItem->trainer?->name ?? 'John Doe' }}</div>
                                        <div class="text-[10px] text-slate-500 font-medium">Senior Laravel Developer</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category Badge -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $cItem->category?->name ?? 'Web Development' }}
                                </span>
                            </td>

                            <!-- Students Count -->
                            <td class="p-4 font-bold text-slate-800">
                                <div class="flex items-center gap-1.5">
                                    <svg style="width: 14px; height: 14px; min-width: 14px;" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <span>5,432</span>
                                </div>
                            </td>

                            <!-- Revenue -->
                            <td class="p-4 font-black text-emerald-600">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-black">₹</span>
                                    <span>{{ number_format(($cItem->currentVersion?->price ?? 99) * 125) }}</span>
                                </div>
                            </td>

                            <!-- Rating Stars + Reviews -->
                            <td class="p-4">
                                <div class="flex items-center gap-1 font-black text-amber-500 text-xs">
                                    <svg style="width: 13px; height: 13px; min-width: 13px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <span>4.8★</span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium">1,234 reviews</div>
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4">
                                @if ($cItem->currentVersion?->is_published)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">Published</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-700 border border-slate-200">Draft</span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- View -->
                                    <a href="{{ route('courses.show', $cItem->id) }}" target="_blank" title="View Course" class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <button wire:click="editCourse('{{ $cItem->id }}')" title="Edit Course" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <!-- Analytics -->
                                    <a href="{{ route('admin.reports.index') }}" title="Analytics" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    </a>

                                    <!-- Delete -->
                                    <button wire:click="deleteCourse('{{ $cItem->id }}')" wire:confirm="Are you sure you want to delete this course?" title="Delete Course" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Additional Display Rows to populate 15-20 course rows for full demonstration -->
                    @foreach ($sampleCoursesList as $sRow)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div style="width: 80px; height: 50px; background: #0B1F3A; color: white;" class="rounded-xl flex items-center justify-center font-black text-xs shrink-0 shadow-sm relative overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-tr from-rose-600/40 to-transparent"></div>
                                        <span class="relative z-10 text-[10px] uppercase font-black tracking-wider px-1 text-center">Course</span>
                                    </div>
                                    <div class="space-y-0.5 max-w-xs">
                                        <div class="flex items-center gap-1.5 font-black text-slate-900 text-xs">
                                            <span>{{ $sRow['title'] }}</span>
                                            @if($sRow['featured'])
                                                <svg style="width: 14px; height: 14px; min-width: 14px;" class="text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-medium">{{ $sRow['sub'] }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="flex items-center gap-2.5">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #0B1F3A; color: white; font-weight: 800; font-size: 13px;" class="flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($sRow['instructor'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-slate-900">{{ $sRow['instructor'] }}</div>
                                        <div class="text-[10px] text-slate-500 font-medium">{{ $sRow['role'] }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $sRow['category'] }}
                                </span>
                            </td>

                            <td class="p-4 font-bold text-slate-800">
                                <div class="flex items-center gap-1.5">
                                    <svg style="width: 14px; height: 14px; min-width: 14px;" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <span>{{ $sRow['students'] }}</span>
                                </div>
                            </td>

                            <td class="p-4 font-black text-emerald-600">{{ $sRow['revenue'] }}</td>

                            <td class="p-4">
                                <div class="flex items-center gap-1 font-black text-amber-500 text-xs">
                                    <svg style="width: 13px; height: 13px; min-width: 13px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <span>{{ $sRow['rating'] }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ $sRow['reviews'] }}</div>
                            </td>

                            <td class="p-4">
                                @if ($sRow['status'] === 'Published')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">Published</span>
                                @elseif ($sRow['status'] === 'Draft')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-700 border border-slate-200">Draft</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">Archived</span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors"><svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                    <button class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"><svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                    <button class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"><svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></button>
                                    <button class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"><svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- BOTTOM CONTROLS & PAGINATION -->
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Feature Course Button (Outline Gold) -->
            <button style="border: 1.5px solid #d97706; color: #d97706;" class="px-4 py-2 rounded-xl text-xs font-black hover:bg-amber-50 transition-all flex items-center gap-2 shrink-0">
                <svg style="width: 15px; height: 15px; min-width: 15px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                Feature Selected Course
            </button>

            <!-- Pagination Text & Controls -->
            <div class="flex items-center gap-4 text-xs font-semibold text-slate-500">
                <span>Showing 1-20 of 523 courses</span>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 disabled:opacity-50" disabled>Previous</button>
                    <button class="px-3 py-1.5 rounded-lg bg-rose-600 text-white font-bold">1</button>
                    <button class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold">2</button>
                    <button class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold">3</button>
                    <span class="px-1 text-slate-400">...</span>
                    <button class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold">27</button>
                    <button class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold">Next</button>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT FLOATING BUTTON (Circular Red "Create Course" fixed at bottom right) -->
    <button @click="createModalOpen = true" title="Create Course" style="background: #D62828; color: white;" class="fixed bottom-8 right-8 z-40 w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all">
        <svg style="width: 26px; height: 26px; min-width: 26px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
    </button>

    <!-- CREATE / EDIT COURSE MODAL -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="createModalOpen = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100 relative">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-xl font-black text-slate-900">
                    {{ $editingCourseId ? 'Edit Course Details' : 'Create New Course' }}
                </h3>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1">
                    <svg style="width: 20px; height: 20px; min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveCourse" class="space-y-4 text-xs font-semibold">
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Course Title</label>
                    <input type="text" wire:model.live="title" placeholder="e.g. Complete Laravel 12 Development Course" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-rose-600">
                    @error('title') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Category</label>
                        <select wire:model="category_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-rose-600">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Instructor / Trainer</label>
                        <select wire:model="trainer_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-rose-600">
                            @foreach ($trainers as $tr)
                                <option value="{{ $tr->id }}">{{ $tr->name }} ({{ $tr->email }})</option>
                            @endforeach
                        </select>
                        @error('trainer_id') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Price (₹)</label>
                        <input type="number" step="0.01" wire:model="price" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-rose-600">
                        @error('price') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Difficulty Level</label>
                        <select wire:model="level" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-rose-600">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                        @error('level') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Description</label>
                    <textarea wire:model="description" rows="3" placeholder="Comprehensive course description..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-rose-600"></textarea>
                    @error('description') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" id="is_published" wire:model="is_published" class="w-4 h-4 text-rose-600 rounded">
                    <label for="is_published" class="text-xs font-bold text-slate-800">Publish immediately to Student Catalog</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50">Cancel</button>
                    <button type="submit" style="background: #D62828; color: white;" class="px-6 py-2.5 rounded-xl font-black shadow-md hover:bg-rose-700">Save Course</button>
                </div>
            </form>
        </div>
    </div>

</div>
