<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" style="background-color: #321847;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SkillBridge - Enterprise Software Learning & Career Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans antialiased text-purple-50 flex flex-col justify-between" style="background-color: #321847;">
    <!-- Top Sticky Glass Navbar -->
    <header class="sticky top-0 z-50 text-white" style="background-color: rgba(50,24,71,0.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(241,81,83,0.25);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#f15153] flex items-center justify-center font-extrabold text-xl text-white shadow-md shadow-[#f15153]/30">
                    SB
                </div>
                <span class="text-2xl font-black tracking-tight text-white">SkillBridge</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium" style="color: #d4c5e2;">
                <a href="#features" class="hover:text-[#f15153] transition-colors">Platform Features</a>
                <a href="#roles" class="hover:text-[#f15153] transition-colors">Access Portals</a>
                <a href="#credentials" class="hover:text-[#f15153] transition-colors">Test Accounts</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-lg text-sm font-semibold text-white hover:text-[#f15153] transition-colors" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-lg bg-[#f15153] hover:opacity-90 text-white font-semibold text-sm shadow-md shadow-[#f15153]/30 transition-all">
                    Student Register
                </a>
            </div>
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="flex-grow">
        <section class="text-white py-20 lg:py-28 relative overflow-hidden" style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.2);">
            <!-- Decorative Glow Backgrounds -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#f15153]/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 right-0 w-[30rem] h-[30rem] bg-purple-600/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                @if (isset($roleTitle))
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 text-sm font-semibold mb-6">
                        ✓ Currently Viewing: {{ $roleTitle }}
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[#f15153] text-xs font-bold tracking-wide uppercase mb-6" style="background: rgba(241,81,83,0.15); border: 1px solid rgba(241,81,83,0.3);">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#f15153] animate-pulse"></span>
                        Enterprise Software Learning & Recruitment Platform
                    </div>
                @endif

                <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white max-w-4xl mx-auto leading-tight">
                    Bridge Software Learning with Career Placement.
                </h1>

                <p class="mt-6 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed" style="color: #d4c5e2;">
                    Production-grade learning portal with enforced sequential lesson unlocking, AI-powered ATS resume scoring, tamper-proof certificates, and direct hiring matching.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" style="background-color: #f15153; box-shadow: 0 6px 20px rgba(241,81,83,0.4);" class="w-full sm:w-auto px-8 py-4 rounded-xl hover:opacity-90 text-white font-bold text-base transition-all flex items-center justify-center gap-2">
                        <span>Sign In to Unified Portal</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('register') }}" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);" class="w-full sm:w-auto px-8 py-4 rounded-xl text-white font-semibold text-base hover:bg-white/15 transition-all">
                        Register as Student
                    </a>
                </div>
            </div>
        </section>

        <!-- Test Accounts Demo Section -->
        <section id="credentials" class="py-16" style="background: #251237; border-bottom: 1px solid rgba(241,81,83,0.2);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Test Accounts & Role Redirection</h2>
                    <p class="mt-2 text-sm" style="color: #a997be;">All roles authenticate through the single unified login page and automatically redirect to their respective dashboard.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Student Card -->
                    <div class="p-6 rounded-2xl shadow-lg flex flex-col justify-between transition-shadow" style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.08);">
                        <div>
                            <div class="w-10 h-10 rounded-xl font-bold flex items-center justify-center mb-4" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                                ST
                            </div>
                            <h3 class="text-lg font-bold text-white">Student Account</h3>
                            <p class="text-xs mt-1" style="color: #a997be;">Learns courses, tracks progress, builds resume, applies for jobs.</p>
                            <div class="mt-4 p-3 rounded-lg text-xs font-mono" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: #d4c5e2;">
                                <div><span style="color: #8e7c9f;">Email:</span> student@skillbridge.com</div>
                                <div><span style="color: #8e7c9f;">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" style="background: #f15153; color: white;" class="mt-6 w-full py-2.5 text-center rounded-lg font-semibold text-xs hover:opacity-90 transition-opacity">
                            Sign In as Student →
                        </a>
                    </div>

                    <!-- Staff / Trainer Card -->
                    <div class="p-6 rounded-2xl shadow-lg flex flex-col justify-between transition-shadow" style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.08);">
                        <div>
                            <div class="w-10 h-10 rounded-xl font-bold flex items-center justify-center mb-4" style="background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.3);">
                                TR
                            </div>
                            <h3 class="text-lg font-bold text-white">Staff (Trainer) Account</h3>
                            <p class="text-xs mt-1" style="color: #a997be;">Authors courses, manages video lessons, evaluates quizzes.</p>
                            <div class="mt-4 p-3 rounded-lg text-xs font-mono" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: #d4c5e2;">
                                <div><span style="color: #8e7c9f;">Email:</span> staff@skillbridge.com</div>
                                <div><span style="color: #8e7c9f;">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" style="background: #f15153; color: white;" class="mt-6 w-full py-2.5 text-center rounded-lg font-semibold text-xs hover:opacity-90 transition-opacity">
                            Sign In as Trainer →
                        </a>
                    </div>

                    <!-- Admin Card -->
                    <div class="p-6 rounded-2xl shadow-lg flex flex-col justify-between transition-shadow" style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.08);">
                        <div>
                            <div class="w-10 h-10 rounded-xl font-bold flex items-center justify-center mb-4" style="background: rgba(168,85,247,0.15); color: #c084fc; border: 1px solid rgba(168,85,247,0.3);">
                                AD
                            </div>
                            <h3 class="text-lg font-bold text-white">Admin Account</h3>
                            <p class="text-xs mt-1" style="color: #a997be;">Audits courses, manages taxonomy, approves company verification.</p>
                            <div class="mt-4 p-3 rounded-lg text-xs font-mono" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: #d4c5e2;">
                                <div><span style="color: #8e7c9f;">Email:</span> admin@skillbridge.com</div>
                                <div><span style="color: #8e7c9f;">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" style="background: #f15153; color: white;" class="mt-6 w-full py-2.5 text-center rounded-lg font-semibold text-xs hover:opacity-90 transition-opacity">
                            Sign In as Admin →
                        </a>
                    </div>

                    <!-- Super Admin Card -->
                    <div class="p-6 rounded-2xl shadow-lg flex flex-col justify-between transition-shadow" style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.08);">
                        <div>
                            <div class="w-10 h-10 rounded-xl font-bold flex items-center justify-center mb-4" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                                SA
                            </div>
                            <h3 class="text-lg font-bold text-white">Super Admin Account</h3>
                            <p class="text-xs mt-1" style="color: #a997be;">Full system access, commission config, audit logs, gateway credentials.</p>
                            <div class="mt-4 p-3 rounded-lg text-xs font-mono" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: #d4c5e2;">
                                <div><span style="color: #8e7c9f;">Email:</span> superadmin@skillbridge.com</div>
                                <div><span style="color: #8e7c9f;">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" style="background: #f15153; color: white;" class="mt-6 w-full py-2.5 text-center rounded-lg font-semibold text-xs hover:opacity-90 transition-opacity">
                            Sign In as Super Admin →
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature Grid Section -->
        <section id="features" class="py-20" style="background: #321847;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Enterprise Architectural Security & Quality</h2>
                    <p class="mt-3 text-sm" style="color: #a997be;">Built with SOLID principles, Spatie Single-Source-of-Truth RBAC, rate-limited lockout protection, and Livewire 3 interactive components.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 rounded-2xl shadow-lg" style="background: #251237; border: 1px solid rgba(241,81,83,0.2);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-xl mb-6" style="background: rgba(241,81,83,0.15); color: #f15153; border: 1px solid rgba(241,81,83,0.3);">
                            🔒
                        </div>
                        <h3 class="text-xl font-bold text-white">Account Lockout Security</h3>
                        <p class="mt-2 text-sm leading-relaxed" style="color: #a997be;">
                            Maximum 5 failed login attempts trigger an automated 15-minute lockout, security audit log entry, and notification event.
                        </p>
                    </div>

                    <div class="p-8 rounded-2xl shadow-lg" style="background: #251237; border: 1px solid rgba(241,81,83,0.2);">
                        <div class="w-12 h-12 rounded-xl text-white flex items-center justify-center font-bold text-xl mb-6" style="background: #f15153;">
                            📊
                        </div>
                        <h3 class="text-xl font-bold text-white">Profile Completion Service</h3>
                        <p class="mt-2 text-sm leading-relaxed" style="color: #a997be;">
                            Autonomous completion algorithm calculates student profile readiness (0-100%) and redirects students to complete profile details upon login.
                        </p>
                    </div>

                    <div class="p-8 rounded-2xl shadow-lg" style="background: #251237; border: 1px solid rgba(241,81,83,0.2);">
                        <div class="w-12 h-12 rounded-xl text-white flex items-center justify-center font-bold text-xl mb-6" style="background: rgba(255,255,255,0.1);">
                            💻
                        </div>
                        <h3 class="text-xl font-bold text-white">Active Session Control</h3>
                        <p class="mt-2 text-sm leading-relaxed" style="color: #a997be;">
                            Comprehensive active sessions view tracking browser, device, OS, IP address, and single-click multi-device revocation.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="py-8 text-center text-sm" style="background-color: #210f30; color: #8e7c9f; border-top: 1px solid rgba(241,81,83,0.2);">
        <div class="max-w-7xl mx-auto px-4">
            <p>© 2026 SkillBridge Platform. Production-grade software learning & career portal.</p>
        </div>
    </footer>
</body>
</html>
