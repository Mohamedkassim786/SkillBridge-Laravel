<aside style="background-color: #0B1F3A; border-right: 1px solid rgba(255,255,255,0.08);" class="w-72 p-4 flex flex-col justify-between space-y-6 overflow-y-auto shrink-0 sticky top-16 h-[calc(100vh-4rem)] self-start z-20">

    <div class="space-y-6">

        <!-- DASHBOARD -->
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">CORE ENGINE</div>
            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $isDashActive = request()->routeIs('super_admin.dashboard');
                @endphp
                <a href="{{ route('super_admin.dashboard') }}"
                    style="{{ $isDashActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                    <svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard Overview</span>
                </a>
            </nav>
        </div>

        <!-- PLATFORM MANAGEMENT -->
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">PLATFORM MANAGEMENT</div>
            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $platNavs = [
                        ['name' => 'All Users',       'route' => 'super_admin.users.manage',        'pattern' => 'super_admin.users.*',        'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'],
                        ['name' => 'Staff / Trainers','route' => 'super_admin.trainers.workflow',   'pattern' => 'super_admin.trainers.*',     'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>'],
                        ['name' => 'Multi-Admins',    'route' => 'super_admin.admins.manage',       'pattern' => 'super_admin.admins.*',       'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'],
                        ['name' => 'Courses Pipeline','route' => 'super_admin.courses.workflow',    'pattern' => 'super_admin.courses.*',      'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'],
                        ['name' => 'Jobs Marketplace','route' => 'super_admin.jobs.manage',         'pattern' => 'super_admin.jobs.*',         'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'],
                        ['name' => 'Companies',       'route' => 'super_admin.companies.manage',    'pattern' => 'super_admin.companies.*',    'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'],
                        ['name' => 'Applications',    'route' => 'super_admin.applications.manage', 'pattern' => 'super_admin.applications.*', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
                    ];
                @endphp
                @foreach ($platNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $url = Route::has($nav['route']) ? route($nav['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- LIVE CLASSES -->
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">LIVE CLASSES & WEBRTC</div>
            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $liveNavs = [
                        ['name' => 'Live Class Monitor', 'route' => 'super_admin.live-classes.manage',       'pattern' => 'super_admin.live-classes.manage',       'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'],
                        ['name' => 'Jitsi Credentials',  'route' => 'super_admin.live-classes.jitsi-config', 'pattern' => 'super_admin.live-classes.jitsi-config', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>'],
                    ];
                @endphp
                @foreach ($liveNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $url = Route::has($nav['route']) ? route($nav['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- FINANCE -->
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">FINANCE & GATEWAYS</div>
            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $finNavs = [
                        ['name' => 'Transactions & Refunds', 'route' => 'super_admin.finance.transactions',     'pattern' => 'super_admin.finance.transactions',     'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'],
                        ['name' => 'Gateway Credentials',    'route' => 'super_admin.finance.gateway-settings', 'pattern' => 'super_admin.finance.gateway-settings', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>'],
                    ];
                @endphp
                @foreach ($finNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $url = Route::has($nav['route']) ? route($nav['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- CONFIGURATION -->
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">CONFIGURATION & SEO</div>
            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $cfgNavs = [
                        ['name' => 'Website CMS Settings', 'route' => 'super_admin.configuration.website',      'pattern' => 'super_admin.configuration.website',      'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>'],
                        ['name' => 'SEO & Meta Tags',      'route' => 'super_admin.configuration.seo',          'pattern' => 'super_admin.configuration.seo',          'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'],
                        ['name' => 'API & Integrations',   'route' => 'super_admin.configuration.integrations', 'pattern' => 'super_admin.configuration.integrations', 'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'],
                    ];
                @endphp
                @foreach ($cfgNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $url = Route::has($nav['route']) ? route($nav['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- SECURITY & SYSTEM -->
        <div>
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">SECURITY & HARDWARE</div>
            <nav class="space-y-1 text-xs font-semibold">
                @php
                    $secNavs = [
                        ['name' => 'Roles & Permissions',  'route' => 'super_admin.roles.manage',           'pattern' => 'super_admin.roles.*',           'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>'],
                        ['name' => 'Security Policies',    'route' => 'super_admin.security.settings',      'pattern' => 'super_admin.security.settings',      'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'],
                        ['name' => 'Activity Audit Logs',  'route' => 'super_admin.security.audit-logs',    'pattern' => 'super_admin.security.audit-logs',    'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>'],
                        ['name' => 'Server System Health', 'route' => 'super_admin.system.health',          'pattern' => 'super_admin.system.health',          'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>'],
                        ['name' => 'Database Backups',     'route' => 'super_admin.system.backups',         'pattern' => 'super_admin.system.backups',         'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>'],
                        ['name' => 'Reports & Analytics',  'route' => 'super_admin.reports.analytics',      'pattern' => 'super_admin.reports.analytics',      'svg' => '<svg style="width: 16px; height: 16px; min-width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'],
                    ];
                @endphp
                @foreach ($secNavs as $nav)
                    @php
                        $isActive = Route::has($nav['route']) && request()->routeIs($nav['pattern']);
                        $url = Route::has($nav['route']) ? route($nav['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                        style="{{ $isActive ? 'background: #D62828; color: white; border-radius: 12px; font-weight: 800; box-shadow: 0 4px 14px rgba(214,40,40,0.35);' : 'color: #cbd5e1;' }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-white/10 hover:text-white transition-all text-decoration-none">
                        {!! $nav['svg'] !!}
                        <span>{{ $nav['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

    </div>

    <!-- Bottom: Logout button -->
    <div class="pt-4 border-t border-slate-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: #D62828; color: white;" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-extrabold text-xs hover:bg-red-700 transition-all shadow-md">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout Super Admin
            </button>
        </form>
    </div>

</aside>
