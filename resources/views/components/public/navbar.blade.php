@php
    $siteName = \App\Models\CmsSetting::get('site_name', 'SkillBridge');
@endphp

<style>
    .nav-desktop {
        display: none;
    }

    .nav-mobile-btn {
        display: flex;
    }

    .nav-mobile-menu-wrapper {
        display: none;
    }

    @media (min-width: 1024px) {
        .nav-desktop {
            display: flex;
        }

        .nav-mobile-btn {
            display: none;
        }
    }
</style>

<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 text-white shadow-md"
    style="background-color: rgba(50,24,71,0.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(241,81,83,0.25);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="display:flex; align-items:center; justify-content:space-between; height:64px;">

            <!-- Brand -->
            <a href="{{ route('home') }}"
                style="display:flex; align-items:center; gap:10px; flex-shrink:0; text-decoration:none; user-select:none;">
                <div
                    style="width:38px; height:38px; border-radius:10px; background:#f15153; display:flex; align-items:center; justify-content:center; color:white; font-weight:900; font-size:17px; box-shadow:0 4px 14px rgba(241,81,83,0.4); flex-shrink:0;">
                    S
                </div>
                <span
                    style="font-size:18px; font-weight:800; color:white; letter-spacing:-0.02em; text-decoration:none;">{{ $siteName }}</span>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="nav-desktop"
                style="align-items:center; gap:6px; flex:1; justify-content:center; margin:0 16px;">
                @php
                    $links = [
                        ['Home', route('home'), 'home'],
                        ['Courses', route('courses.index'), 'courses.*'],
                        ['Jobs', route('jobs.index'), 'jobs.*'],
                        ['Pricing', route('pricing'), 'pricing'],
                        ['About', route('about'), 'about'],
                        ['Contact Us', route('contact'), 'contact'],
                    ];
                @endphp
                @foreach ($links as [$label, $url, $route])
                    @php $active = request()->routeIs($route); @endphp
                    <a href="{{ $url }}" style="padding:6px 14px; font-size:13.5px; font-weight:700; border-radius:7px; white-space:nowrap; text-decoration:none; transition:all 0.15s;
                                   color:{{ $active ? '#f15153' : '#d4c5e2' }};
                                   background:{{ $active ? 'rgba(241,81,83,0.15)' : 'transparent' }};"
                        onmouseover="if(!{{ $active ? 'true' : 'false' }}) { this.style.color='#fff'; this.style.background='rgba(255,255,255,0.08)'; }"
                        onmouseout="if(!{{ $active ? 'true' : 'false' }}) { this.style.color='#d4c5e2'; this.style.background='transparent'; }">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <!-- Desktop Auth Buttons -->
            <div class="nav-desktop" style="align-items:center; gap:12px; flex-shrink:0;">
                @auth
                    @if (in_array(auth()->user()->role, ['admin', 'super_admin']))
                        <a href="{{ route('admin.courses.manage') }}"
                            style="padding:8px 16px; border-radius:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); color:white; font-size:13px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin
                        </a>
                    @endif
                    <a href="{{ route('student.dashboard') }}"
                        style="padding:9px 20px; border-radius:10px; background:#f15153; color:white; font-size:13.5px; font-weight:800; text-decoration:none; box-shadow:0 4px 14px rgba(241,81,83,0.4);">
                        Dashboard ➔
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        style="padding:9px 20px; border-radius:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); color:white; font-size:13.5px; font-weight:700; text-decoration:none;">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                        style="padding:9px 20px; border-radius:10px; background:#f15153; color:white; font-size:13.5px; font-weight:800; text-decoration:none; box-shadow:0 4px 14px rgba(241,81,83,0.4);">
                        Get Started
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="nav-mobile-btn">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    style="padding:8px; border-radius:8px; color:#d4c5e2; background:transparent; border:none; cursor:pointer;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='#fff';"
                    onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown -->
    <div x-show="mobileMenuOpen" x-cloak
        style="background:#251237; border-top:1px solid rgba(241,81,83,0.2); padding:12px 16px 16px;">
        <div style="display:flex; flex-direction:column; gap:2px; font-size:13.5px; font-weight:700; color:#d4c5e2;">
            <a href="{{ route('home') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">Home</a>
            <a href="{{ route('courses.index') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">Courses</a>
            <a href="{{ route('jobs.index') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">Jobs</a>
            <a href="{{ route('pricing') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">Pricing</a>
            <a href="{{ route('about') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">About</a>
            <a href="{{ route('contact') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">Contact Us</a>
            <a href="{{ route('faq') }}"
                style="padding:10px 12px; border-radius:8px; text-decoration:none; color:inherit;"
                onmouseover="this.style.background='rgba(241,81,83,0.15)'; this.style.color='#f15153';"
                onmouseout="this.style.background='transparent'; this.style.color='#d4c5e2';">FAQ</a>
        </div>
        <div
            style="margin-top:12px; padding-top:12px; border-top:1px solid rgba(255,255,255,0.1); display:flex; flex-direction:column; gap:8px;">
            @auth
                <a href="{{ route('student.dashboard') }}"
                    style="text-align:center; padding:10px; border-radius:10px; background:#f15153; color:white; font-weight:800; font-size:13px; text-decoration:none;">My
                    Dashboard ➔</a>
            @else
                <a href="{{ route('login') }}"
                    style="text-align:center; padding:10px; border-radius:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); color:white; font-weight:700; font-size:13px; text-decoration:none;">Log
                    In</a>
                <a href="{{ route('register') }}"
                    style="text-align:center; padding:10px; border-radius:10px; background:#f15153; color:white; font-weight:800; font-size:13px; text-decoration:none;">Get
                    Started</a>
            @endauth
        </div>
    </div>
</header>