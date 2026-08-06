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
                <span class="text-rose-400 font-bold">Jobs</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Job Board Management</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Manage all job postings, employer partners, and live API feeds.</p>
        </div>
    </div>

    <!-- ACTION BAR (DARK NAVY CARD) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl flex flex-col xl:flex-row xl:items-center justify-between gap-4 text-white">
        <!-- Left Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="openCreateModal" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:bg-red-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Job</span>
            </button>
            <button wire:click="syncAdzunaJobs" wire:loading.attr="disabled" style="background-color: #112240; border: 1px solid #1e3a5f;" class="px-4 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:bg-slate-800 transition-all flex items-center gap-2 disabled:opacity-50 relative">
                <span wire:loading.remove class="flex items-center gap-1.5">📡 Sync Live Jobs (Adzuna API)</span>
                <span wire:loading class="flex items-center gap-1.5">
                    <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Syncing Jobs...
                </span>
            </button>
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-[300px]">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search jobs, companies..." style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;" class="w-full pl-9 pr-4 py-2 rounded-xl text-xs font-medium text-white placeholder-slate-400 focus:outline-none focus:border-rose-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <select wire:model.live="selectedCompany" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Companies</option>
                @foreach ($companies as $comp)
                    <option value="{{ $comp->id }}" class="text-slate-900">{{ $comp->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="selectedStatus" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Status</option>
                <option value="active" class="text-slate-900">Active</option>
                <option value="pending" class="text-slate-900">Pending Approval</option>
                <option value="closed" class="text-slate-900">Expired / Closed</option>
            </select>
        </div>
    </div>

    <!-- SECTION 1: REAL JOB STATISTICS (DARK NAVY CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Jobs -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Job Postings</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalJobsCount) }}</h3>
        </div>

        <!-- Card 2: Active Jobs -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Published Jobs</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($activeJobsCount) }}</h3>
        </div>

        <!-- Card 3: Pending Approval -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Drafts</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($pendingJobsCount) }}</h3>
        </div>

        <!-- Card 4: Total Candidate Applications -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Applications Received</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalApplicationsCount) }}</h3>
        </div>
    </div>

    <!-- SECTION 2: REAL JOBS TABLE (DARK NAVY TABLE) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 text-white text-[11px] font-black uppercase tracking-wider border-b border-slate-800">
                        <th class="p-4">Job Title</th>
                        <th class="p-4">Company</th>
                        <th class="p-4">Location</th>
                        <th class="p-4">Salary Package</th>
                        <th class="p-4 text-center">Applications</th>
                        <th class="p-4">Posted Date</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($jobs as $j)
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <td class="p-4 font-bold text-white">
                                <div>
                                    <div class="font-bold text-white text-sm hover:text-rose-400 transition-colors cursor-pointer">{{ $j->title }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium">Source: {{ ucfirst($j->source ?? 'Internal') }}</div>
                                </div>
                            </td>

                            <td class="p-4 font-bold text-slate-200">
                                {{ $j->company?->name ?? 'Enterprise Employer' }}
                            </td>

                            <td class="p-4 font-semibold text-slate-400">
                                📍 {{ $j->location ?? 'India' }}
                            </td>

                            <td class="p-4 font-bold text-emerald-400">
                                💰 ₹{{ number_format(($j->salary_min ?? 500000) / 100000, 1) }}L - {{ number_format(($j->salary_max ?? 800000) / 100000, 1) }}L
                            </td>

                            <td class="p-4 text-center font-extrabold text-white">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 inline-flex items-center gap-1">
                                    📝 {{ $j->applications?->count() ?: 0 }}
                                </span>
                            </td>

                            <td class="p-4 font-medium text-slate-400">
                                {{ $j->created_at ? $j->created_at->diffForHumans() : 'N/A' }}
                            </td>

                            <td class="p-4 text-center">
                                @if ($j->status === 'active')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Active</span>
                                @elseif ($j->status === 'draft' || $j->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-500/20 text-rose-300 border border-rose-500/30">Expired</span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="editJob('{{ $j->id }}')" title="Edit Job" class="p-1.5 text-blue-400 hover:bg-blue-500/20 rounded-lg text-xs font-bold">Edit</button>
                                    @if ($j->status === 'draft' || $j->status === 'pending')
                                        <button wire:click="approveJob('{{ $j->id }}')" title="Approve Job" class="p-1.5 text-emerald-400 hover:bg-emerald-500/20 rounded-lg text-xs font-bold">Approve</button>
                                    @endif
                                    <button wire:click="deleteJob('{{ $j->id }}')" wire:confirm="Are you sure you want to delete this job posting?" title="Delete Job" class="p-1.5 text-rose-400 hover:bg-rose-500/20 rounded-lg text-xs font-bold">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-semibold">No job postings in database. Click "Add New Job" or "Sync Live Jobs" to populate.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold text-slate-400">
            <span>Showing {{ $jobs->count() }} of {{ $totalJobsCount }} real job postings</span>
        </div>
    </div>

    <!-- CREATE / EDIT JOB MODAL -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="modalOpen = false" style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden text-white">
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black tracking-tight text-white">{{ $editingJobId ? 'Edit Job Posting' : 'Post New Job' }}</h3>
                    <p class="text-xs text-slate-400 font-medium">Fill in job details, company, and salary package.</p>
                </div>
                <button @click="modalOpen = false" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white">✕</button>
            </div>

            <form wire:submit.prevent="saveJob" class="p-6 space-y-4 text-xs font-semibold">
                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">Job Title</label>
                    <input type="text" wire:model="title" placeholder="e.g. Senior Laravel Developer" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                    @error('title') <span class="text-rose-400 text-[11px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Company</label>
                        <select wire:model="company_id" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}" class="text-slate-900">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Location</label>
                        <input type="text" wire:model="location" placeholder="e.g. Chennai, Tamil Nadu" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Salary Min (Annual ₹)</label>
                        <input type="number" wire:model="salary_min" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Salary Max (Annual ₹)</label>
                        <input type="number" wire:model="salary_max" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">Posting Status</label>
                    <select wire:model="status" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                        <option value="active" class="text-slate-900">Active (Published)</option>
                        <option value="draft" class="text-slate-900">Pending Approval</option>
                        <option value="closed" class="text-slate-900">Expired / Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">Job Description & Responsibilities</label>
                    <textarea wire:model="description" rows="4" placeholder="Enter role requirements..." style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white placeholder-slate-500 focus:outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 font-bold">Cancel</button>
                    <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-black shadow-md">
                        {{ $editingJobId ? 'Update Job Posting' : 'Publish Job Posting' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
