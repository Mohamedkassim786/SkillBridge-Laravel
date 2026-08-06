<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400 uppercase tracking-widest mb-1">
                <span>🧠 RAG (Retrieval-Augmented Generation) Architecture</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">RAG AI Resume Builder & ATS Analyzer</h1>
            <p class="text-xs text-slate-300 mt-1">Multi-technology domain knowledge retrieval for accurate ATS scoring and AI cover letters.</p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="saveResume" style="background-color: #D62828;" class="px-5 py-3 text-white rounded-2xl text-xs font-black shadow-lg transition flex items-center gap-2">
                💾 Save Resume to Profile
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT COLUMN (FORM BUILDER) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 1. RESUME INPUT FORM -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
                <h3 class="text-base font-black text-white flex items-center gap-2">
                    <span>📄 Resume Content Editor</span>
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">Full Name</label>
                            <input type="text" wire:model="fullName" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1">Email</label>
                            <input type="email" wire:model="email" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Target Role Title</label>
                        <input type="text" wire:model="targetRole" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Technical Skills (Multi-Tech: PHP, React, Python, DevOps, Docker)</label>
                        <input type="text" wire:model="skillsInput" wire:change="calculateAtsScore" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Professional Experience Summary</label>
                        <textarea wire:model="experienceSummary" rows="4" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500"></textarea>
                    </div>
                </div>
            </div>

            <!-- 2. AI COVER LETTER GENERATOR -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-white">✉️ RAG Cover Letter Generator</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Augmented with domain knowledge for your target technology stack.</p>
                    </div>
                    <button wire:click="generateCoverLetter" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition">
                        ✨ Generate Now
                    </button>
                </div>

                @if ($coverLetterOutput)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl text-xs font-mono text-slate-200 whitespace-pre-line leading-relaxed">
                        {{ $coverLetterOutput }}
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN (RAG ATS SCORE & PREVIEW) -->
        <div class="space-y-6">
            <!-- RAG ATS MATCH SCORE CARD -->
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">RAG ATS Match Score</h3>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">RAG VERIFIED</span>
                </div>

                <div class="text-center py-2">
                    <div class="inline-flex items-center justify-center w-28 h-28 rounded-full border-4 border-rose-500 bg-rose-500/10 font-black text-4xl text-rose-400 shadow-inner">
                        {{ $atsScore }}%
                    </div>
                    <div class="text-xs font-bold text-slate-300 mt-3">High Match for {{ $targetRole }}</div>
                </div>

                <!-- RAG RETRIEVED KNOWLEDGE CONTEXT BANNER -->
                @if ($retrievedContext)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl text-xs space-y-1 text-white">
                        <div class="text-[10.5px] font-black uppercase tracking-wider text-rose-400">📚 RAG Vector Context Retrieved:</div>
                        <div class="text-[11px] text-slate-300 font-mono italic">{{ $retrievedContext }}</div>
                    </div>
                @endif

                <!-- TARGET JOB DESCRIPTION FOR ATS SCAN -->
                <div class="space-y-2 pt-2 border-t border-slate-800">
                    <label class="block text-xs font-bold text-slate-300">Target Job Description (for RAG Analysis)</label>
                    <textarea wire:model="targetJobDescription" wire:keyup.debounce.500ms="calculateAtsScore" rows="3" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl text-xs text-slate-200 focus:outline-none focus:border-rose-500"></textarea>
                </div>

                <!-- KEYWORD MATCHES -->
                <div class="space-y-3 pt-2">
                    <div class="text-xs font-black text-slate-400">Matched ATS Keywords:</div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($matchedKeywords as $mKey)
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold">✓ {{ $mKey }}</span>
                        @endforeach
                    </div>

                    @if (count($missingKeywords) > 0)
                        <div class="text-xs font-black text-slate-400 pt-2">Recommended Additions:</div>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($missingKeywords as $missKey)
                                <span class="px-2.5 py-1 rounded-lg bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-bold">+ {{ $missKey }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
