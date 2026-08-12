<div class="min-h-screen" style="background-color: #321847;">

    {{-- Header --}}
    <div class="relative py-16 overflow-hidden" style="background: linear-gradient(180deg, #321847 0%, #210f30 100%); border-bottom: 1px solid rgba(241,81,83,0.25);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <span class="text-xs font-bold text-[#f15153] uppercase tracking-[0.2em]">Real Graduate Outcomes</span>
            <h1 class="text-4xl font-black text-white tracking-tight mt-2 mb-3">Student <span class="text-[#f15153]">Success</span> Stories</h1>
            <p class="text-purple-300 max-w-xl">Discover how SkillBridge engineers secured senior roles at top tech companies with verified career placements.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($stories as $story)
                <div style="background: #251237; border: 1px solid rgba(241,81,83,0.2); border-radius: 24px;" class="p-8 space-y-6 group hover:border-[#f15153] transition-all">
                    <svg class="w-10 h-10 text-[#f15153]/30 group-hover:text-[#f15153] transition-colors" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                    </svg>

                    <p class="leading-relaxed italic text-sm" style="color: #d4c5e2;">"{{ $story->testimonial }}"</p>

                    <div style="border-top: 1px solid rgba(241,81,83,0.2);" class="pt-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#f15153] to-rose-400 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-[#f15153]/20">
                                {{ strtoupper(substr($story->student_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-white">{{ $story->student_name }}</p>
                                <p class="text-xs text-purple-300">{{ $story->job_title }} · <span class="text-[#f15153] font-semibold">{{ $story->company_name }}</span></p>
                            </div>
                        </div>
                        <div class="shrink-0 text-right">
                            <div class="text-sm font-black text-emerald-400">{{ $story->salary_package }}</div>
                            @if ($story->linkedin_url)
                                <a href="{{ $story->linkedin_url }}" target="_blank" class="text-[10px] text-purple-300 hover:text-[#f15153] transition-colors">LinkedIn →</a>
                            @endif
                        </div>
                    </div>

                    <div class="text-xs text-purple-300 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#f15153]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Completed: {{ $story->course_title }}
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-purple-300 py-20">No success stories published yet.</div>
            @endforelse
        </div>
    </div>
</div>
