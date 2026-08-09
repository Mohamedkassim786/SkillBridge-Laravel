<div class="space-y-8 text-white">
    <!-- Header Banner -->
    <div class="p-6 rounded-3xl border border-slate-800 flex items-center justify-between" style="background-color: #0B1F3A;">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                🔄 Single Question Practice Retake
            </div>
            <h1 class="text-xl font-bold text-white">Rehearse & Improve Weak Question</h1>
            <p class="text-xs text-slate-400">Target Role: {{ $interview->role }}</p>
        </div>

        <a href="{{ route('student.practice.mock.report', ['id' => $interview->id]) }}" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 text-xs font-bold hover:border-slate-700 transition-all">
            ← Back to Report
        </a>
    </div>

    <!-- Question Box -->
    <div class="rounded-3xl p-6 md:p-8 border border-slate-800 space-y-6" style="background-color: #0B1F3A;">
        <div class="space-y-2 border-b border-slate-800 pb-4">
            <span class="text-xs font-bold text-rose-400 uppercase tracking-wider">Target Question:</span>
            <h2 class="text-xl font-bold text-white">"{{ $question->question }}"</h2>
        </div>

        <!-- Previous Answer -->
        @if($question->response)
            <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-1">
                <div class="text-[11px] font-bold text-slate-400">Your Previous Answer:</div>
                <p class="text-xs text-slate-300 italic">"{{ $question->response->transcript }}"</p>
            </div>
        @endif

        <!-- Retake Voice Input Form -->
        <form wire:submit.prevent="submitRetake" class="space-y-4">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Record / Type Your Improved Answer:</label>
                <textarea wire:model="retakeTranscript" rows="4" class="w-full bg-slate-900 border border-slate-700 rounded-2xl p-4 text-xs text-white focus:outline-none focus:border-rose-500" placeholder="State your direct answer first, explain your technical solution, and mention quantifiable metrics..."></textarea>
            </div>

            <button type="submit" class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-rose-500 to-indigo-600 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-rose-500/25 flex items-center gap-2 hover:from-rose-600 hover:to-indigo-700 transition-all">
                <span>✨ Evaluate Improved Answer</span>
            </button>
        </form>

        <!-- Evaluation & Score Comparison Result -->
        @if($retakeResult)
            <div class="mt-8 p-6 rounded-3xl bg-slate-900 border border-rose-500/30 space-y-6 animate-fade-in">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <h3 class="text-base font-bold text-white">Score Comparison Result</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        +{{ $retakeResult['score_gain'] }} Points Gain! 🎉
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800">
                        <div class="text-2xl font-black text-slate-400">{{ $retakeResult['previous_score'] }}/100</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase mt-1">Previous Score</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-950 border border-rose-500/40">
                        <div class="text-2xl font-black text-rose-400">{{ $retakeResult['new_score'] }}/100</div>
                        <div class="text-[10px] font-bold text-rose-300 uppercase mt-1">New Score</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-950 border border-emerald-500/40">
                        <div class="text-2xl font-black text-emerald-400">+{{ $retakeResult['score_gain'] }}</div>
                        <div class="text-[10px] font-bold text-emerald-300 uppercase mt-1">Improvement</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="text-xs font-bold text-emerald-400">✓ What Improved in Your Answer:</div>
                    <ul class="text-xs text-slate-300 space-y-1 list-disc pl-4">
                        @foreach($retakeResult['what_improved'] as $imp)
                            <li>{{ $imp }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
