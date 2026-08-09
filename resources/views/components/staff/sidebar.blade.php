@php
    $currentTab = request()->get('tab', 'dashboard');
    $coreNav = [
        ['id' => 'dashboard', 'name' => '1. Staff Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['id' => 'courses', 'name' => '2. My Courses', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['id' => 'create_course', 'name' => '3. Create Course', 'icon' => 'M12 4v16m8-8H4'],
        ['id' => 'batches', 'name' => '4. My Batches', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
    ];
    $evalNav = [
        ['id' => 'assignments', 'name' => '5. Assignments', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
        ['id' => 'quizzes', 'name' => '6. Quizzes', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        ['id' => 'student_progress', 'name' => '7. Student Progress', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
        ['id' => 'live_classes', 'name' => '8. Live Classes', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
        ['id' => 'materials', 'name' => '9. Course Materials', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ];
    $sysNav = [
        ['id' => 'reports', 'name' => '10. Reports', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['id' => 'settings', 'name' => '11. Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
        ['id' => 'messages', 'name' => '12. Messages', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
        ['id' => 'support', 'name' => '13. Help & Support', 'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'],
    ];
@endphp

<aside style="background-color: #0B1F3A;" class="w-64 p-4 flex flex-col justify-between space-y-6 overflow-y-auto shrink-0 border-r border-slate-800 sticky top-16 h-[calc(100vh-4rem)] self-start z-20">
    <div class="space-y-5">

        <!-- GROUP 1: CORE INSTRUCTION -->
        <div>
            <div class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                CORE INSTRUCTION
            </div>
            <nav class="space-y-1 text-xs font-semibold">
                @foreach ($coreNav as $item)
                    @php $isActive = $currentTab === $item['id']; @endphp
                    <a href="{{ route('staff.dashboard') }}?tab={{ $item['id'] }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all text-sm font-semibold {{ $isActive ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30 font-extrabold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                        </svg>
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- GROUP 2: EVALUATION & CLASSES -->
        <div>
            <div class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                EVALUATION & CLASSES
            </div>
            <nav class="space-y-1 text-xs font-semibold">
                @foreach ($evalNav as $item)
                    @php 
                        $isActive = $currentTab === $item['id'] || ($item['id'] === 'live_classes' && request()->routeIs('staff.live-classes.*')); 
                        $targetUrl = $item['id'] === 'live_classes' ? route('staff.live-classes.index') : route('staff.dashboard') . '?tab=' . $item['id'];
                    @endphp
                    <a href="{{ $targetUrl }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all text-sm font-semibold {{ $isActive ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30 font-extrabold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                        </svg>
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- GROUP 3: REPORTS & SETTINGS -->
        <div>
            <div class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                REPORTS & PREFERENCES
            </div>
            <nav class="space-y-1 text-xs font-semibold">
                @foreach ($sysNav as $item)
                    @php $isActive = $currentTab === $item['id']; @endphp
                    <a href="{{ route('staff.dashboard') }}?tab={{ $item['id'] }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all text-sm font-semibold {{ $isActive ? 'bg-[#D62828] text-white shadow-md shadow-[#D62828]/30 font-extrabold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                        </svg>
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

    </div>

    <!-- LOGOUT BUTTON -->
    <div class="pt-4 border-t border-slate-700/60">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-extrabold text-xs bg-[#D62828] text-white hover:bg-red-700 transition-all shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
