<div class="min-h-screen pb-20" style="background-color: #0B1F3A; color: #cbd5e1;">

    <!-- TOP HERO SECTION -->
    <div style="background: linear-gradient(180deg, #0B1F3A 0%, #081628 100%); border-bottom: 1px solid #1e3a5f; padding: 24px 0 28px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-slate-600">></span>
                <span class="text-rose-400 font-bold">Courses</span>
            </nav>

            <h1 class="text-4xl font-black text-white tracking-tight mb-2">Explore Our Courses</h1>
            <p class="text-slate-300 text-sm max-w-2xl">
                Choose from 500+ courses in Web Development, Mobile Apps, Data Science, and more. Master production architecture built by senior engineers.
            </p>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        <!-- Control Bar: Search, Results Count & Sort Dropdown -->
        <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px; padding: 16px 24px;" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            
            <!-- Search Bar (Left) -->
            <div class="relative flex-1 max-w-sm" style="display: flex; align-items: center;">
                <svg style="width: 16px; height: 16px; color: #94a3b8; position: absolute; left: 14px; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search courses..." style="background: #081628; border: 1px solid #1e3a5f; color: white; padding-left: 42px; padding-right: 16px; padding-top: 10px; padding-bottom: 10px; font-size: 13px; border-radius: 12px; width: 100%; outline: none;">
            </div>

            <!-- Results Count & Sort (Right) -->
            <div class="flex flex-wrap items-center gap-6 text-xs shrink-0">
                <p class="text-slate-300 font-medium">
                    Showing <strong class="text-white font-bold">{{ $courses->firstItem() ?? 1 }}-{{ $courses->lastItem() ?? count($courses) }}</strong> of <strong class="text-white font-bold">{{ $courses->total() }}</strong> courses
                </p>

                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-semibold whitespace-nowrap">Sort by:</span>
                    <select wire:model.live="sort" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="px-3 py-1.5 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                        <option value="popular">Popular</option>
                        <option value="newest">Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="rating">Rating</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- COURSE CARDS GRID (4 Columns) -->
        @php
            $thumbBanners = [
                'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&auto=format&fit=crop&q=80',
                'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=600&auto=format&fit=crop&q=80',
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($courses as $index => $course)
                @php
                    $priceVal = $course->currentVersion?->price ?? 2999;
                    $origPrice = $priceVal * 1.66;
                    $instructor = $course->trainer?->name ?? 'John Doe';
                    $bannerImg = $course->thumbnail ?? $thumbBanners[$index % 4];
                @endphp

                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.25)';">

                    <div>
                        <!-- Image Container & Badges -->
                        <div style="position: relative; height: 165px; overflow: hidden; background: #081628;">
                            <img src="{{ $bannerImg }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">

                            <!-- 40% OFF Badge (Top Left) -->
                            <span style="position: absolute; top: 12px; left: 12px; background: #D62828; color: white; font-weight: 800; font-size: 10px; padding: 4px 10px; border-radius: 20px; box-shadow: 0 2px 8px rgba(214,40,40,0.4);">
                                40% OFF
                            </span>

                            <!-- Category Badge (Top Right) -->
                            <span style="position: absolute; top: 12px; right: 12px; background: rgba(11, 31, 58, 0.9); backdrop-filter: blur(4px); color: #60a5fa; font-weight: 700; font-size: 10.5px; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.15);">
                                {{ $course->category?->name ?? 'Web Development' }}
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div style="padding: 16px 16px 10px; display: flex; flex-direction: column; gap: 10px;">

                            <!-- Course Title -->
                            <h3 style="font-size: 14.5px; font-weight: 800; color: white; line-height: 1.4; margin: 0; min-height: 42px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $course->title }}
                            </h3>

                            <!-- Instructor -->
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #D62828, #f87171); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 10px; flex-shrink: 0;">
                                    {{ strtoupper(substr($instructor, 0, 1)) }}
                                </div>
                                <span style="font-size: 12px; font-weight: 600; color: #94a3b8;">by {{ $instructor }}</span>
                            </div>

                            @php
                                $totalLessonsCount = 0;
                                if ($course->currentVersion && $course->currentVersion->modules) {
                                    foreach ($course->currentVersion->modules as $mod) {
                                        $totalLessonsCount += $mod->lessons->count();
                                    }
                                }
                                $enrolledCount = $course->enrollments_count ?? 1;
                            @endphp

                            <!-- Rating & Enrolled -->
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11.5px; color: #cbd5e1;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <span style="color: #f59e0b; font-weight: 800;">5.0 ★★★★★</span>
                                    <span style="color: #64748b;">(Verified)</span>
                                </div>
                                <span style="color: #94a3b8; font-weight: 600;">{{ $enrolledCount }} {{ Str::plural('student', $enrolledCount) }}</span>
                            </div>

                            <!-- Meta Info: Duration | Lectures | Level -->
                            <div style="font-size: 11px; color: #94a3b8; padding-top: 8px; border-top: 1px solid #1e3a5f; display: flex; align-items: center; justify-content: space-between;">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $course->currentVersion?->modules->count() ?? 4 }} modules
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    {{ $totalLessonsCount > 0 ? $totalLessonsCount : 12 }} lectures
                                </span>
                                <span style="color: #f87171; font-weight: 700;">{{ ucfirst($course->currentVersion?->level ?? 'Beginner') }}</span>
                            </div>

                            <!-- Price Section -->
                            <div style="display: flex; align-items: baseline; gap: 8px; margin-top: 2px;">
                                <span style="font-size: 20px; font-weight: 900; color: #f87171;">₹{{ number_format($priceVal) }}</span>
                            </div>

                        </div>
                    </div>

                    <!-- Enroll Now Button -->
                    <div style="padding: 0 16px 16px;">
                        <a href="{{ route('courses.show', $course->id) }}" style="background: #D62828; color: white; font-weight: 800; font-size: 13px; padding: 10px; border-radius: 10px; text-align: center; text-decoration: none; display: block; box-shadow: 0 4px 14px rgba(214,40,40,0.35); transition: background 0.15s;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#D62828'">
                            Enroll Now ➔
                        </a>
                    </div>

                </div>
            @empty
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px; padding: 48px;" class="col-span-full text-center text-slate-400">
                    No courses matched your search.
                </div>
            @endforelse
        </div>

        <!-- PAGINATION BAR -->
        <div class="pt-6 flex justify-center">
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 14px; padding: 8px 16px;" class="flex items-center gap-2 text-xs font-bold text-slate-300">
                <span class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-500 cursor-not-allowed">Previous</span>
                <span class="px-3 py-1.5 rounded-lg bg-[#D62828] text-white">1</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-slate-800 cursor-pointer">2</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-slate-800 cursor-pointer">3</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-slate-800 cursor-pointer">4</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-slate-800 cursor-pointer">5</span>
                <span class="text-slate-600">...</span>
                <span class="px-3 py-1.5 rounded-lg hover:bg-slate-800 cursor-pointer">12</span>
                <span class="px-3 py-1.5 rounded-lg bg-slate-800 text-white hover:bg-slate-700 cursor-pointer">Next</span>
            </div>
        </div>

        <!-- NEWSLETTER SIGNUP BOX -->
        <div style="background: linear-gradient(135deg, #112240 0%, #081628 100%); border: 1px solid #1e3a5f; border-radius: 24px; padding: 40px 32px; margin-top: 64px;" class="text-center max-w-4xl mx-auto space-y-4">
            <h3 class="text-2xl font-black text-white">Get Course Updates and Discounts</h3>
            <p class="text-xs text-slate-300 max-w-lg mx-auto">
                Subscribe to our newsletter to receive new course alerts, exclusive discounts, and backend architecture tips directly to your inbox.
            </p>

            <form onsubmit="event.preventDefault(); alert('Subscribed successfully!');" class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto pt-2">
                <input type="email" placeholder="Enter your email..." required style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs placeholder-slate-500 focus:outline-none focus:border-rose-500">
                <button type="submit" style="background: #D62828; color: white;" class="w-full sm:w-auto px-6 py-3 rounded-xl font-extrabold text-xs shadow-md hover:bg-red-700 transition-all shrink-0">
                    Subscribe
                </button>
            </form>
        </div>

    </div>

</div>
