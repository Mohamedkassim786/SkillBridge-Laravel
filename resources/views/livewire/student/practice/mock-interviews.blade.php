<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">AI Technical Mock Interviews</h1>
            <p class="text-xs text-slate-300 mt-1">Simulate live technical interview rounds for Laravel Architect and Full-Stack Engineering roles.</p>
        </div>
        <button wire:click="nextQuestion" class="px-5 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-2xl text-xs font-black shadow-md transition">
            ⏭️ Next Question
        </button>
    </div>

    <!-- MAIN INTERVIEW CONTAINER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
        <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl space-y-2 text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-rose-400 uppercase tracking-wider">Question #{{ $currentQuestionIndex + 1 }}</span>
                <span class="text-xs font-bold text-slate-400">Target Role: {{ $selectedRole }}</span>
            </div>
            <h3 class="text-lg font-extrabold text-white leading-snug">{{ $currentQ['question'] }}</h3>
            <p class="text-xs text-slate-300 font-medium">💡 Hint: {{ $currentQ['hint'] }}</p>
        </div>

        <form wire:submit.prevent="submitAnswer" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Your Technical Answer</label>
                <textarea wire:model="studentAnswer" rows="5" placeholder="Type your detailed architectural response here..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-2xl text-xs font-semibold focus:outline-none focus:border-rose-500 leading-relaxed"></textarea>
            </div>

            <button type="submit" style="background-color: #D62828;" class="px-6 py-3 text-white rounded-2xl font-black text-xs shadow-lg hover:bg-rose-700 transition">
                ⚡ Submit Answer for AI Evaluation
            </button>
        </form>

        @if ($aiFeedback)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-6 rounded-2xl text-xs font-mono text-emerald-300 whitespace-pre-line leading-relaxed">
                {{ $aiFeedback }}
            </div>
        @endif
    </div>
</div>
