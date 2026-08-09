<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Financial Transactions & Refund Processing</h1>
            <p class="text-xs text-slate-300">View real-time course payment logs, Gateway reference IDs, and process refunds.</p>
        </div>

        <div class="flex items-center gap-3">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="px-4 py-2 rounded-2xl text-xs font-bold text-emerald-400 shadow-md">
                Total Net Revenue: ₹{{ number_format($totalRevenue) }}
            </div>
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="px-4 py-2 rounded-2xl text-xs font-bold text-rose-400 shadow-md">
                Refunded: ₹{{ number_format($refundedTotal) }}
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-4 rounded-3xl shadow-xl flex items-center justify-between">
        <div class="text-xs font-bold text-slate-300">Filter Payment Status:</div>

        <select wire:model.live="statusFilter" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Transactions</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
            <option value="refunded">Refunded</option>
        </select>
    </div>

    <!-- TRANSACTIONS TABLE CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Transaction ID</th>
                        <th class="py-3 px-4">Student</th>
                        <th class="py-3 px-4">Gateway Provider</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($payments as $p)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-mono text-xs text-white">#{{ $p->id }}</td>
                            <td class="py-3.5 px-4 font-bold text-white">{{ $p->user?->name ?? $p->order?->user?->name ?? 'Student' }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">{{ strtoupper($p->provider ?? 'Razorpay') }}</td>
                            <td class="py-3.5 px-4 font-bold text-emerald-400">₹{{ number_format($p->amount) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $p->status === 'completed' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : '' }}
                                    {{ $p->status === 'refunded' ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : '' }}
                                    {{ $p->status === 'pending' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : '' }}">
                                    {{ strtoupper($p->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ $p->created_at->format('M d, Y H:i') }}</td>
                            <td class="py-3.5 px-4 text-right">
                                @if ($p->status === 'completed')
                                    <button wire:click="processRefund('{{ $p->id }}')" wire:confirm="Process full refund for this transaction?" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                        Issue Refund
                                    </button>
                                @else
                                    <span class="text-slate-500 italic text-[11px]">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">No payment transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($payments->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
