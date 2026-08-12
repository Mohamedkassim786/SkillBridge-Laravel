<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #321847;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SkillBridge Authentication' }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-white" style="background-color: #321847;">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Desktop Left Panel: Violet Hero Banner -->
        <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 text-white p-12 flex-col justify-between relative overflow-hidden" style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-right: 1px solid rgba(241,81,83,0.2);">
            <!-- Background Glow Effects -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#f15153]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-600/15 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Brand Header -->
            <div class="relative z-10">
                <a href="/" class="flex items-center gap-3 text-decoration-none">
                    <div class="w-10 h-10 rounded-xl bg-[#f15153] flex items-center justify-center font-extrabold text-xl text-white shadow-lg shadow-[#f15153]/30">
                        SB
                    </div>
                    <span class="text-2xl font-black tracking-tight text-white">SkillBridge</span>
                </a>
            </div>

            <!-- Middle Feature Showcase -->
            <div class="relative z-10 my-auto max-w-lg space-y-7">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black tracking-[0.18em] uppercase" style="background: rgba(241,81,83,0.25); color: #ffffff; border: 1.5px solid #f15153;">
                    <span class="w-2 h-2 rounded-full bg-[#f15153] animate-pulse"></span>
                    AUTHENTICATION PORTAL
                </div>

                <h1 class="text-4xl xl:text-5xl font-black tracking-tight leading-[1.15]">
                    <span class="text-white">Accelerate Your</span><br>
                    <span class="text-[#f15153]">Software Career.</span>
                </h1>

                <p class="text-base sm:text-lg leading-relaxed font-medium" style="color: #e5d8f6;">
                    Access your course progress, interactive coding labs, verified skill credentials, and exclusive job opportunities.
                </p>

                <!-- Key Value Badges -->
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl backdrop-blur-md" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(241,81,83,0.3);">
                        <div class="text-3xl font-black text-[#f15153]">100%</div>
                        <div class="text-xs font-bold uppercase tracking-wider mt-1" style="color: #d4c5e2;">Verified Credentials</div>
                    </div>
                    <div class="p-4 rounded-2xl backdrop-blur-md" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15);">
                        <div class="text-3xl font-black text-white">98%</div>
                        <div class="text-xs font-bold uppercase tracking-wider mt-1" style="color: #d4c5e2;">Career Placement</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Testimonial Banner -->
            <div class="relative z-10 pt-6" style="border-top: 1px solid rgba(255,255,255,0.12);">
                <p class="text-sm italic font-medium" style="color: #e5d8f6;">
                    "SkillBridge gave me the structured learning path and verified skills I needed to step confidently into a senior engineering role."
                </p>
                <div class="mt-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#f15153] flex items-center justify-center font-black text-xs text-white shadow-md shadow-[#f15153]/30">
                        SB
                    </div>
                    <div>
                        <div class="text-sm font-extrabold text-white">Senior Full-Stack Engineer</div>
                        <div class="text-xs font-medium" style="color: #a997be;">SkillBridge Graduate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right / Mobile Primary Column: Auth Form Area -->
        <div class="w-full lg:w-7/12 xl:w-1/2 flex flex-col justify-between min-h-screen py-8 px-4 sm:px-6 lg:px-16 xl:px-24" style="background-color: #251237;">
            
            <!-- Top Right Nav Bar -->
            <div class="flex items-center justify-between w-full mb-8">
                <!-- Mobile Brand Bar -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 lg:hidden text-decoration-none">
                    <div class="w-9 h-9 rounded-lg bg-[#f15153] flex items-center justify-center font-bold text-lg text-white">
                        SB
                    </div>
                    <span class="text-xl font-bold text-white">SkillBridge</span>
                </a>

                <!-- Back to Website Button (Turns Imperial Red on Hover/Touch) -->
                <a href="{{ route('home') }}"
                   onmouseover="this.style.backgroundColor='#f15153'; this.style.borderColor='#f15153';"
                   onmouseout="this.style.backgroundColor='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.2)';"
                   ontouchstart="this.style.backgroundColor='#f15153'; this.style.borderColor='#f15153';"
                   ontouchend="this.style.backgroundColor='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.2)';"
                   style="margin-left: auto !important; background-color: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); transition: all 0.2s ease-in-out;"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white font-extrabold text-xs text-decoration-none shadow-sm hover:shadow-lg hover:shadow-[#f15153]/40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Back to Website</span>
                </a>
            </div>

            <div class="mx-auto w-full max-w-md my-auto">
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 p-4 rounded-xl bg-amber-500/20 border border-amber-500/30 text-amber-300 text-sm font-medium">
                        {{ session('warning') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-300 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>

            <div class="h-6"></div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
