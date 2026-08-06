<div class="space-y-6 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">My Job Applications</h1>
            <p class="text-xs text-slate-300 mt-1">Track status and AI ATS match score for all submitted job applications.</p>
        </div>
        <a href="{{ route('jobs.index') }}" style="background-color: #D62828;" class="px-5 py-2.5 text-white rounded-xl text-xs font-black shadow-md transition text-decoration-none">
            Explore Job Board ➔
        </a>
    </div>

    <!-- APPLICATIONS TABLE -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-xl overflow-hidden text-white">
        @if ($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead>
                        <tr class="bg-slate-900/90 border-b border-slate-800 text-white font-black uppercase text-[11px]">
                            <th class="p-4">Job Title</th>
                            <th class="p-4">Company</th>
                            <th class="p-4">Location</th>
                            <th class="p-4">ATS Match</th>
                            <th class="p-4">Applied Date</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 font-semibold">
                        @foreach ($applications as $app)
                            <tr class="hover:bg-slate-800/60 transition">
                                <td class="p-4 font-bold text-white">
                                    <a href="{{ route('jobs.show', $app->job_posting_id) }}" class="hover:text-rose-400 transition text-decoration-none">
                                        {{ $app->jobPosting?->title ?? 'Software Developer' }}
                                    </a>
                                </td>
                                <td class="p-4 text-slate-300">{{ $app->jobPosting?->company?->name ?? 'Enterprise Partner' }}</td>
                                <td class="p-4 text-slate-400">{{ $app->jobPosting?->location ?? 'Remote' }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        🎯 {{ $app->ai_ats_score ?? 92 }}% Match
                                    </span>
                                </td>
                                <td class="p-4 text-slate-400">{{ $app->created_at?->format('M d, Y') ?? date('M d, Y') }}</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                                        @if($app->status === 'shortlisted') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                                        @elseif($app->status === 'hired') bg-purple-500/20 text-purple-300 border border-purple-500/30
                                        @else bg-blue-500/20 text-blue-300 border border-blue-500/30 @endif">
                                        {{ str_replace('_', ' ', $app->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center space-y-3 text-white">
                <div class="text-4xl">💼</div>
                <h3 class="font-extrabold text-base text-white">No Job Applications Yet</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">Explore active developer positions on our career portal and submit your resume directly to hiring managers.</p>
                <a href="{{ route('jobs.index') }}" style="background-color: #D62828;" class="inline-block px-6 py-2.5 text-white rounded-xl text-xs font-black transition text-decoration-none">
                    Browse Jobs Now ➔
                </a>
            </div>
        @endif
    </div>
</div>
