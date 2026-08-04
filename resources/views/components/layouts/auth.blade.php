<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
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
<body class="h-full font-sans antialiased text-slate-900 bg-slate-50">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Desktop Left Panel: Corporate Midnight Blue Hero Banner -->
        <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 bg-[#0B1F3A] text-white p-12 flex-col justify-between relative overflow-hidden">
            <!-- Background Glow Effects -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#D62828]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Brand Header -->
            <div class="relative z-10">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#D62828] flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-[#D62828]/30">
                        SB
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-white">SkillBridge</span>
                </a>
            </div>

            <!-- Middle Feature Showcase -->
            <div class="relative z-10 my-auto max-w-lg space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 text-slate-200 text-xs font-semibold tracking-wide uppercase backdrop-blur-md border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-[#D62828] animate-pulse"></span>
                    Enterprise Software Learning Platform
                </div>

                <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight leading-tight text-white">
                    Master Enterprise Software & Build Your Career.
                </h1>

                <p class="text-lg text-slate-300 leading-relaxed">
                    Gain verified certifications, track sequential lesson progress, build AI-scored resumes, and land top-tier tech roles.
                </p>

                <!-- Key Value Badges -->
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <div class="text-2xl font-bold text-[#D62828]">100%</div>
                        <div class="text-sm text-slate-300">Verified Certificates</div>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <div class="text-2xl font-bold text-blue-400">90%+</div>
                        <div class="text-sm text-slate-300">Watch Completion Gate</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Testimonial Banner -->
            <div class="relative z-10 pt-6 border-t border-white/10">
                <p class="text-sm italic text-slate-300">
                    "SkillBridge transformed my software career path. Enforced learning and verified certificates got me hired!"
                </p>
                <div class="mt-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#D62828] flex items-center justify-center font-bold text-xs text-white">
                        SB
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">Senior Software Engineer Student</div>
                        <div class="text-xs text-slate-400">SkillBridge Graduate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right / Mobile Primary Column: Auth Form Area -->
        <div class="w-full lg:w-7/12 xl:w-1/2 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-16 xl:px-24 bg-white">
            <!-- Mobile Brand Bar -->
            <div class="flex lg:hidden items-center justify-between mb-8 pb-4 border-b border-slate-200">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#D62828] flex items-center justify-center font-bold text-lg text-white">
                        SB
                    </div>
                    <span class="text-xl font-bold text-[#0B1F3A]">SkillBridge</span>
                </a>
            </div>

            <div class="mx-auto w-full max-w-md">
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium">
                        {{ session('warning') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
