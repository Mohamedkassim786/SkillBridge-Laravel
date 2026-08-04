<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
                <span>💼 Matching Verified Job Vacancies</span>
            </h3>
            <p class="text-xs text-slate-500">Real hiring roles matched to your completed courses and skills profile</p>
        </div>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">View All Jobs</a>
    </div>

    <div class="space-y-4">
        @foreach ($jobs as $j)
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-md transition-shadow">
                <div>
                    <div class="flex items-center gap-3">
                        <h4 class="text-base font-extrabold text-[#0B1F3A]">{{ $j->title }}</h4>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                            {{ $j->match_percent ?? 92 }}% Match
                        </span>
                    </div>
                    <div class="text-xs font-semibold text-slate-600 mt-1">
                        {{ $j->company }} • {{ $j->location }} • <span class="text-[#D62828] font-bold">{{ $j->salary }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach ($j->skills ?? ['Laravel', 'Livewire', 'MySQL'] as $s)
                            <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-semibold text-slate-600">{{ $s }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-2 whitespace-nowrap">
                    <button class="p-2 rounded-xl border border-slate-300 text-slate-500 hover:text-[#0B1F3A] hover:bg-white transition-colors" title="Bookmark Job">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </button>
                    <a href="#" class="px-5 py-2.5 rounded-xl bg-[#0B1F3A] hover:bg-slate-900 text-white font-bold text-xs shadow-md transition-all">
                        Easy Apply
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
