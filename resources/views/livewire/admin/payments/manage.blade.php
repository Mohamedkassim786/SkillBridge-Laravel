<div class="space-y-6" x-data="{}">

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
                <span class="text-rose-400 font-bold">Payments</span>
            </nav>
            <h1 class="text-2xl font-black text-white tracking-tight">Payment & Revenue Management</h1>
            <p class="text-xs text-slate-400 mt-0.5 font-medium">Track all transactions, subscriptions, and platform revenue.</p>
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
        </div>

        <!-- Right Search & Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-[300px]">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search user, transaction ID..." style="background: rgba(255,255,255,0.08); border: 1px solid #1e3a5f;" class="w-full pl-9 pr-4 py-2 rounded-xl text-xs font-medium text-white placeholder-slate-400 focus:outline-none focus:border-rose-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <select wire:model.live="selectedStatus" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold focus:outline-none">
                <option value="" class="text-slate-900">All Status</option>
                <option value="completed" class="text-slate-900">Success</option>
                <option value="pending" class="text-slate-900">Pending</option>
                <option value="refunded" class="text-slate-900">Refunded</option>
                <option value="failed" class="text-slate-900">Failed</option>
            </select>
        </div>
    </div>

    <!-- SECTION 1: REAL PAYMENT STATISTICS (DARK NAVY CARDS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Revenue -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-black text-lg">
                    ₹
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Revenue</p>
            <h3 class="text-2xl font-black text-white mt-1">₹{{ number_format($totalRevenue, 2) }}</h3>
        </div>

        <!-- Card 2: Stripe Revenue -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stripe Gateway</p>
            <h3 class="text-2xl font-black text-white mt-1">₹{{ number_format($subscriptionRevenue, 2) }}</h3>
        </div>

        <!-- Card 3: Razorpay Revenue -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Razorpay Gateway</p>
            <h3 class="text-2xl font-black text-white mt-1">₹{{ number_format($coursePurchaseRevenue, 2) }}</h3>
        </div>

        <!-- Card 4: Pending Payouts -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl p-5 shadow-xl text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Payouts</p>
            <h3 class="text-2xl font-black text-white mt-1">₹{{ number_format($pendingPayouts, 2) }}</h3>
        </div>
    </div>

    <!-- SECTION 2: REAL TRANSACTIONS TABLE (DARK NAVY TABLE) -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-2xl shadow-xl overflow-hidden space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-slate-300">
                <thead>
                    <tr class="bg-slate-900/90 text-white text-[11px] font-black uppercase tracking-wider border-b border-slate-800">
                        <th class="p-4">Transaction ID</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Gateway</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($payments as $pay)
                        @php
                            $userName = $pay->order?->user ? ($pay->order->user->first_name . ' ' . $pay->order->user->last_name) : 'Student User';
                        @endphp
                        <tr class="hover:bg-slate-800/60 transition-colors">
                            <td class="p-4 font-mono font-bold text-white">
                                #{{ $pay->transaction_id ?? ('TXN-' . substr($pay->id, 0, 8)) }}
                            </td>

                            <td class="p-4">
                                <div class="flex items-center gap-2.5">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #D62828; color: white; font-weight: 800; font-size: 11px;" class="flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($userName, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white">{{ $userName }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $pay->order?->user?->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-blue-500/20 text-blue-300 border border-blue-500/30 uppercase">
                                    💳 {{ $pay->gateway ?? 'Razorpay' }}
                                </span>
                            </td>

                            <td class="p-4 font-black text-emerald-400 text-sm">
                                ₹{{ number_format($pay->amount, 2) }}
                            </td>

                            <td class="p-4 font-medium text-slate-400">
                                {{ $pay->created_at ? $pay->created_at->format('d M Y, h:i A') : 'N/A' }}
                            </td>

                            <td class="p-4 text-center">
                                @if ($pay->status === 'completed' || $pay->status === 'success')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Completed</span>
                                @elseif ($pay->status === 'refunded')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-purple-500/20 text-purple-300 border border-purple-500/30">Refunded</span>
                                @elseif ($pay->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-500/20 text-rose-300 border border-rose-500/30">Failed</span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                @if ($pay->status === 'completed' || $pay->status === 'success')
                                    <button wire:click="processRefund('{{ $pay->id }}')" wire:confirm="Mark this transaction as refunded?" class="px-2.5 py-1 bg-slate-800 border border-slate-700 text-rose-400 rounded-lg text-xs font-bold hover:bg-slate-700">Refund</button>
                                @else
                                    <span class="text-slate-500 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-semibold">No payment transactions recorded in database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 flex items-center justify-between text-xs font-semibold text-slate-400">
            <span>Showing {{ $payments->count() }} transactions</span>
            <div>{{ $payments->links() }}</div>
        </div>
    </div>

</div>
