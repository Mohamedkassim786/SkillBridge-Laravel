<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SkillBridge - Enterprise Software Learning & Career Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans antialiased text-slate-900 bg-slate-50 flex flex-col justify-between">
    <!-- Top Sticky Glass Navbar -->
    <header class="sticky top-0 z-50 bg-[#0B1F3A]/95 backdrop-blur-md border-b border-white/10 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#D62828] flex items-center justify-center font-extrabold text-xl text-white shadow-lg shadow-[#D62828]/30">
                    SB
                </div>
                <span class="text-2xl font-black tracking-tight text-white">SkillBridge</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#features" class="hover:text-white transition-colors">Platform Features</a>
                <a href="#roles" class="hover:text-white transition-colors">Access Portals</a>
                <a href="#credentials" class="hover:text-white transition-colors">Test Accounts</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-lg text-sm font-semibold text-white hover:text-slate-200 transition-colors">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-lg shadow-[#D62828]/25 transition-all">
                    Student Register
                </a>
            </div>
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="flex-grow">
        <section class="bg-[#0B1F3A] text-white py-20 lg:py-28 relative overflow-hidden">
            <!-- Decorative Glow Backgrounds -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#D62828]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 right-0 w-[30rem] h-[30rem] bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                @if (isset($roleTitle))
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-sm font-semibold mb-6">
                        ✓ Currently Viewing: {{ $roleTitle }}
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-slate-200 text-xs font-semibold tracking-wide uppercase backdrop-blur-md border border-white/10 mb-6">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#D62828] animate-pulse"></span>
                        Enterprise Software Learning & Recruitment Platform
                    </div>
                @endif

                <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white max-w-4xl mx-auto leading-tight">
                    Bridge Software Learning with Career Placement.
                </h1>

                <p class="mt-6 text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
                    Production-grade learning portal with enforced sequential lesson unlocking, AI-powered ATS resume scoring, tamper-proof certificates, and direct hiring matching.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#D62828] hover:bg-[#b7102a] text-white font-bold text-base shadow-xl shadow-[#D62828]/30 transition-all flex items-center justify-center gap-2">
                        <span>Sign In to Unified Portal</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-semibold text-base backdrop-blur-md transition-all">
                        Register as Student
                    </a>
                </div>
            </div>
        </section>

        <!-- Test Accounts Demo Section -->
        <section id="credentials" class="py-16 bg-slate-100 border-y border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Test Accounts & Role Redirection</h2>
                    <p class="mt-2 text-slate-600 text-sm">All roles authenticate through the single unified login page and automatically redirect to their respective dashboard.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Student Card -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-4">
                                ST
                            </div>
                            <h3 class="text-lg font-bold text-[#0B1F3A]">Student Account</h3>
                            <p class="text-xs text-slate-500 mt-1">Learns courses, tracks progress, builds resume, applies for jobs.</p>
                            <div class="mt-4 p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs font-mono">
                                <div><span class="text-slate-400">Email:</span> student@skillbridge.com</div>
                                <div><span class="text-slate-400">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="mt-6 w-full py-2.5 text-center rounded-lg bg-[#0B1F3A] text-white font-semibold text-xs hover:bg-slate-900 transition-colors">
                            Sign In as Student →
                        </a>
                    </div>

                    <!-- Staff / Trainer Card -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center mb-4">
                                TR
                            </div>
                            <h3 class="text-lg font-bold text-[#0B1F3A]">Staff (Trainer) Account</h3>
                            <p class="text-xs text-slate-500 mt-1">Authors courses, manages video lessons, evaluates quizzes.</p>
                            <div class="mt-4 p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs font-mono">
                                <div><span class="text-slate-400">Email:</span> staff@skillbridge.com</div>
                                <div><span class="text-slate-400">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="mt-6 w-full py-2.5 text-center rounded-lg bg-[#0B1F3A] text-white font-semibold text-xs hover:bg-slate-900 transition-colors">
                            Sign In as Trainer →
                        </a>
                    </div>

                    <!-- Admin Card -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 font-bold flex items-center justify-center mb-4">
                                AD
                            </div>
                            <h3 class="text-lg font-bold text-[#0B1F3A]">Admin Account</h3>
                            <p class="text-xs text-slate-500 mt-1">Audits courses, manages taxonomy, approves company verification.</p>
                            <div class="mt-4 p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs font-mono">
                                <div><span class="text-slate-400">Email:</span> admin@skillbridge.com</div>
                                <div><span class="text-slate-400">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="mt-6 w-full py-2.5 text-center rounded-lg bg-[#0B1F3A] text-white font-semibold text-xs hover:bg-slate-900 transition-colors">
                            Sign In as Admin →
                        </a>
                    </div>

                    <!-- Super Admin Card -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-rose-100 text-[#D62828] font-bold flex items-center justify-center mb-4">
                                SA
                            </div>
                            <h3 class="text-lg font-bold text-[#0B1F3A]">Super Admin Account</h3>
                            <p class="text-xs text-slate-500 mt-1">Full system access, commission config, audit logs, gateway credentials.</p>
                            <div class="mt-4 p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs font-mono">
                                <div><span class="text-slate-400">Email:</span> superadmin@skillbridge.com</div>
                                <div><span class="text-slate-400">Pass:</span> SkillBridge2026!</div>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="mt-6 w-full py-2.5 text-center rounded-lg bg-[#D62828] text-white font-semibold text-xs hover:bg-[#b7102a] transition-colors">
                            Sign In as Super Admin →
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feature Grid Section -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Enterprise Architectural Security & Quality</h2>
                    <p class="mt-3 text-slate-600">Built with SOLID principles, Spatie Single-Source-of-Truth RBAC, rate-limited lockout protection, and Livewire 3 interactive components.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 rounded-2xl border border-slate-200 bg-slate-50">
                        <div class="w-12 h-12 rounded-xl bg-[#0B1F3A] text-white flex items-center justify-center font-bold text-xl mb-6">
                            🔒
                        </div>
                        <h3 class="text-xl font-bold text-[#0B1F3A]">Account Lockout Security</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Maximum 5 failed login attempts trigger an automated 15-minute lockout, security audit log entry, and notification event.
                        </p>
                    </div>

                    <div class="p-8 rounded-2xl border border-slate-200 bg-slate-50">
                        <div class="w-12 h-12 rounded-xl bg-[#D62828] text-white flex items-center justify-center font-bold text-xl mb-6">
                            📊
                        </div>
                        <h3 class="text-xl font-bold text-[#0B1F3A]">Profile Completion Service</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Autonomous completion algorithm calculates student profile readiness (0-100%) and redirects students to complete profile details upon login.
                        </p>
                    </div>

                    <div class="p-8 rounded-2xl border border-slate-200 bg-slate-50">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xl mb-6">
                            💻
                        </div>
                        <h3 class="text-xl font-bold text-[#0B1F3A]">Active Session Control</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Comprehensive active sessions view tracking browser, device, OS, IP address, and single-click multi-device revocation.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#0B1F3A] text-slate-400 py-8 border-t border-white/10 text-center text-sm">
        <div class="max-w-7xl mx-auto px-4">
            <p>© 2026 SkillBridge Platform. Production-grade software learning & career portal.</p>
        </div>
    </footer>
</body>
</html>
