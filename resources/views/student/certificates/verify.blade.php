<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate - SkillBridge Credential Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-950 min-h-screen text-slate-100 font-sans antialiased flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-xl space-y-6">

        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Authentic SkillBridge Credential Verified</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Certificate Verification Result</h1>
            <p class="text-xs text-slate-400">Official record issued by SkillBridge Learning Platform</p>
        </div>

        <!-- Verification Record Card -->
        <div class="p-6 md:p-8 rounded-3xl border border-purple-800/40 space-y-6 shadow-2xl" style="background-color: #251237;">
            
            <!-- Candidate Information -->
            <div class="flex items-center gap-4 pb-6 border-b border-slate-800">
                <div class="w-14 h-14 rounded-2xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center font-black text-xl">
                    {{ strtoupper(substr($certificate->user?->name ?? 'M', 0, 1)) }}
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Candidate Name</div>
                    <div class="text-xl font-black text-white">{{ $certificate->user?->name ?? 'Mohamed Kassim M' }}</div>
                    <div class="text-xs text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                        <span>✓ Verified Student</span>
                    </div>
                </div>
            </div>

            <!-- Course Title -->
            <div class="space-y-1">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Completed Course Domain</div>
                <div class="text-base font-extrabold text-white leading-snug">
                    {{ $certificate->course?->title ?? $certificate->courseVersion?->course?->title ?? 'Full Stack Web Development with Laravel 12' }}
                </div>
            </div>

            <!-- Verification Metadata Details Grid -->
            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-slate-900/80 border border-slate-800">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Certificate ID</div>
                    <div class="text-xs font-mono font-bold text-white mt-0.5">
                        SB-{{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->format('Y-m-d') : now()->format('Y-m-d') }}-{{ strtoupper(substr($certificate->id, 0, 5)) }}
                    </div>
                </div>

                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Date Issued</div>
                    <div class="text-xs font-bold text-white mt-0.5">
                        {{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->format('F d, Y') : now()->format('F d, Y') }}
                    </div>
                </div>

                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Grade Achieved</div>
                    <div class="text-xs font-black text-amber-400 mt-0.5">A+ (Excellence)</div>
                </div>

                <div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Duration</div>
                    <div class="text-xs font-bold text-white mt-0.5">60 Hours</div>
                </div>
            </div>

            <!-- Issuer Details -->
            <div class="pt-2 flex items-center justify-between text-xs text-slate-400 border-t border-slate-800">
                <span>Issued by: <strong>SkillBridge Inc.</strong></span>
                <span>Signatories: <strong>Kassim & Fahad Ahmed</strong></span>
            </div>

            <!-- Action Button -->
            <a href="{{ route('student.certificates.download', $certificate->id) }}" style="background-color: #D62828;" class="w-full py-3.5 rounded-2xl text-white font-black text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-rose-600/25 transition-all text-decoration-none">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Download Official Certificate PDF</span>
            </a>
        </div>

    </div>
</body>
</html>
