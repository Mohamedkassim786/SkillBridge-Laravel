<div class="space-y-8 text-white relative">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400 uppercase tracking-widest mb-1">
                <span>💻 Multi-Language Code Playground & AI Examiner</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Universal Code Playground</h1>
            <p class="text-xs text-slate-300 mt-1">Select runtime language, write code, input parameters interactively, and receive exact execution output and AI Big-O diagnosis.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-bold text-slate-400 uppercase">Runtime Version</span>
                <span class="text-xs font-black text-emerald-400">{{ $languageVersion }}</span>
            </div>
            <select wire:model.live="selectedLanguage" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-4 py-2.5 rounded-xl text-xs font-bold focus:outline-none focus:border-rose-500">
                @foreach ($languages as $lang)
                    <option value="{{ $lang }}">{{ $lang }}</option>
                @endforeach
            </select>
            @if ($selectedLanguage === 'Custom')
                <input type="text" wire:model="customLanguage" placeholder="Language (e.g. Haskell...)" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-4 py-2.5 rounded-xl text-xs font-bold focus:outline-none focus:border-rose-500">
            @endif
        </div>
    </div>

    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold flex items-center gap-2">
            <span>✨ {{ session('status') }}</span>
        </div>
    @endif

    <!-- SEQUENTIAL PROGRAM INPUT WIZARD MODAL (ASK ONE INPUT AT A TIME) -->
    @if ($showInputWizard && count($detectedInputs) > 0)
        @php
            $currentInput = $detectedInputs[$currentInputStep] ?? $detectedInputs[0];
            $totalSteps = count($detectedInputs);
        @endphp
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-6 text-white border-2 border-rose-500/40">
                <div class="flex items-center justify-between border-b border-slate-700/60 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center text-xl font-bold">
                            📥
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-white uppercase tracking-wider">Program Input Required</h3>
                            <p class="text-xs text-rose-400 font-bold mt-0.5">Input {{ $currentInputStep + 1 }} of {{ $totalSteps }}</p>
                        </div>
                    </div>
                    <button wire:click="cancelInputWizard" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-200 mb-1">
                            {{ $currentInput['label'] ?? 'Enter input value' }} 
                            <span class="text-[10px] text-slate-400 font-normal">({{ $currentInput['type'] ?? 'Text' }})</span>
                        </label>
                        <input type="text" wire:model="inputValues.{{ $currentInputStep }}" placeholder="Enter value..." style="background: #07162C; border: 1px solid #1e3a5f; color: #38bdf8;" class="w-full p-3.5 rounded-xl text-sm font-mono focus:outline-none focus:border-rose-500" autofocus>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div>
                        @if ($currentInputStep > 0)
                            <button wire:click="previousInputStep" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300">
                                ◀ Back
                            </button>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <button wire:click="cancelInputWizard" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-400">
                            Cancel
                        </button>
                        @if ($currentInputStep < $totalSteps - 1)
                            <button wire:click="nextInputStep" style="background-color: #D62828;" class="px-5 py-2 text-white rounded-xl text-xs font-black shadow-lg hover:bg-rose-700 transition flex items-center gap-1">
                                <span>Next ➔</span>
                            </button>
                        @else
                            <button wire:click="nextInputStep" style="background-color: #D62828;" class="px-6 py-2 text-white rounded-xl text-xs font-black shadow-lg hover:bg-rose-700 transition flex items-center gap-1">
                                <span>▶ Run Code</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- LEFT COLUMN: CODE EDITOR & EXECUTION RESULTS (7 COLUMNS) -->
        <div class="lg:col-span-7 space-y-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-white flex items-center gap-2">
                            <span>⚡ Code Editor</span>
                        </h3>
                        <div class="text-xs text-slate-400 mt-0.5">Language: <span class="text-rose-400 font-bold">{{ $selectedLanguage }}</span> ({{ $languageVersion }})</div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if (count($detectedInputs) > 0)
                            <button wire:click="startInputWizard" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-200 rounded-xl border border-slate-700">
                                📥 Edit Inputs ({{ count($detectedInputs) }})
                            </button>
                        @endif
                        <button wire:click="runCodeAndAiCheck" wire:loading.attr="disabled" style="background-color: #D62828;" class="px-5 py-2.5 text-white rounded-xl text-xs font-black shadow-md hover:bg-rose-700 transition flex items-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="runCodeAndAiCheck">▶ Run Code & AI Diagnostics</span>
                            <span wire:loading wire:target="runCodeAndAiCheck" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Running Code...</span>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- CODE EDITOR TEXTAREA -->
                <div class="relative">
                    <textarea wire:model.live.debounce.300ms="userCode" rows="14" style="background: #07162C; border: 1px solid #1e3a5f; color: #a5b4fc;" class="w-full p-4 rounded-2xl text-xs font-mono focus:outline-none focus:border-rose-500 leading-relaxed"></textarea>
                </div>

                <!-- ERROR MARKER BANNER -->
                @if ($errorLine)
                    <div class="p-3.5 rounded-xl bg-rose-500/20 text-rose-300 border border-rose-500/40 text-xs font-bold flex items-center justify-between animate-pulse">
                        <div class="flex items-center gap-2">
                            <span>🚨 {{ $errorType ?: 'SYNTAX ERROR' }} DETECTED ON LINE {{ $errorLine }}</span>
                            @if ($errorColumn)
                                <span>(Column {{ $errorColumn }})</span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- EXECUTION RESULT & LOG CONSOLE -->
                @if ($executionStatus)
                    <div style="background: #07162C; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl space-y-3 font-mono text-xs">
                        <div class="flex items-center justify-between border-b border-slate-700/60 pb-2">
                            <div class="flex items-center gap-3">
                                <span class="font-black text-sm {{ $isSuccess ? 'text-emerald-400' : 'text-rose-400' }}">{{ $executionStatus }}</span>
                            </div>
                            <div class="flex items-center gap-4 text-[11px] text-slate-400">
                                <span>Runtime: <strong class="text-white">{{ $measuredRuntimeMs }} ms</strong></span>
                                <span>Memory: <strong class="text-white">{{ $measuredMemoryKb }} KB</strong></span>
                            </div>
                        </div>

                        <!-- INPUT VALUES DISPLAY -->
                        @if (count($inputValues) > 0)
                            <div class="text-[11px] text-slate-400 space-y-1">
                                <span class="text-rose-400 font-bold uppercase">INPUT:</span>
                                <div class="pl-2 text-slate-300">
                                    @foreach ($inputValues as $idx => $val)
                                        <div>Line {{ $idx + 1 }}: <span class="text-emerald-300 font-bold">{{ $val }}</span></div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- STDOUT OUTPUT -->
                        @if (!empty($executionOutput))
                            @if ($selectedLanguage === 'HTML/CSS' || $selectedLanguage === 'HTML')
                                <div class="space-y-1">
                                    <div class="text-[11px] font-bold text-emerald-400 uppercase">HTML PREVIEW:</div>
                                    <iframe srcdoc="{{ $executionOutput }}" class="w-full h-48 rounded-xl bg-white border border-slate-700"></iframe>
                                </div>
                            @else
                                <div class="space-y-1">
                                    <div class="text-[11px] font-bold text-emerald-400 uppercase">OUTPUT (stdout):</div>
                                    <pre class="p-3 rounded-xl bg-[#030D1B] text-emerald-300 font-mono text-xs overflow-x-auto whitespace-pre-wrap">{{ $executionOutput }}</pre>
                                </div>
                            @endif
                        @endif

                        <!-- STDERR ERROR LOG -->
                        @if (!empty($stderrOutput))
                            <div class="space-y-1">
                                <div class="text-[11px] font-bold text-rose-400 uppercase">EXECUTION ERROR (stderr):</div>
                                <pre class="p-3 rounded-xl bg-[#030D1B] text-rose-300 font-mono text-xs overflow-x-auto whitespace-pre-wrap">{{ $stderrOutput }}</pre>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- SESSION EXECUTION HISTORY (REQUIREMENT 30) -->
            @if (count($executionHistory) > 0)
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white space-y-3">
                    <h4 class="text-xs font-black uppercase text-slate-300 tracking-wider">📜 Session Execution History</h4>
                    <div class="space-y-2">
                        @foreach (array_reverse($executionHistory) as $run)
                            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-3 rounded-xl flex items-center justify-between text-xs font-mono">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-white">Run #{{ $run['run'] }}</span>
                                    <span class="{{ $run['status'] === 'PASSED' ? 'text-emerald-400' : 'text-rose-400' }} font-bold">{{ $run['status'] }}</span>
                                    @if ($run['error_line'])
                                        <span class="text-rose-300 text-[11px]">(Line {{ $run['error_line'] }})</span>
                                    @endif
                                </div>
                                <div class="text-slate-400 text-[11px]">
                                    {{ $run['runtime_ms'] }} ms | {{ $run['time'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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
                        <div class="text-[10.5px] font-black uppercase text-amber-400">🔍 Root Cause Analysis:</div>
                        <p class="text-slate-200 leading-relaxed">{{ $errorExplanation }}</p>
                    </div>

                    <!-- STEP-BY-STEP FIX GUIDE -->
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-1 text-xs">
                        <div class="text-[10.5px] font-black uppercase text-emerald-400">🛠️ Step-by-Step Fix Guide:</div>
                        <p class="text-slate-200 leading-relaxed">{{ $howToFix }}</p>
                    </div>

                    <!-- AI REFACTORED CODE (REQUIREMENT 19) -->
                    @if ($refactoredCode)
                        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-[10.5px] font-black uppercase text-purple-400">✨ AI Corrected Code:</span>
                                <button wire:click="applyRefactoredCode" class="px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-[10px] font-bold transition">
                                    Apply Fix to Editor
                                </button>
                            </div>
                            <pre class="p-3 rounded-xl bg-[#07162C] text-slate-200 font-mono text-[11px] overflow-x-auto">{{ $refactoredCode }}</pre>
                        </div>
                    @endif
                @else
                    <div class="p-8 text-center text-xs text-slate-400 space-y-2">
                        <div class="text-3xl">💻</div>
                        <div class="font-bold text-white">No Diagnostic Run Yet</div>
                        <p>Write your code solution and click "Run Code & AI Diagnostics" to review execution output, error lines, and Big-O analysis.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>