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
                <span class="text-rose-400 font-bold">Companies</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Hiring Company Directory</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Manage recruiter accounts and verify hiring companies.</p>
        </div>
    </div>

    <!-- ACTION BAR (DARK NAVY CARD) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl flex flex-col xl:flex-row xl:items-center justify-between gap-4 text-white">
        <!-- Left Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="openCreateModal" style="background-color: #D62828;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:bg-red-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Company</span>
            </button>
            <button style="color: white; border: 1.5px solid #1e3a5f; background: rgba(255,255,255,0.05);" class="px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-white/10 transition-all flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Verify Selected</span>
            </button>
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-[300px]">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search companies..." style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;" class="w-full pl-9 pr-4 py-2 rounded-xl text-xs font-medium text-white placeholder-slate-400 focus:outline-none focus:border-rose-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <select wire:model.live="selectedIndustry" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Industries</option>
                <option value="IT Services" class="text-slate-900">IT Services</option>
                <option value="Product Engineering" class="text-slate-900">Product Engineering</option>
                <option value="Fintech" class="text-slate-900">Fintech</option>
                <option value="E-Commerce" class="text-slate-900">E-Commerce</option>
            </select>

            <select wire:model.live="selectedVerification" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Status</option>
                <option value="verified" class="text-slate-900">Verified</option>
                <option value="unverified" class="text-slate-900">Unverified / Pending</option>
            </select>
        </div>
    </div>

    <!-- SECTION 1: REAL COMPANY STATISTICS (DARK NAVY CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Companies -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M9 8h.01M15 16h.01M15 12h.01M15 8h.01"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Companies</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalCompaniesCount) }}</h3>
        </div>

        <!-- Card 2: Verified Companies -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Verified Companies</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($verifiedCompaniesCount) }}</h3>
        </div>

        <!-- Card 3: Total Jobs Posted -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Jobs Posted</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalJobsCount) }}</h3>
        </div>

        <!-- Card 4: Total Students Hired -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Students Hired</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ number_format($totalHiredCount) }}</h3>
        </div>
    </div>

    <!-- SECTION 2: COMPANIES TABLE (DARK NAVY TABLE) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 text-white text-[11px] font-black uppercase tracking-wider border-b border-slate-800">
                        <th class="p-4">Company</th>
                        <th class="p-4">Industry</th>
                        <th class="p-4">Contact Person</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Phone</th>
                        <th class="p-4 text-center">Jobs Posted</th>
                        <th class="p-4 text-center">Verification</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($companies as $c)
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-[#D62828] text-white font-extrabold flex items-center justify-center text-xs shadow-sm shrink-0">
                                        {{ strtoupper(substr($c->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-sm hover:text-rose-400 transition-colors cursor-pointer">{{ $c->name }}</div>
                                        <div class="text-[11px] text-slate-400 font-medium">{{ $c->location ?? 'India' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    {{ $c->industry ?? 'IT Services' }}
                                </span>
                            </td>

                            <td class="p-4 font-bold text-slate-200">
                                {{ $c->contact_person ?? 'HR Manager' }}
                            </td>

                            <td class="p-4 font-medium text-slate-300">
                                {{ $c->email }}
                            </td>

                            <td class="p-4 font-mono font-medium text-slate-400">
                                {{ $c->phone ?? 'N/A' }}
                            </td>

                            <td class="p-4 text-center font-extrabold text-white">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 inline-flex items-center gap-1">
                                    💼 {{ $c->job_postings_count }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                @if ($c->is_verified)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 flex items-center justify-center gap-1">
                                        ✓ Verified
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="editCompany('{{ $c->id }}')" title="Edit" class="p-1.5 text-blue-400 hover:bg-blue-500/20 rounded-lg text-xs font-bold">Edit</button>
                                    @if (! $c->is_verified)
                                        <button wire:click="verifyCompany('{{ $c->id }}')" title="Verify Company" class="p-1.5 text-emerald-400 hover:bg-emerald-500/20 rounded-lg text-xs font-bold">Verify</button>
                                    @endif
                                    <button wire:click="deleteCompany('{{ $c->id }}')" wire:confirm="Delete this company?" title="Delete" class="p-1.5 text-rose-400 hover:bg-rose-500/20 rounded-lg text-xs font-bold">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-semibold">No companies found in database. Click "Add Company" to add one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold text-slate-400">
            <span>Showing {{ $companies->count() }} of {{ $totalCompaniesCount }} real hiring companies</span>
        </div>
    </div>

    <!-- CREATE / EDIT COMPANY MODAL -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div @click.away="modalOpen = false" style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-2xl w-full max-w-xl overflow-hidden text-white">
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black tracking-tight text-white">{{ $editingCompanyId ? 'Edit Company Profile' : 'Add New Hiring Company' }}</h3>
                    <p class="text-xs text-slate-400 font-medium">Enter recruiter company contact details and verification status.</p>
                </div>
                <button @click="modalOpen = false" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white transition-colors">✕</button>
            </div>

            <form wire:submit.prevent="saveCompany" class="p-6 space-y-4 text-xs font-semibold">
                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">Company Name</label>
                    <input type="text" wire:model="name" placeholder="e.g. Tata Consultancy Services" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white placeholder-slate-500 focus:outline-none">
                    @error('name') <span class="text-rose-400 text-[11px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Industry</label>
                        <select wire:model="industry" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                            <option value="IT Services" class="text-slate-900">IT Services</option>
                            <option value="Product Engineering" class="text-slate-900">Product Engineering</option>
                            <option value="Fintech" class="text-slate-900">Fintech</option>
                            <option value="E-Commerce" class="text-slate-900">E-Commerce</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">HQ Location</label>
                        <input type="text" wire:model="location" placeholder="e.g. Chennai, Tamil Nadu" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Contact Person</label>
                        <input type="text" wire:model="contact_person" placeholder="e.g. Rajesh Kumar, HR Manager" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-slate-300 font-bold uppercase mb-1">Phone Number</label>
                        <input type="text" wire:model="phone" placeholder="+91 98765 43210" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">HR Email Address</label>
                    <input type="email" wire:model="email" placeholder="hr@tcs.com" style="background: #112240; border: 1px solid #1e3a5f;" class="w-full px-4 py-2.5 rounded-xl text-white focus:outline-none">
                    @error('email') <span class="text-rose-400 text-[11px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-slate-300 font-bold uppercase mb-1">Verification Status</label>
                    <select wire:model="is_verified" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl focus:outline-none">
                        <option value="1" class="text-slate-900">Verified Company (Badge Granted)</option>
                        <option value="0" class="text-slate-900">Unverified / Pending Verification</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold">
                        Cancel
                    </button>
                    <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white text-xs font-black shadow-md hover:bg-red-700 transition-all">
                        {{ $editingCompanyId ? 'Update Company' : 'Save Company' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
