<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <span>📜 Verified Certificates</span>
        </h3>
        <a href="{{ route('student.certificates.index') }}" class="text-xs font-extrabold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($certificates as $cert)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
                <div>
                    <div class="text-sm font-extrabold text-white flex items-center gap-2">
                        <span>📜 {{ $cert->course?->title ?? $cert->title ?? 'Certified Course Completion' }}</span>
                    </div>
                    <div class="text-xs text-slate-300 mt-1">
                        Issued: <strong class="text-emerald-400">{{ $cert->issued_at ? \Carbon\Carbon::parse($cert->issued_at)->format('M d, Y') : ($cert->issue_date ?? 'Aug 2026') }}</strong> •
                        UUID: <span class="font-mono text-[11px] text-slate-400">{{ substr($cert->uuid, 0, 13) }}...</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('student.certificates.view', $cert->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all text-decoration-none">
                        View 👁️
                    </a>
                    <a href="{{ route('student.certificates.download', $cert->id) }}" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-sm transition-all text-decoration-none">
                        Download PDF ⬇️
                    </a>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-400">Complete 100% of a course to earn your verified certificate!</div>
        @endforelse
    </div>
</div>
