<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400 uppercase tracking-widest mb-1">
                <span>✉️ NVIDIA NIM AI (Llama 3.3 70B) + RAG Engine</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">AI Cover Letter Generator & PDF Suite</h1>
            <p class="text-xs text-slate-300 mt-1">Generate personalized, professional, ATS-optimized cover letters grounded in your actual skills and projects.</p>
        </div>
        <div class="flex items-center gap-3">
            @if (!empty($coverLetterOutput))
                <a href="{{ route('student.career.cover-letter.download-pdf') }}" target="_blank" style="background-color: #D62828;" class="px-6 py-3.5 text-white rounded-2xl text-xs font-black shadow-lg transition-all flex items-center gap-2 text-decoration-none hover:opacity-90">
                    <span>⬇️ Download Cover Letter PDF</span>
                </a>
            @endif
        </div>
    </div>

    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold flex items-center gap-2">
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-500/20 text-rose-300 border border-rose-500/30 text-xs font-bold flex items-center gap-2">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- LEFT COLUMN: INPUT FORM (5 COLUMNS) -->
        <div class="lg:col-span-5 space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-black text-white flex items-center gap-2">
                        <span>📝 Cover Letter Details</span>
                    </h3>
                    <button wire:click="generateCoverLetter" wire:loading.attr="disabled" style="background-color: #D62828;" class="px-5 py-2.5 text-white rounded-xl text-xs font-black shadow-md hover:bg-rose-700 transition flex items-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove wire:target="generateCoverLetter">⚡ Generate</span>
                        <span wire:loading wire:target="generateCoverLetter" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Generating...</span>
                        </span>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 mb-1">Target Job Title <span class="text-rose-400">*</span></label>
                            <input type="text" wire:model.live.debounce.300ms="targetRole" placeholder="e.g. Full Stack Developer" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 mb-1">Target Company Name <span class="text-rose-400">*</span></label>
                            <input type="text" wire:model.live.debounce.300ms="companyName" placeholder="e.g. Cognizant, Google" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Hiring Manager / Department (Optional)</label>
                        <input type="text" wire:model.live.debounce.300ms="hiringManager" placeholder="e.g. Hiring Manager / Talent Acquisition Team" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Applicant Name & Location <span class="text-rose-400">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model.live.debounce.300ms="fullName" placeholder="Your Full Name" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                            <input type="text" wire:model.live.debounce.300ms="location" placeholder="Pudukkottai, Tamil Nadu" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Key Technical Stack & Skills</label>
                        <input type="text" wire:model.live.debounce.300ms="skillsInput" placeholder="e.g. reactjs,nodejs,python,mongodb" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Core Projects & Achievements to Highlight</label>
                        <textarea wire:model.live.debounce.300ms="coreHighlights" rows="3" placeholder="Online learning management system using React.js, Node.js, Express.js and PostgreSQL. Built authentication, REST APIs and responsive frontend." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">Tone & Writing Style</label>
                        <select wire:model.live.debounce.300ms="toneStyle" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3.5 py-2 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                            <option value="Professional, confident, concise">Professional, confident, concise</option>
                            <option value="Professional and formal">Professional and formal</option>
                            <option value="Confident and energetic">Confident and energetic</option>
                            <option value="Entry-level professional">Entry-level professional</option>
                            <option value="Technical and professional">Technical and professional</option>
                            <option value="Warm but professional">Warm but professional</option>
                        </select>
                    </div>

                    <button wire:click="generateCoverLetter" wire:loading.attr="disabled" style="background-color: #D62828;" class="w-full py-3.5 rounded-xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove wire:target="generateCoverLetter">⚡ Generate Cover Letter with NVIDIA AI</span>
                        <span wire:loading wire:target="generateCoverLetter" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Generating your personalized cover letter...</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: LIVE COVER LETTER PAPER PREVIEW (7 COLUMNS) -->
        <div class="lg:col-span-7 space-y-6">
            <!-- PREVIEW STATUS CARD -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl flex items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Target Role & Company</div>
                        @if ($isAiGenerated)
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-[10px] font-black uppercase tracking-wide">✨ AI Generated</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-black text-white mt-0.5">
                        {{ $coverLetterData['target_role'] ?? ($targetRole ?: 'Job Title') }}
                        <span class="text-slate-400 font-normal">at {{ $coverLetterData['company'] ?? ($companyName ?: 'Company') }}</span>
                    </h3>
                </div>
                @if (!empty($coverLetterOutput))
                    <a href="{{ route('student.career.cover-letter.download-pdf') }}" target="_blank" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white font-black text-[11px] shadow-lg whitespace-nowrap text-decoration-none flex items-center gap-1.5 hover:opacity-90">
                        <span>⬇️ Download PDF</span>
                    </a>
                @endif
            </div>

            <!-- LIVE LETTER PAPER PREVIEW -->
            @if ($coverLetterOutput)
                <div style="background-color: #ffffff !important; color: #111827 !important;" class="rounded-xl p-10 shadow-2xl space-y-5 font-serif text-[13.5px] leading-relaxed border border-slate-300">
                    <!-- HEADER -->
                    <div style="border-bottom: 2px solid #000000; padding-bottom: 8px;">
                        <h1 style="color: #000000 !important;" class="text-xl font-bold uppercase tracking-wider m-0">{{ $fullName ?: 'Your Name' }}</h1>
                        <div style="color: #374151 !important;" class="text-xs mt-1">
                            @php
                                $contactParts = array_filter([$email, $phone, $location]);
                            @endphp
                            {{ implode(' • ', $contactParts) }}
                        </div>
                    </div>

                    <!-- DATE -->
                    <div style="color: #000000 !important;" class="font-bold text-xs">{{ date('F d, Y') }}</div>

                    <!-- RECIPIENT -->
                    <div style="color: #1f2937 !important;" class="text-xs leading-snug">
                        <div>{{ $coverLetterData['hiring_manager'] ?? ($hiringManager ?: 'Hiring Manager') }}</div>
                        <div style="color: #000000 !important;" class="font-bold">{{ $coverLetterData['company'] ?? ($companyName ?: 'Target Company') }}</div>
                    </div>

                    <!-- BODY PARAGRAPHS -->
                    <div style="color: #111827 !important;" class="text-xs text-left leading-relaxed space-y-4">
                        @if (!empty($coverLetterData['opening']))
                            <div style="color: #000000 !important;" class="font-bold mb-2">{{ $coverLetterData['greeting'] ?? 'Dear Hiring Manager,' }}</div>
                            <p class="leading-relaxed text-justify m-0">{{ $coverLetterData['opening'] }}</p>
                            @if (!empty($coverLetterData['experience_paragraph']))
                                <p class="leading-relaxed text-justify m-0">{{ $coverLetterData['experience_paragraph'] }}</p>
                            @endif
                            @if (!empty($coverLetterData['fit_paragraph']))
                                <p class="leading-relaxed text-justify m-0">{{ $coverLetterData['fit_paragraph'] }}</p>
                            @endif
                            @if (!empty($coverLetterData['closing_paragraph']))
                                <p class="leading-relaxed text-justify m-0">{{ $coverLetterData['closing_paragraph'] }}</p>
                            @endif
                        @else
                            <div class="whitespace-pre-line text-justify leading-relaxed">{{ $coverLetterOutput }}</div>
                        @endif
                    </div>

                    <!-- KEY CORE QUALIFICATIONS BULLETS -->
                    @if (count($keyHighlights) > 0)
                        <div class="pt-2">
                            <div style="color: #000000 !important;" class="text-xs font-bold uppercase tracking-wider mb-1">KEY CORE QUALIFICATIONS</div>
                            <ul style="color: #1f2937 !important;" class="list-disc list-inside text-xs space-y-1 pl-1">
                                @foreach ($keyHighlights as $kh)
                                    <li style="color: #1f2937 !important;">{{ $kh }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- SIGNATURE -->
                    <div style="color: #000000 !important;" class="pt-3 text-xs">
                        <div>Sincerely,</div>
                        <div class="font-bold mt-4">{{ $coverLetterData['signature'] ?? ($fullName ?: 'Your Name') }}</div>
                    </div>
                </div>
            @else
                <!-- EMPTY STATE -->
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-10 text-center shadow-xl">
                    <div class="text-4xl mb-3">✉️</div>
                    <h3 class="text-lg font-black text-white mb-1">Your Cover Letter Preview</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">Fill in the target role and company details, then click <strong class="text-rose-400">Generate Cover Letter with NVIDIA AI</strong> to create a personalized, professional cover letter.</p>
                </div>
            @endif
        </div>
    </div>
</div>
