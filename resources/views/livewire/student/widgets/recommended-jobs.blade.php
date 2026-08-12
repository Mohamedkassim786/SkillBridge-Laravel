<div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Matching Verified Job Vacancies</span>
            </h3>
            <p class="text-xs mt-0.5" style="color: #a997be;">Real hiring roles matched to your completed courses and skills profile</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="text-xs font-extrabold text-[#f15153] hover:underline">View All Jobs</a>
    </div>

    <div class="space-y-4">
        @foreach ($jobs as $j)
            <div style="background: #1e0d2d; border: 1px solid rgba(255,255,255,0.1);" class="p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
                <div>
                    <div class="flex items-center gap-3">
                        <h4 class="text-base font-extrabold text-white">{{ $j->title }}</h4>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-black">
                            {{ $j->match_percent ?? 92 }}% Match
                        </span>
                    </div>
                    <div class="text-xs font-semibold text-white mt-1">
                        {{ $j->company_name ?? (is_string($j->company) ? $j->company : ($j->company?->name ?? 'Enterprise Tech')) }} • {{ $j->location }} • <span class="text-[#f15153] font-black">{{ $j->salary }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach ($j->skills ?? ['Laravel', 'Livewire', 'MySQL'] as $s)
                            <span style="background: rgba(241,81,83,0.15); border: 1px solid rgba(241,81,83,0.3);" class="px-2 py-0.5 rounded-md text-[10px] font-bold text-white">{{ $s }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-2 whitespace-nowrap">
                    <button style="border: 1px solid rgba(255,255,255,0.15);" class="p-2 rounded-xl text-purple-200 hover:text-white hover:bg-white/10 transition-colors" title="Bookmark Job">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('jobs.index') }}" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="px-5 py-2.5 rounded-xl text-white font-black text-xs transition-all text-decoration-none">
                        Easy Apply
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
