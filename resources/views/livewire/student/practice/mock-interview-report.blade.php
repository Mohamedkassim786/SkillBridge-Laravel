<div class="max-w-4xl mx-auto space-y-8 text-white">
    <!-- Header Banner -->
    <div class="rounded-3xl p-6 md:p-8 border border-slate-800 flex items-center justify-between gap-6" style="background-color: #0B1F3A;">
        <div class="space-y-1">
            <span class="text-xs font-bold text-rose-400 uppercase tracking-wider">Interview Coaching Report</span>
            <h1 class="text-2xl font-black text-white">{{ $interview->role }} Performance</h1>
            <p class="text-xs text-slate-400">📅 {{ $interview->created_at->format('M d, Y') }} • Sarah (Senior Technical Recruiter)</p>
        </div>

        <div class="text-center p-4 rounded-2xl bg-slate-900 border border-slate-800">
            <div class="text-3xl font-black text-rose-400">{{ $report->overall_score ?? 85 }}/100</div>
            <div class="text-[10px] font-bold text-slate-500 uppercase mt-0.5">Overall Score</div>
        </div>
    </div>

    <!-- 8 Skill Rubrics Grid -->
    <div class="rounded-3xl p-6 border border-slate-800 space-y-4" style="background-color: #0B1F3A;">
        <h2 class="text-xs font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800 pb-2">8 Core Interview Skill Metrics</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php
                $metrics = [
                    ['label' => 'Technical Depth', 'score' => $report->technical_score ?? 88],
                    ['label' => 'Communication', 'score' => $report->communication_score ?? 82],
                    ['label' => 'Clarity & Diction', 'score' => $report->clarity_score ?? 86],
                    ['label' => 'Confidence', 'score' => $report->confidence_score ?? 80],
                    ['label' => 'Relevance', 'score' => $report->relevance_score ?? 85],
                    ['label' => 'Answer Structure', 'score' => $report->structure_score ?? 78],
                    ['label' => 'Grammar', 'score' => $report->grammar_score ?? 90],
                    ['label' => 'Professionalism', 'score' => $report->professionalism_score ?? 92],
                ];
            @endphp
            @foreach($metrics as $m)
                <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-300">{{ $m['label'] }}</span>
                        <span class="text-rose-400 font-bold">{{ $m['score'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="h-full bg-rose-500" style="width: {{ $m['score'] }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Personalized 7-Day Action Plan -->
    @if(!empty($report->improvement_plan))
        <div class="rounded-3xl p-6 border border-slate-800 space-y-4" style="background-color: #0B1F3A;">
            <h2 class="text-xs font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800 pb-2 flex items-center justify-between">
                <span>🗓️ Personalized 7-Day Improvement Plan</span>
                <span class="text-rose-400 text-[10px]">Tailored to your interview performance</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($report->improvement_plan as $item)
                    <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-1">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-rose-400">Day {{ $item['day'] ?? 1 }}: {{ $item['focus'] ?? 'Skill Practice' }}</span>
                        </div>
                        <p class="text-[11px] text-slate-300 leading-relaxed">{{ $item['task'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Question-by-Question Simple Accordion List -->
    <div class="space-y-4">
        <h2 class="text-base font-bold text-white flex items-center justify-between">
            <span>Questions & Coaching Review</span>
            <span class="text-xs text-slate-400 font-normal">{{ $questions->count() }} Questions</span>
        </h2>

        @foreach($questions as $index => $q)
            <div class="rounded-2xl p-5 border border-slate-800 space-y-3" style="background-color: #0B1F3A;">
                <div class="flex items-start justify-between gap-4 border-b border-slate-800 pb-2">
                    <div>
                        <span class="text-[10px] font-bold text-rose-400 uppercase">Question {{ $index + 1 }}</span>
                        <h3 class="font-bold text-sm text-white">"{{ $q->question }}"</h3>
                    </div>
                    @if($q->response && $q->response->evaluation)
                        <span class="px-3 py-1 rounded-xl bg-slate-900 text-xs font-bold text-rose-400">
                            {{ round(($q->response->evaluation->technical_score + $q->response->evaluation->communication_score) / 2) }}/100
                        </span>
                    @endif
                </div>

                @if($q->response)
                    <div class="text-xs text-slate-300 space-y-1 bg-slate-900/60 p-3 rounded-xl">
                        <div class="text-[11px] font-bold text-emerald-400">Your Answer:</div>
                        <p class="italic">"{{ $q->response->transcript }}"</p>
                    </div>

                    @if($q->response->evaluation)
                        <div class="text-xs space-y-2">
                            <div class="text-rose-300 font-bold">✨ How to Answer Better (STAR Framework):</div>
                            <p class="text-slate-300 bg-slate-900 p-3 rounded-xl font-mono text-[11px] leading-relaxed">
                                {{ $q->response->evaluation->improved_answer }}
                            </p>
                        </div>
                    @endif

                    <div class="flex justify-end pt-1">
                        <a href="{{ route('student.practice.mock.practice', ['id' => $interview->id, 'questionId' => $q->id]) }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-all">
                            🔄 Practice This Question Again
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between pt-4">
        <a href="{{ route('student.practice.mock') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 text-xs font-bold hover:border-slate-700 transition-all">
            ← Back to Setup
        </a>

        <a href="{{ route('student.practice.mock') }}" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold transition-all">
            🎙️ Start New Session
        </a>
    </div>
</div>
