<div class="max-w-4xl mx-auto space-y-8 text-white">
    <!-- Header -->
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30">
            🎙️ Real-Time AI Voice Interview
        </div>
        <h1 class="text-3xl font-black text-white">Practice Interviewing with Sarah</h1>
        <p class="text-sm text-slate-400 max-w-lg mx-auto">Select your role and start a natural, voice-to-voice mock interview with instant AI coaching feedback.</p>
    </div>

    <!-- Main Clean Setup Card -->
    <div class="rounded-3xl p-6 md:p-8 space-y-6 border border-slate-800 shadow-2xl" style="background-color: #0B1F3A;">
        <form wire:submit.prevent="startInterview" class="space-y-6">
            <!-- Role Selection -->
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">1. Select Target Job Role</label>
                <select wire:model="selectedRole" class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-rose-500 font-medium">
                    @foreach($rolesList as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Interview Type -->
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">2. Interview Focus</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @php
                        $types = [
                            'technical' => ['title' => 'Technical', 'icon' => '💻'],
                            'hr' => ['title' => 'HR / Recruiter', 'icon' => '👔'],
                            'behavioral' => ['title' => 'Behavioral', 'icon' => '🤝'],
                            'full_mock' => ['title' => 'Full Mock', 'icon' => '⚡'],
                        ];
                    @endphp
                    @foreach($types as $key => $meta)
                        <button type="button" 
                                wire:click="$set('interviewType', '{{ $key }}')"
                                class="p-3.5 rounded-2xl border text-center flex flex-col items-center justify-center gap-1 transition-all {{ $interviewType === $key ? 'bg-rose-500/20 border-rose-500 text-white shadow-lg shadow-rose-500/20' : 'bg-slate-900 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                            <span class="text-2xl">{{ $meta['icon'] }}</span>
                            <span class="text-xs font-bold">{{ $meta['title'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Experience Level -->
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">3. Experience Level</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach(['Fresher', '0-1 Years', '1-3 Years', '3-5 Years'] as $exp)
                        <button type="button" 
                                wire:click="$set('experienceLevel', '{{ $exp }}')"
                                class="py-3 px-3 rounded-2xl text-xs font-bold border text-center transition-all {{ $experienceLevel === $exp ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'bg-slate-900 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                            {{ $exp }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Resume Upload & Selection -->
            <div class="space-y-3 pt-2 border-t border-slate-800">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">4. Candidate Resume (Optional)</label>

                @if (session()->has('resume_success'))
                    <div class="p-3 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold flex items-center justify-between">
                        <span>✓ {{ session('resume_success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Dropdown for existing resumes -->
                    <div class="space-y-1">
                        <span class="text-[11px] text-slate-400">Select Existing Resume:</span>
                        <select wire:model="selectedResumeId" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-rose-500">
                            <option value="">No Specific Resume (General Practice)</option>
                            @foreach($resumes as $r)
                                <option value="{{ $r->id }}">{{ $r->title ?: 'Resume (' . $r->created_at->format('M d') . ')' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PDF Upload File input -->
                    <div class="space-y-1">
                        <span class="text-[11px] text-slate-400">Or Upload New PDF Resume:</span>
                        <div class="relative">
                            <input type="file" wire:model="resumeFile" accept=".pdf" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-300 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-rose-500 file:text-white hover:file:bg-rose-600 cursor-pointer">
                            <div wire:loading wire:target="resumeFile" class="text-[10px] text-rose-400 font-bold mt-1">
                                ⏳ Uploading & Analyzing Resume Content...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Button -->
            <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-rose-500 to-indigo-600 hover:from-rose-600 hover:to-indigo-700 text-white font-black text-sm uppercase tracking-wider shadow-xl shadow-rose-500/25 flex items-center justify-center gap-2 transition-all cursor-pointer">
                <span>🎙️ Start AI Voice Interview Now</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>
    </div>

    <!-- Past Sessions List -->
    @if($pastInterviews->isNotEmpty())
        <div class="rounded-3xl p-6 space-y-4 border border-slate-800" style="background-color: #0B1F3A;">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800 pb-3 flex items-center justify-between">
                <span>Recent Completed Sessions</span>
                <span class="text-slate-500 font-normal">{{ $pastInterviews->count() }} total</span>
            </h3>

            <div class="space-y-3">
                @foreach($pastInterviews->take(4) as $interview)
                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 flex items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-white">{{ $interview->role }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 text-rose-400 font-semibold uppercase">{{ $interview->interview_type }}</span>
                            </div>
                            <div class="text-[11px] text-slate-400">
                                📅 {{ $interview->created_at->format('M d, Y') }} • Score: <strong class="text-rose-400">{{ $interview->overall_score ?: 85 }}/100</strong>
                            </div>
                        </div>

                        <a href="{{ route('student.practice.mock.report', ['id' => $interview->id]) }}" class="px-4 py-2 rounded-xl bg-rose-500/20 text-rose-300 border border-rose-500/30 text-xs font-bold hover:bg-rose-500 hover:text-white transition-all">
                            View Report
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
