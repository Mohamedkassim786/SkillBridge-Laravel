<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Skill Assessment Tests</h1>
            <p class="text-xs text-slate-300 mt-1">Validate your software architecture expertise with timed multiple-choice skill tests.</p>
        </div>
        <div class="px-4 py-2 bg-white/10 rounded-2xl border border-white/10 text-xs font-bold">
            <span>⏱️ Timed Quiz: {{ count($questions) }} Questions</span>
        </div>
    </div>

    <!-- MAIN QUIZ CONTAINER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
        @if ($score !== null)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-8 text-center rounded-3xl text-white space-y-3">
                <div class="text-4xl">🏆</div>
                <h3 class="text-2xl font-black text-white">Your Test Score: {{ $score }}%</h3>
                <p class="text-xs text-slate-300 font-medium">
                    {{ $score >= 80 ? 'Passed! Excellent command of Laravel architecture.' : 'Good effort! Review course modules to improve score.' }}
                </p>
            </div>
        @else
            <form wire:submit.prevent="submitQuiz" class="space-y-6">
                @foreach ($questions as $index => $q)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl text-white space-y-3">
                        <h4 class="font-black text-white text-sm">Question {{ $index + 1 }}: {{ $q['question'] }}</h4>
                        <div class="space-y-2">
                            @foreach ($q['options'] as $key => $opt)
                                <label style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="flex items-center gap-3 p-3 rounded-xl cursor-pointer hover:border-rose-500 transition text-xs font-semibold text-white">
                                    <input type="radio" wire:model="userAnswers.{{ $q['id'] }}" value="{{ $key }}" class="text-rose-600 focus:ring-rose-500">
                                    <span><strong>{{ $key }}:</strong> {{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit" style="background-color: #D62828;" class="w-full py-4 text-white rounded-2xl font-black text-sm shadow-xl hover:bg-rose-700 transition">
                    Submit Quiz & Get Score Report
                </button>
            </form>
        @endif
    </div>
</div>
