<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            <span>Verified Certificates</span>
        </h3>
        <a href="{{ route('student.certificates.index') }}" class="text-xs font-extrabold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($certificates as $cert)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
                <div>
                    <div class="text-sm font-extrabold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span>{{ $cert->course?->title ?? $cert->title ?? 'Certified Course Completion' }}</span>
                    </div>
                    <div class="text-xs text-slate-300 mt-1">
                        Issued: <strong class="text-emerald-400">{{ $cert->issued_at ? \Carbon\Carbon::parse($cert->issued_at)->format('M d, Y') : ($cert->issue_date ?? 'Aug 2026') }}</strong> •
                        UUID: <span class="font-mono text-[11px] text-slate-400">{{ substr($cert->uuid, 0, 13) }}...</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('student.certificates.view', $cert->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all text-decoration-none flex items-center gap-1.5">
                        <span>View</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <a href="{{ route('student.certificates.download', $cert->id) }}" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-sm transition-all text-decoration-none flex items-center gap-1.5">
                        <span>Download PDF</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-400">Complete 100% of a course to earn your verified certificate!</div>
        @endforelse
    </div>
</div>
