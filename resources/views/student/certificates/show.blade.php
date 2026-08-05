<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - {{ $certificate->user?->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-900 min-h-screen text-slate-800 p-4 md:p-8 flex flex-col items-center justify-center">

    <!-- Action Toolbar -->
    <div class="w-full max-w-5xl mb-6 flex items-center justify-between gap-4">
        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs flex items-center gap-2 transition-all">
            ← Back to Dashboard
        </a>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs flex items-center gap-2 transition-all">
                🖨️ Print
            </button>

            <a href="{{ route('student.certificates.download', $certificate->id) }}" class="px-5 py-2 rounded-xl bg-[#D62828] hover:bg-red-700 text-white font-extrabold text-xs shadow-lg flex items-center gap-2 transition-all">
                ⬇️ Download Official PDF
            </a>
        </div>
    </div>

    <!-- Official Certificate Canvas Card -->
    <div class="w-full max-w-5xl bg-white rounded-3xl p-8 sm:p-12 md:p-16 shadow-2xl border-8 border-double border-amber-600/40 relative overflow-hidden">
        
        <!-- Subtle Corner Flourishes -->
        <div class="absolute top-0 left-0 w-24 h-24 border-t-8 border-l-8 border-amber-600 rounded-tl-3xl"></div>
        <div class="absolute top-0 right-0 w-24 h-24 border-t-8 border-r-8 border-amber-600 rounded-tr-3xl"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 border-b-8 border-l-8 border-amber-600 rounded-bl-3xl"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 border-b-8 border-r-8 border-amber-600 rounded-br-3xl"></div>

        <!-- Header Brand -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center gap-2 text-xs font-black text-amber-700 uppercase tracking-widest bg-amber-50 px-4 py-1.5 rounded-full border border-amber-200">
                <span>SkillBridge Enterprise LMS</span>
                <span>•</span>
                <span>Verified Credential</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black font-cinzel text-[#0B1F3A] tracking-wider uppercase pt-4">
                Certificate of Completion
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-semibold uppercase tracking-widest">
                This official credential certifies that
            </p>
        </div>

        <!-- Student Name -->
        <div class="my-8 text-center border-b-2 border-amber-600/30 pb-4 max-w-2xl mx-auto">
            <span class="text-3xl sm:text-5xl font-bold font-playfair text-[#D62828]">
                {{ $certificate->user?->name ?? 'Student' }}
            </span>
        </div>

        <!-- Accomplishment Text -->
        <div class="text-center space-y-2 max-w-2xl mx-auto">
            <p class="text-xs sm:text-sm text-slate-600 font-medium">
                has successfully completed all requirements, practical assessments, and curriculum modules for the course:
            </p>
            <h2 class="text-xl sm:text-3xl font-extrabold text-[#0B1F3A]">
                {{ $certificate->course?->title ?? 'Full-Stack Software Architecture' }}
            </h2>
        </div>

        <!-- Signatures & Seal Footer -->
        <div class="mt-12 sm:mt-16 pt-8 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-8 items-center text-center">
            <!-- Issue Date -->
            <div class="space-y-1">
                <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Date Issued</div>
                <div class="text-sm font-extrabold text-[#0B1F3A]">
                    {{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->format('F d, Y') : now()->format('F d, Y') }}
                </div>
            </div>

            <!-- Official Gold Stamp -->
            <div class="flex flex-col items-center justify-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-amber-600 via-amber-400 to-amber-200 text-white font-extrabold flex flex-col items-center justify-center shadow-xl border-4 border-white transform rotate-6">
                    <span class="text-[10px] uppercase font-black">Official</span>
                    <span class="text-xl">🏆</span>
                    <span class="text-[9px] uppercase font-bold">Verified</span>
                </div>
            </div>

            <!-- Certificate Hash & UUID -->
            <div class="space-y-1 sm:text-right">
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Credential ID & Hash</div>
                <div class="font-mono text-[10px] text-slate-700 font-bold truncate">
                    UUID: {{ substr($certificate->uuid, 0, 18) }}...
                </div>
                <div class="font-mono text-[9px] text-slate-400 truncate">
                    Hash: {{ substr($certificate->certificate_hash ?? md5($certificate->id), 0, 20) }}...
                </div>
            </div>
        </div>
    </div>
</body>
</html>
