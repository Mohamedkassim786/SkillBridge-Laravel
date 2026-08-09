<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400 uppercase tracking-widest mb-1">
                <span>🎯 NVIDIA Nim AI (Llama 3.3 70B) Skill Assessment</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Dynamic Skill Assessment Tests</h1>
            <p class="text-xs text-slate-300 mt-1">Enter any skill subject to generate dynamic assessment questions, test your knowledge, and discover target learning paths.</p>
        </div>
        @if ($quizStarted)
            <button wire:click="resetAssessment" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-2xl text-xs font-bold transition">
                🔄 Start New Assessment
            </button>
        @endif
    </div>

    @if (session()->has('status'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold flex items-center gap-2">
            <span>✨ {{ session('status') }}</span>
        </div>
    @endif

    <!-- STEP 1: SKILL TITLE SETUP -->
    @if (!$quizStarted)
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-8 shadow-xl max-w-2xl mx-auto space-y-6 text-white">
            <div class="text-center space-y-2">
                <div class="w-16 h-16 rounded-2xl bg-rose-500/20 text-rose-400 text-3xl font-bold flex items-center justify-center mx-auto shadow-inner border border-rose-500/30">
                    🎯
                </div>
                <h2 class="text-xl font-black text-white">Setup Custom Skill Assessment</h2>
                <p class="text-xs text-slate-300">Enter any skill topic or select a preset domain to generate dynamic technical assessment questions.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Enter Skill Title or Topic</label>
                    <input type="text" wire:model="skillTitle" placeholder="e.g. PHP 8.3 & Laravel 12, React 19, Python RAG AI, AWS DevOps..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Question Count</label>
                        <select wire:model="questionCount" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                            <option value="5">5 Questions (Quick Quiz)</option>
                            <option value="10">10 Questions (Standard Test)</option>
                            <option value="15">15 Questions (Mastery Evaluation)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Target Difficulty</label>
                        <select wire:model="difficultyLevel" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold focus:outline-none focus:border-rose-500">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced Architecture</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Quick Select Preset Topics:</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['PHP 8.3 & Laravel 12', 'React 19 & Next.js', 'Python RAG AI', 'MySQL 8 Database Architecture', 'AWS & Docker DevOps'] as $preset)
                            <button wire:click="$set('skillTitle', '{{ $preset }}')" style="background: #112240; border: 1px solid #1e3a5f;" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:border-rose-500 transition">
                                {{ $preset }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <button wire:click="startAssessment" wire:loading.attr="disabled" style="background-color: #D62828;" class="w-full py-4 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition flex items-center justify-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="startAssessment">🚀 Generate & Start Skill Assessment</span>
                    <span wire:loading wire:target="startAssessment" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Generating Adaptive Assessment Questions...</span>
                    </span>
                </button>
            </div>
        </div>
    @elseif (!$quizCompleted)
        <!-- STEP 2: ACTIVE QUIZ QUESTIONS SHEET -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6 max-w-4xl mx-auto">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-rose-400">Dynamic AI Skill Assessment</span>
                    <h2 class="text-xl font-black text-white mt-0.5">{{ $skillTitle }}</h2>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30 text-xs font-bold">{{ count($questions) }} Questions</span>
            </div>

            <div class="space-y-6">
                @foreach ($questions as $q)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-6 rounded-2xl space-y-4">
                        <div class="text-sm font-bold text-white flex items-start gap-3">
                            <span class="w-6 h-6 rounded-lg bg-rose-500/20 text-rose-400 text-xs font-black flex items-center justify-center shrink-0 mt-0.5">{{ $q['id'] }}</span>
                            <span>{{ $q['question'] }}</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            @foreach ($q['options'] as $key => $option)
                                <label style="background: #07162C; border: 1px solid #1e3a5f;" class="p-3.5 rounded-xl flex items-center gap-3 cursor-pointer hover:border-rose-500 transition">
                                    <input type="radio" wire:model="userAnswers.{{ $q['id'] }}" value="{{ $key }}" class="text-rose-500 focus:ring-rose-500">
                                    <span class="text-xs font-semibold text-slate-200"><strong>{{ $key }}.</strong> {{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                <span class="text-xs text-slate-400">Select answers for all questions before submitting.</span>
                <button wire:click="submitQuiz" wire:loading.attr="disabled" style="background-color: #D62828;" class="px-8 py-3.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition flex items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="submitQuiz">Submit Assessment & Grade</span>
                    <span wire:loading wire:target="submitQuiz" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Grading Test...</span>
                    </span>
                </button>
            </div>
        </div>
    @else
        <!-- STEP 3: FINAL QUIZ RESULTS & LEARNING PATH -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-8 shadow-xl text-white space-y-6 max-w-4xl mx-auto">
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full border-4 border-emerald-500 bg-emerald-500/10 font-black text-3xl text-emerald-400 shadow-inner">
                    {{ $score }}%
                </div>
                <h2 class="text-2xl font-black text-white">Skill Assessment Results: <span class="text-emerald-400">{{ $skillLevel }}</span></h2>
                <p class="text-xs text-slate-300">Topic: <strong class="text-white">{{ $skillTitle }}</strong></p>
            </div>

            <!-- DETAILED QUESTION BREAKDOWN -->
            <div class="space-y-4">
                <h3 class="text-sm font-black uppercase text-slate-400 tracking-wider">Question Breakdown & Explanations:</h3>
                @foreach ($questions as $q)
                    @php
                        $userAns = $userAnswers[$q['id']] ?? 'None';
                        $isCorrect = ($userAns === $q['correct']);
                    @endphp
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl space-y-2 text-xs">
                        <div class="flex items-center justify-between font-bold">
                            <span class="text-white">{{ $q['id'] }}. {{ $q['question'] }}</span>
                            @if ($isCorrect)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[10px] font-black">✓ Correct</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[10px] font-black">✕ Incorrect</span>
                            @endif
                        </div>
                        <div class="text-slate-300">
                            Your Answer: <strong class="{{ $isCorrect ? 'text-emerald-400' : 'text-rose-400' }}">{{ $userAns }}</strong> • Correct Answer: <strong class="text-emerald-400">{{ $q['correct'] }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-[#07162C] text-slate-300 font-semibold text-[11px] italic">
                            💡 Explanation: {{ $q['explanation'] ?? 'Correct concept selection.' }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- CONNECTED PRACTICE HUB RECOMMENDATIONS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-6 rounded-2xl space-y-3">
                    <h3 class="text-xs font-black uppercase tracking-wider text-rose-400 flex items-center gap-1.5">
                        <span>💻 Recommended Coding Sandbox Practice</span>
                    </h3>
                    <div class="space-y-2">
                        @foreach ($recommendedCodingChallenges as $ch)
                            <div style="background: #07162C; border: 1px solid #1e3a5f;" class="p-3 rounded-xl flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-bold text-white">{{ $ch['title'] }}</div>
                                    <div class="text-[10px] text-slate-400">Language: {{ $ch['language'] }} • Difficulty: {{ $ch['difficulty'] }}</div>
                                </div>
                                <a href="{{ route('student.practice.coding') }}" class="px-3 py-1 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-black text-[10px] transition">
                                    Solve ➔
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-6 rounded-2xl space-y-3">
                    <h3 class="text-xs font-black uppercase tracking-wider text-emerald-400 flex items-center gap-1.5">
                        <span>👩‍💼 Recommended AI Mock Interview</span>
                    </h3>
                    <div class="space-y-2">
                        @foreach ($recommendedMockInterviews as $mi)
                            <div style="background: #07162C; border: 1px solid #1e3a5f;" class="p-3 rounded-xl flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-bold text-white">{{ $mi['role'] }}</div>
                                    <div class="text-[10px] text-slate-400">Type: {{ strtoupper($mi['type']) }} • Focus: {{ $mi['focus'] }}</div>
                                </div>
                                <a href="{{ route('student.practice.mock') }}" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-black text-[10px] transition">
                                    Rehearse ➔
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4 pt-4 border-t border-slate-800">
                <button wire:click="resetAssessment" style="background-color: #D62828;" class="px-8 py-3.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition">
                    🔄 Take Another Skill Assessment
                </button>
            </div>
        </div>
    @endif
</div>
