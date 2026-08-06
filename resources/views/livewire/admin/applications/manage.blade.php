<div class="space-y-6" x-data="{ modalOpen: @entangle('showModal') }">

    <!-- Flash Status Messages -->
    @if (session()->has('status'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold text-xs flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-sm">✕</button>
        </div>
    @endif

    <!-- TOP SECTION & BREADCRUMB -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <span>&gt;</span>
                <span class="text-rose-400 font-bold">Applications</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Application Management</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Track all job applications, interview schedules, and placement status.</p>
        </div>
    </div>

    <!-- ACTION BAR (DARK NAVY CARD) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl flex flex-col xl:flex-row xl:items-center justify-between gap-4 text-white">
        <!-- Left Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button style="color: white; border: 1.5px solid #1e3a5f; background: rgba(255,255,255,0.05);" class="px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-white/10 transition-all flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export CSV</span>
            </button>
            <button style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:bg-red-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Generate Report</span>
            </button>
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-[300px]">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search student, job, company..." style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;" class="w-full pl-9 pr-4 py-2 rounded-xl text-xs font-medium text-white placeholder-slate-400 focus:outline-none focus:border-rose-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <select wire:model.live="selectedStatus" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Status</option>
                <option value="submitted" class="text-slate-900">Applied</option>
                <option value="shortlisted" class="text-slate-900">Shortlisted</option>
                <option value="interview_scheduled" class="text-slate-900">Interview</option>
                <option value="hired" class="text-slate-900">Offer / Hired</option>
                <option value="rejected" class="text-slate-900">Rejected</option>
            </select>
        </div>
    </div>

    <!-- SECTION 1: REAL APPLICATION STATISTICS (DARK NAVY CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Applications -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Applications</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalAppsCount) }}</h3>
        </div>

        <!-- Card 2: Shortlisted -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Shortlisted</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($shortlistedCount) }}</h3>
        </div>

        <!-- Card 3: Interview Scheduled -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Interview Scheduled</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($interviewCount) }}</h3>
        </div>

        <!-- Card 4: Placed (Offers) -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Placed (Offers)</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($hiredCount) }}</h3>
        </div>
    </div>

    <!-- SECTION 2: REAL APPLICATIONS TABLE (DARK NAVY TABLE) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 text-white text-[11px] font-black uppercase tracking-wider border-b border-slate-800">
                        <th class="p-4">Student</th>
                        <th class="p-4">Job Applied</th>
                        <th class="p-4">Company</th>
                        <th class="p-4">Applied Date</th>
                        <th class="p-4 text-center">Current Status</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($applications as $app)
                        @php
                            $studentName = $app->user ? ($app->user->first_name . ' ' . $app->user->last_name) : 'Student';
                            $companyName = $app->jobPosting?->company?->name ?? 'Enterprise Partner';
                        @endphp
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <!-- Student Avatar & Info -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 12px;" class="flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($studentName, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-xs">{{ $studentName }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $app->user?->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Job Applied -->
                            <td class="p-4">
                                <div class="font-bold text-white">{{ $app->jobPosting?->title ?? 'Software Engineer' }}</div>
                                <div class="text-[11px] text-slate-400 font-medium">{{ $companyName }}</div>
                            </td>

                            <!-- Company Logo -->
                            <td class="p-4 font-bold text-slate-200">
                                {{ $companyName }}
                            </td>

                            <!-- Applied Date -->
                            <td class="p-4 font-medium text-slate-400">
                                {{ $app->created_at ? $app->created_at->format('d M Y') : 'N/A' }}
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4 text-center">
                                @if ($app->status === 'submitted')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-blue-500/20 text-blue-300 border border-blue-500/30">Applied</span>
                                @elseif ($app->status === 'shortlisted')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">Shortlisted</span>
                                @elseif ($app->status === 'interview_scheduled')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-purple-500/20 text-purple-300 border border-purple-500/30">Interview</span>
                                @elseif ($app->status === 'hired')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Offer / Hired</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-500/20 text-rose-300 border border-rose-500/30">Rejected</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-center">
                                <button wire:click="openStatusModal('{{ $app->id }}')" title="Update Status" class="px-3 py-1 bg-slate-800 border border-slate-700 text-slate-200 rounded-lg text-xs font-bold hover:bg-slate-700">Update Status</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-semibold">No job applications recorded in database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold text-slate-400">
            <span>Showing {{ $applications->count() }} of {{ $totalAppsCount }} real job applications</span>
        </div>
    </div>

    <!-- UPDATE STATUS MODAL -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="modalOpen = false" style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-2xl w-full max-w-md overflow-hidden text-white">
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black tracking-tight text-white">Update Placement Status</h3>
                    <p class="text-xs text-slate-400 font-medium">Select new pipeline status for this application.</p>
                </div>
                <button @click="modalOpen = false" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white">✕</button>
            </div>

            <form wire:submit.prevent="updateStatus" class="p-6 space-y-4 text-xs font-semibold">
                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">New Status</label>
                    <select wire:model="newStatus" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                        <option value="submitted" class="text-slate-900">Applied</option>
                        <option value="shortlisted" class="text-slate-900">Shortlisted</option>
                        <option value="interview_scheduled" class="text-slate-900">Interview Scheduled</option>
                        <option value="hired" class="text-slate-900">Offer / Hired</option>
                        <option value="rejected" class="text-slate-900">Rejected</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 font-bold">Cancel</button>
                    <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black shadow-md">Update Status</button>
                </div>
            </form>
        </div>
    </div>

</div>
