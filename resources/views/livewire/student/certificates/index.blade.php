<div class="space-y-6 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Verified Certificates</h1>
            <p class="text-xs text-slate-300 mt-1">Tamper-proof SHA-256 encrypted software completion certificates.</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-bold bg-white/10 px-4 py-2 rounded-2xl border border-white/10">
            <span>🎓 Total Earned: {{ $certificates->count() }}</span>
        </div>
    </div>

    <!-- CERTIFICATES GRID -->
    @if ($certificates->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($certificates as $cert)
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-black text-xl border border-rose-500/30">
                            🏆
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-[10px] font-black uppercase">VERIFIED</span>
                    </div>

                    <div>
                        <h3 class="font-extrabold text-base text-white leading-snug">{{ $cert->courseVersion?->course?->title ?? 'Enterprise Software Engineering' }}</h3>
                        <p class="text-xs text-slate-400 mt-1">Issued: {{ $cert->issued_at ? \Carbon\Carbon::parse($cert->issued_at)->format('F d, Y') : date('F d, Y') }}</p>
                    </div>

                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3 rounded-2xl text-[11px] font-mono text-slate-300 truncate">
                        UUID: {{ $cert->uuid }}
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ route('student.certificates.view', $cert->id) }}" target="_blank" class="flex-1 text-center py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition text-decoration-none">
                            👁️ View Certificate
                        </a>
                        <a href="{{ route('student.certificates.download', $cert->id) }}" style="background-color: #D62828;" class="flex-1 text-center py-2.5 text-white rounded-xl text-xs font-black transition text-decoration-none">
                            📥 Download PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-12 text-center shadow-xl space-y-3 text-white">
            <div class="text-4xl">🎓</div>
            <h3 class="font-extrabold text-base text-white">No Certificates Earned Yet</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto">Complete all lessons and pass course assessments in your enrolled courses to automatically unlock verified certificates.</p>
            <a href="{{ route('student.courses.index') }}" style="background-color: #D62828;" class="inline-block px-6 py-2.5 text-white rounded-xl text-xs font-black transition text-decoration-none">
                Continue Learning ➔
            </a>
        </div>
    @endif
</div>
