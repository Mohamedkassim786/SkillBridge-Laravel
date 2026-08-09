<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Matching Verified Job Vacancies</span>
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">Real hiring roles matched to your completed courses and skills profile</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="text-xs font-extrabold text-[#D62828] hover:underline">View All Jobs</a>
    </div>

    <div class="space-y-4">
        @foreach ($jobs as $j)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
                <div>
                    <div class="flex items-center gap-3">
                        <h4 class="text-base font-extrabold text-white">{{ $j->title }}</h4>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-black">
                            {{ $j->match_percent ?? 92 }}% Match
                        </span>
                    </div>
                    <div class="text-xs font-semibold text-slate-300 mt-1">
                        {{ $j->company_name ?? (is_string($j->company) ? $j->company : ($j->company?->name ?? 'Enterprise Tech')) }} • {{ $j->location }} • <span class="text-[#D62828] font-black">{{ $j->salary }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach ($j->skills ?? ['Laravel', 'Livewire', 'MySQL'] as $s)
                            <span style="background: #0B1F3A; border: 1px solid #1e3a5f;" class="px-2 py-0.5 rounded-md text-[10px] font-bold text-slate-300">{{ $s }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-2 whitespace-nowrap">
                    <button style="border: 1px solid #1e3a5f;" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition-colors" title="Bookmark Job">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('jobs.index') }}" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-black text-xs shadow-md transition-all text-decoration-none">
                        Easy Apply
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
