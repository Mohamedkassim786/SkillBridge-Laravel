<div class="space-y-6 text-white">
    <!-- TOP HEADER -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-3xl p-6 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">My Orders & Receipts</h1>
            <p class="text-xs mt-1" style="color: #a997be;">Transaction history and downloadable GST invoices.</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-bold bg-white/10 px-4 py-2 rounded-2xl border border-white/10">
            <span>💳 Total Paid: ₹{{ number_format($orders->sum('total_amount'), 2) }}</span>
        </div>
    </div>

    <!-- ORDERS TABLE -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-3xl shadow-xl overflow-hidden text-white">
        @if ($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-purple-200">
                    <thead>
                        <tr class="bg-[#1e0d2d] border-b border-purple-800/40 text-white font-black uppercase text-[11px]">
                            <th class="p-4">Order #</th>
                            <th class="p-4">Course Item</th>
                            <th class="p-4">Amount</th>
                            <th class="p-4">Payment Method</th>
                            <th class="p-4">Date</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-800/40 font-semibold">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-white/5 transition">
                                <td class="p-4 font-bold text-white">{{ $order->order_number }}</td>
                                <td class="p-4 text-white">
                                    {{ $order->items->first()?->courseVersion?->course?->title ?? 'Enterprise Course Subscription' }}
                                </td>
                                <td class="p-4 font-black text-emerald-400">₹{{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-4 uppercase font-mono" style="color: #a997be;">{{ $order->payment?->gateway ?? 'Razorpay' }}</td>
                                <td class="p-4" style="color: #a997be;">{{ $order->created_at?->format('M d, Y') ?? date('M d, Y') }}</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center space-y-3 text-white">
                <div class="text-4xl">💳</div>
                <h3 class="font-extrabold text-base text-white">No Orders Placed Yet</h3>
                <p class="text-xs max-w-sm mx-auto" style="color: #a997be;">Explore our premium enterprise development courses and complete enrollment using Razorpay or UPI.</p>
                <a href="{{ route('courses.index') }}" style="background-color: #f15153; box-shadow: 0 4px 14px rgba(241,81,83,0.35);" class="inline-block px-6 py-2.5 text-white rounded-xl text-xs font-black transition text-decoration-none">
                    Explore Courses ➔
                </a>
            </div>
        @endif
    </div>
</div>
