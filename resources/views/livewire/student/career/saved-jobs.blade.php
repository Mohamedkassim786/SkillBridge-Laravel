<div class="space-y-8 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Saved Jobs & Interview Schedules</h1>
            <p class="text-xs text-slate-300 mt-1">Manage bookmarked developer postings, configure job alert notifications, and view scheduled interviews.</p>
        </div>
        <button wire:click="toggleJobAlerts" class="px-5 py-3 rounded-2xl text-xs font-black shadow-lg transition flex items-center gap-2 {{ $jobAlertsEnabled ? 'bg-emerald-600 text-white' : 'bg-slate-800 text-slate-300' }}">
            <span>🔔 Job Alerts: {{ $jobAlertsEnabled ? 'ACTIVE' : 'MUTED' }}</span>
        </button>
    </div>

    <!-- UPCOMING INTERVIEW SCHEDULES -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
        <h3 class="text-base font-black text-white flex items-center gap-2">
            <span>📅 Scheduled Technical Interviews</span>
        </h3>

        @if ($interviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($interviews as $int)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl text-white space-y-3">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-extrabold text-white text-sm">{{ $int->job_title }}</h4>
                                <div class="text-xs font-bold text-rose-400 mt-0.5">{{ $int->company_name }}</div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                {{ $int->type }}
                            </span>
                        </div>

                        <div class="text-xs text-slate-300 font-semibold flex items-center gap-2">
                            <span>🕒 {{ $int->scheduled_at?->format('F d, Y @ h:i A') }}</span>
                        </div>

                        @if ($int->meeting_link)
                            <a href="{{ $int->meeting_link }}" target="_blank" style="background-color: #D62828;" class="w-full py-2.5 text-white rounded-xl text-xs font-black text-center block transition text-decoration-none">
                                📹 Join WebRTC Interview Room
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400">No scheduled interviews currently.</p>
        @endif
    </div>

    <!-- SAVED JOBS LIST -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 sm:p-8 shadow-xl text-white space-y-6">
        <h3 class="text-base font-black text-white flex items-center gap-2">
            <span>🔖 Bookmarked Jobs ({{ $savedJobs->count() }})</span>
        </h3>

        @if ($savedJobs->count() > 0)
            <div class="space-y-4">
                @foreach ($savedJobs as $saved)
                    <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
                        <div class="space-y-1">
                            <h4 class="font-extrabold text-white text-base">
                                <a href="{{ route('jobs.show', $saved->job_posting_id) }}" class="hover:text-rose-400 transition text-decoration-none">
                                    {{ $saved->jobPosting?->title ?? 'Full-Stack Developer' }}
                                </a>
                            </h4>
                            <div class="text-xs text-slate-300 font-semibold">
                                {{ $saved->jobPosting?->company?->name ?? 'Enterprise Partner' }} • {{ $saved->jobPosting?->location ?? 'Remote' }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('jobs.show', $saved->job_posting_id) }}" style="background-color: #D62828;" class="px-4 py-2.5 text-white rounded-xl text-xs font-black transition text-decoration-none">
                                View & Apply ➔
                            </a>
                            <button wire:click="removeSavedJob('{{ $saved->id }}')" class="p-2.5 text-slate-400 hover:text-rose-400 transition text-sm">
                                🗑️
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400">No saved jobs yet.</p>
        @endif
    </div>
</div>
