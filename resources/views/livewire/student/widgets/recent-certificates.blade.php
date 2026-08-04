<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>📜 Verified Certificates</span>
        </h3>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($certificates as $cert)
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="text-sm font-bold text-[#0B1F3A]">{{ $cert->title }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Issued: {{ $cert->issue_date }} • UUID: <span class="font-mono text-[11px] text-slate-600">{{ substr($cert->uuid, 0, 13) }}...</span></div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="#" class="px-3 py-1.5 rounded-lg bg-[#0B1F3A] hover:bg-slate-900 text-white font-semibold text-xs transition-all">
                        Download PDF
                    </a>
                    <a href="#" class="px-3 py-1.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 font-semibold text-xs transition-all">
                        Verify QR
                    </a>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-500">Complete 100% of a course to earn your verified certificate!</div>
        @endforelse
    </div>
</div>
