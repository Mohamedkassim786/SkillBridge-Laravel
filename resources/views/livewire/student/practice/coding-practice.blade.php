<div class="space-y-8 text-white relative">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400 uppercase tracking-widest mb-1">
                <span>💻 Universal Multi-Language Code Playground & AI Examiner</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Universal Coding Practice Sandbox</h1>
            <p class="text-xs text-slate-300 mt-1">Select or enter any programming language, write code, provide interactive inputs, and get exact execution output, error logs, and Big-O analysis.</p>
        </div>
        <div class="flex items-center gap-3">
            <select wire:model.live="selectedLanguage" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-4 py-2.5 rounded-xl text-xs font-bold focus:outline-none focus:border-rose-500">
                @foreach ($languages as $lang)
                    <option value="{{ $lang }}">{{ $lang }}</option>
                @endforeach
            </select>
            @if ($selectedLanguage === 'Custom')
                <input type="text" wire:model="customLanguage" placeholder="Enter Language (e.g. Rust, Go, Haskell...)" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-4 py-2.5 rounded-xl text-xs font-bold focus:outline-none focus:border-rose-500">
            @endif
        </div>
    </div>

    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold flex items-center gap-2">
            <span>✨ {{ session('status') }}</span>
        </div>
    @endif

    <!-- INTERACTIVE INPUT PROMPT MODAL POPUP (SHOWN ONLY IF INPUT REQUIRED & STDIN EMPTY) -->
    @if ($showInputModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-6 text-white border-2 border-rose-500/40">
                <div class="flex items-center justify-between border-b border-slate-700/60 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center text-xl font-bold">
                            📥
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white">Program Input Required!</h3>
                            <p class="text-xs text-rose-400 font-bold mt-0.5">Prompt: "{{ $detectedPromptLabel }}"</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
                </div>

                <div class="space-y-3">
                    <p class="text-xs text-slate-300 leading-relaxed">
                        This program requires user input to run (e.g. <code class="text-rose-300 font-mono">input()</code> / <code class="text-rose-300 font-mono">Scanner</code>). Please enter your input value below:
                    </p>
                    <textarea wire:model="stdinInput" rows="3" placeholder="e.g. John" style="background: #07162C; border: 1px solid #1e3a5f; color: #38bdf8;" class="w-full p-4 rounded-2xl text-sm font-mono focus:outline-none focus:border-rose-500" autofocus></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button wire:click="closeModal" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300">
                        Cancel
                    </button>
                    <button wire:click="submitInputAndRun" style="background-color: #D62828;" class="px-6 py-2.5 text-white rounded-xl text-xs font-black shadow-lg hover:bg-rose-700 transition flex items-center gap-2">
                        <span>Submit Input & Execute Program ➔</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- LEFT COLUMN: CODE EDITOR & INPUTS (7 COLUMNS) -->
        <div class="lg:col-span-7 space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-white flex items-center gap-2">
                            <span>⚡ {{ $challengeTitle }}</span>
                        </h3>
                        <div class="text-xs text-slate-400 mt-0.5">Target Language: <span class="text-rose-400 font-bold">{{ $selectedLanguage === 'Custom' && !empty($customLanguage) ? $customLanguage : $selectedLanguage }}</span></div>
                    </div>
                    <button wire:click="runCodeAndAiCheck" wire:loading.attr="disabled" style="background-color: #D62828;" class="px-5 py-2.5 text-white rounded-xl text-xs font-black shadow-md hover:bg-rose-700 transition flex items-center gap-2 disabled:opacity-50">
                        <span wire:loading.remove wire:target="runCodeAndAiCheck">▶ Run Code & AI Diagnostics</span>
                        <span wire:loading wire:target="runCodeAndAiCheck" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Analyzing Code...</span>
                        </span>
                    </button>
                </div>

                <!-- CODE EDITOR TEXTAREA -->
                <div>
                    <textarea wire:model.live.debounce.300ms="userCode" rows="12" style="background: #07162C; border: 1px solid #1e3a5f; color: #a5b4fc;" class="w-full p-4 rounded-2xl text-xs font-mono focus:outline-none focus:border-rose-500 leading-relaxed"></textarea>
                </div>

                <!-- PROGRAM INPUTS (STDIN) TEXTAREA - SHOWN ONLY IF PROGRAM REQUIRES INPUT -->
                @if ($requiresInputStatement)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-2">
                        <label class="text-[11px] font-bold text-rose-400 uppercase tracking-wider flex items-center justify-between">
                            <span>📥 Program Input Required (stdIn)</span>
                            <span class="text-[10px] text-slate-400 font-normal">Prompt: "{{ $detectedPromptLabel }}"</span>
                        </label>
                        <textarea wire:model="stdinInput" rows="2" placeholder="Enter input values here..." style="background: #07162C; border: 1px solid #1e3a5f; color: #38bdf8;" class="w-full p-3 rounded-xl text-xs font-mono focus:outline-none focus:border-rose-500"></textarea>
                    </div>
                @endif

                <!-- EXECUTION LOG CONSOLE -->
                @if ($executionOutput)
                    <div style="background: #07162C; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl text-xs font-mono text-emerald-400 whitespace-pre-line">
                        {{ $executionOutput }}
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN: AI ERROR DIAGNOSTIC & BIG-O PANEL (5 COLUMNS) -->
        <div class="lg:col-span-5 space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                        <span>🤖 AI Error Diagnostic & Complexity</span>
                    </h3>
                </div>

                @if ($hasAiAnalysis)
                    <!-- BIG-O METRICS -->
                    <div class="grid grid-cols-2 gap-3">
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl text-center">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Time Complexity</div>
                            <div class="text-xl font-black text-emerald-400 mt-1">{{ $timeComplexity }}</div>
                        </div>
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3.5 rounded-2xl text-center">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Space Complexity</div>
                            <div class="text-xl font-black text-blue-400 mt-1">{{ $spaceComplexity }}</div>
                        </div>
                    </div>

                    <!-- ERROR EXPLANATION -->
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-1 text-xs">
                        <div class="text-[10.5px] font-black uppercase text-amber-400">🔍 Error / Syntax Root Cause:</div>
                        <p class="text-slate-200 leading-relaxed">{{ $errorExplanation }}</p>
                    </div>

                    <!-- HOW TO FIX -->
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-1 text-xs">
                        <div class="text-[10.5px] font-black uppercase text-emerald-400">🛠️ Step-by-Step Fix Guide:</div>
                        <p class="text-slate-200 leading-relaxed">{{ $howToFix }}</p>
                    </div>

                    <!-- REFACTORED CODE OPTION -->
                    @if ($refactoredCode)
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-[10.5px] font-black uppercase text-purple-400">✨ AI Refactored Solution:</span>
                                <button wire:click="applyRefactoredCode" class="px-2.5 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-[10px] font-bold transition">
                                    Apply to Editor
                                </button>
                            </div>
                            <pre class="p-3 rounded-xl bg-[#07162C] text-slate-200 font-mono text-[11px] overflow-x-auto">{{ $refactoredCode }}</pre>
                        </div>
                    @endif
                @else
                    <div class="p-8 text-center text-xs text-slate-400 space-y-2">
                        <div class="text-3xl">💻</div>
                        <div class="font-bold text-white">No Diagnostic Run Yet</div>
                        <p>Write your code solution and click "Run Code & AI Diagnostics" to review syntax, explain errors, and get refactored code.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>