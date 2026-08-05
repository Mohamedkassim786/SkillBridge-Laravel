<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>📜 Verified Certificates</span>
        </h3>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($certificates as $cert)
            <div class="p-4 rounded-2xl bg-[#0B1F3A] text-white border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
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
                    <a href="{{ route('student.certificates.view', $cert->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all">
                        View 👁️
                    </a>
                    <a href="{{ route('student.certificates.download', $cert->id) }}" class="px-4 py-2 rounded-xl bg-[#D62828] hover:bg-red-700 text-white font-extrabold text-xs shadow-sm transition-all">
                        Download PDF ⬇️
                    </a>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-500">Complete 100% of a course to earn your verified certificate!</div>
        @endforelse
    </div>
</div>
