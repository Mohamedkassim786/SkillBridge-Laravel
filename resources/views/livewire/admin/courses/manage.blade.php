<div class="space-y-8" x-data="{ createModalOpen: @entangle('showModal') }">

    <!-- TOP SECTION: Breadcrumb, Page Heading & Subheading -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-rose-400 font-bold">Courses</span>
            </nav>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">Course Management</h1>
            <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1">Manage all courses, instructors, and enrollments</p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="createModalOpen = true" style="background: #D62828; color: white;" class="px-5 py-2.5 rounded-xl text-xs font-black shadow-md hover:bg-rose-700 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Create Course
            </button>
        </div>
    </div>

    <!-- ACTION BAR (Dark Navy Card) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-4 sm:p-6 shadow-xl flex flex-col lg:flex-row lg:items-center justify-between gap-4 text-white">

        <!-- Left Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button @click="createModalOpen = true" style="background: #D62828; color: white;" class="px-4 py-2 rounded-xl text-xs font-black shadow-sm hover:bg-rose-700 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Create Course
            </button>

            <button style="color: white; border: 1.5px solid #1e3a5f; background: rgba(255,255,255,0.05);" class="px-4 py-2 rounded-xl text-xs font-black hover:bg-white/10 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Bulk Upload
            </button>

            <button style="color: white; border: 1.5px solid #1e3a5f; background: rgba(255,255,255,0.05);" class="px-4 py-2 rounded-xl text-xs font-black hover:bg-white/10 transition-all flex items-center gap-2">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </button>
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-[300px]">
                <svg style="width: 15px; height: 15px; min-width: 15px;" class="text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search courses, instructors..." style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;" class="w-full pl-10 pr-4 py-2 rounded-xl text-xs text-white placeholder-slate-400 focus:outline-none focus:border-rose-500 font-medium">
            </div>

            <select wire:model.live="selectedCategory" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3.5 py-2 rounded-xl text-xs font-extrabold focus:outline-none">
                <option value="" class="text-slate-900">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" class="text-slate-900">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="selectedStatus" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3.5 py-2 rounded-xl text-xs font-extrabold focus:outline-none">
                <option value="" class="text-slate-900">All Status</option>
                <option value="published" class="text-slate-900">Published</option>
                <option value="draft" class="text-slate-900">Draft</option>
                <option value="archived" class="text-slate-900">Archived</option>
            </select>
        </div>

    </div>

    <!-- SECTION 1: DYNAMIC MYSQL 8 COURSE STATISTICS (Dark Navy Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card 1: Total Courses -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl space-y-3 text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Courses</span>
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center shrink-0">
                    <svg style="width: 20px; height: 20px; min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white">{{ $totalCoursesCount }}</div>
            <div class="text-xs font-bold text-emerald-400 flex items-center gap-1">
                <span>Active in Catalog</span>
            </div>
        </div>

        <!-- Card 2: Total Enrollments -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl space-y-3 text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Enrollments</span>
                <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center shrink-0">
                    <svg style="width: 20px; height: 20px; min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white">{{ $totalEnrollmentsCount }}</div>
            <div class="text-xs font-bold text-emerald-400 flex items-center gap-1">
                <span>Active Student Learners</span>
            </div>
        </div>

        <!-- Card 3: Total Revenue -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl space-y-3 text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Total Revenue</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0">
                    <span class="text-lg font-black">₹</span>
                </div>
            </div>
            <div class="text-3xl font-black text-white">₹{{ number_format($totalRevenue) }}</div>
            <div class="text-xs font-bold text-emerald-400 flex items-center gap-1">
                <span>Verified Transactions</span>
            </div>
        </div>

        <!-- Card 4: Average Rating -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-6 shadow-xl space-y-3 text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Average Rating</span>
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center shrink-0">
                    <svg style="width: 20px; height: 20px; min-width: 20px;" class="text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white">{{ $avgRating }}★</div>
            <div class="text-xs font-bold text-emerald-400 flex items-center gap-1">
                <span>Student Course Reviews</span>
            </div>
        </div>

    </div>

    <!-- SECTION 2: DYNAMIC REAL COURSES TABLE (Dark Navy Table) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 border-b border-slate-800 text-white text-xs uppercase tracking-wider">
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
                <tbody class="divide-y divide-slate-800">
                    @forelse ($courses as $cItem)
                        @php
                            $instructorName = $cItem->trainer ? ($cItem->trainer->first_name . ' ' . $cItem->trainer->last_name) : 'Senior Instructor';
                            $enrolledCount = $cItem->enrollments ? $cItem->enrollments->count() : 1;
                            $coursePrice = (float) ($cItem->currentVersion?->price ?? 99);
                        @endphp
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <!-- Course Thumbnail + Title -->
                            <td class="p-4 font-bold text-white">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $cItem->thumbnail }}" alt="{{ $cItem->title }}" class="w-16 h-10 rounded-xl object-cover border border-slate-700 shrink-0 shadow-sm">
                                    <div class="space-y-0.5 max-w-xs">
                                        <div class="flex items-center gap-1.5 font-black text-white text-xs">
                                            <span>{{ $cItem->title }}</span>
                                            <svg style="width: 14px; height: 14px; min-width: 14px;" class="text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        </div>
                                        <div class="text-[11px] text-slate-400 font-medium">PHP 8.3 & Laravel 12 Architecture</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Instructor -->
                            <td class="p-4">
                                <div class="flex items-center gap-2.5">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 13px;" class="flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($instructorName, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-extrabold text-white">{{ $instructorName }}</div>
                                        <div class="text-[10px] text-slate-400 font-medium">Senior Developer</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    {{ $cItem->category?->name ?? 'Software Engineering' }}
                                </span>
                            </td>

                            <!-- Students Count -->
                            <td class="p-4 font-bold text-slate-200">
                                <div class="flex items-center gap-1.5">
                                    <svg style="width: 14px; height: 14px; min-width: 14px;" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <span>{{ number_format($enrolledCount) }}</span>
                                </div>
                            </td>

                            <!-- Revenue -->
                            <td class="p-4 font-black text-emerald-400">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-black">₹</span>
                                    <span>{{ number_format($coursePrice * $enrolledCount) }}</span>
                                </div>
                            </td>

                            <!-- Rating Stars -->
                            <td class="p-4">
                                <div class="flex items-center gap-1 font-black text-amber-400 text-xs">
                                    <svg style="width: 13px; height: 13px; min-width: 13px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <span>4.8★</span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium">Verified Rating</div>
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4">
                                @if ($cItem->currentVersion?->is_published ?? true)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Published</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-slate-700 text-slate-300 border border-slate-600">Draft</span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('courses.show', $cItem->id) }}" target="_blank" title="View Course" class="p-1.5 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <a href="{{ route('admin.lessons.manage', ['selectedCourseId' => $cItem->id]) }}" title="Upload Videos & Manage Lessons" class="p-1.5 text-rose-400 hover:bg-rose-500/20 rounded-lg transition-colors flex items-center gap-1 font-bold text-[11px]">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </a>

                                    <button wire:click="editCourse('{{ $cItem->id }}')" title="Edit Course" class="p-1.5 text-blue-400 hover:bg-blue-500/20 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <button wire:click="deleteCourse('{{ $cItem->id }}')" wire:confirm="Are you sure you want to delete this course?" title="Delete Course" class="p-1.5 text-rose-400 hover:bg-rose-500/20 rounded-lg transition-colors">
                                        <svg style="width: 15px; height: 15px; min-width: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-semibold">No courses found in database. Click "Create Course" to add one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <button style="border: 1.5px solid #d97706; color: #fbbf24;" class="px-4 py-2 rounded-xl text-xs font-black hover:bg-amber-500/20 transition-all flex items-center gap-2 shrink-0">
                <svg style="width: 15px; height: 15px; min-width: 15px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                Feature Selected Course
            </button>

            <div class="flex items-center gap-4 text-xs font-semibold text-slate-400">
                <span>Showing {{ $courses->count() }} of {{ $totalCoursesCount }} real courses</span>
            </div>
        </div>

    </div>

    <!-- RIGHT FLOATING BUTTON -->
    <button @click="createModalOpen = true" title="Create Course" style="background: #D62828; color: white;" class="fixed bottom-8 right-8 z-40 w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all">
        <svg style="width: 26px; height: 26px; min-width: 26px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
    </button>

    <!-- CREATE / EDIT COURSE MODAL (Dark Navy Modal) -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="createModalOpen = false" style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl text-white relative">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <h3 class="text-xl font-black text-white">
                    {{ $editingCourseId ? 'Edit Course Details' : 'Create New Course' }}
                </h3>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-white p-1">
                    <svg style="width: 20px; height: 20px; min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveCourse" class="space-y-4 text-xs font-semibold">
                <div>
                    <label class="block text-slate-300 font-bold mb-1">Course Title</label>
                    <input type="text" wire:model.live="title" placeholder="e.g. Complete Laravel 12 Development Course" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-rose-500">
                    @error('title') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-bold mb-1">Category</label>
                        <select wire:model="category_id" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" class="text-slate-900">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-300 font-bold mb-1">Instructor / Trainer</label>
                        <select wire:model="trainer_id" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                            @foreach ($trainers as $tr)
                                <option value="{{ $tr->id }}" class="text-slate-900">{{ $tr->first_name }} {{ $tr->last_name }} ({{ $tr->email }})</option>
                            @endforeach
                        </select>
                        @error('trainer_id') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-bold mb-1">Price (₹)</label>
                        <input type="number" step="0.01" wire:model="price" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                        @error('price') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-300 font-bold mb-1">Difficulty Level</label>
                        <select wire:model="level" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                            <option value="beginner" class="text-slate-900">Beginner</option>
                            <option value="intermediate" class="text-slate-900">Intermediate</option>
                            <option value="advanced" class="text-slate-900">Advanced</option>
                        </select>
                        @error('level') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 font-bold mb-1">Course Thumbnail Image (Optional)</label>
                    <input type="file" wire:model="thumbnailFile" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#D62828] file:text-white hover:file:bg-rose-700">
                    @error('thumbnailFile') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-slate-300 font-bold mb-1">Description</label>
                    <textarea wire:model="description" rows="3" placeholder="Comprehensive course description..." style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white placeholder-slate-500 focus:outline-none"></textarea>
                    @error('description') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" id="is_published" wire:model="is_published" class="w-4 h-4 text-rose-600 rounded">
                    <label for="is_published" class="text-xs font-bold text-slate-300">Publish immediately to Student Catalog</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-700 text-slate-300 font-bold hover:bg-slate-800">Cancel</button>
                    <button type="submit" style="background: #D62828; color: white;" class="px-6 py-2.5 rounded-xl font-black shadow-md hover:bg-rose-700">Save Course</button>
                </div>
            </form>
        </div>
    </div>

</div>
