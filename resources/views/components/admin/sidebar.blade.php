<aside style="background-color: #0B1F3A; border-right: 1px solid rgba(255,255,255,0.08);" class="w-64 p-4 flex flex-col justify-between space-y-6 overflow-y-auto shrink-0 sticky top-16 h-[calc(100vh-4rem)] self-start z-20">

    <div class="space-y-6">

        <!-- GROUP 1: CORE NAVIGATION -->
        <div>
            <div class="text-[10.5px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                CORE NAVIGATION
            </div>

            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $coreNavs = [
                        ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'],
                        ['name' => 'Users & Students', 'route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'],
                        ['name' => 'Courses Management', 'route' => 'admin.courses.manage', 'pattern' => 'admin.courses.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'],
                    ];
                @endphp

                @foreach ($coreNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $targetUrl = Route::has($nav['route']) ? route($nav['route']) : route('admin.dashboard');
                    @endphp
                    <a href="{{ $targetUrl }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- GROUP 2: CAREER & PLACEMENT -->
        <div>
            <div class="text-[10.5px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                CAREER & PLACEMENT
            </div>

            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $careerNavs = [
                        ['name' => 'Jobs Marketplace', 'route' => 'admin.jobs.manage', 'pattern' => 'admin.jobs.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'],
                        ['name' => 'Hiring Companies', 'route' => 'admin.companies.manage', 'pattern' => 'admin.companies.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'],
                        ['name' => 'Job Applications', 'route' => 'admin.applications.manage', 'pattern' => 'admin.applications.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
                        ['name' => 'Payments & Revenue', 'route' => 'admin.payments.manage', 'pattern' => 'admin.payments.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'],
                    ];
                @endphp

                @foreach ($careerNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $targetUrl = Route::has($nav['route']) ? route($nav['route']) : route('admin.dashboard');
                    @endphp
                    <a href="{{ $targetUrl }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- GROUP 3: PLATFORM & SYSTEM -->
        <div>
            <div class="text-[10.5px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                PLATFORM & SYSTEM
            </div>

            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $sysNavs = [
                        ['name' => 'Reports & Analytics', 'route' => 'admin.reports.index', 'pattern' => 'admin.reports.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'],
                        ['name' => 'System Settings',     'route' => 'admin.settings.index', 'pattern' => 'admin.settings.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'],
                        ['name' => 'Database Backups',    'route' => 'admin.backups.index',  'pattern' => 'admin.backups.*',  'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>'],
                        ['name' => 'Activity Logs',       'route' => 'admin.activity-logs.index', 'pattern' => 'admin.activity-logs.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>'],
                    ];
                @endphp

                @foreach ($sysNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $targetUrl = Route::has($nav['route']) ? route($nav['route']) : route('admin.dashboard');
                    @endphp
                    <a href="{{ $targetUrl }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

    </div>

    <!-- Bottom: Logout button (red, full width) -->
    <div class="pt-4 border-t border-slate-700/60">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: #D62828; color: white;" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-extrabold text-xs hover:bg-red-700 transition-all shadow-md">
                <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>

</aside>