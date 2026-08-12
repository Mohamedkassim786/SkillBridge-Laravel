<div class="space-y-6 max-w-4xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Payment Gateway Credentials & Revenue Share Configuration</h1>
            <p class="text-xs text-slate-300">Manage Razorpay & Stripe credentials (secret keys remain masked), set platform fees, and trainer revenue split.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-6 text-white">
        <form wire:submit.prevent="saveSettings" class="space-y-6">
            
            <h3 class="text-sm font-black text-rose-400 uppercase tracking-wider">1. Razorpay Gateway Credentials</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Razorpay Key ID</label>
                    <input type="text" wire:model="razorpayKey" required style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Razorpay Secret Key (Masked)</label>
                    <input type="password" wire:model="razorpaySecret" placeholder="••••••••••••••••" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <h3 class="text-sm font-black text-rose-400 uppercase tracking-wider pt-4 border-t border-slate-800">2. Stripe Gateway Credentials</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Stripe Publishable Key</label>
                    <input type="text" wire:model="stripeKey" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Stripe Secret Key (Masked)</label>
                    <input type="password" wire:model="stripeSecret" placeholder="••••••••••••••••" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <h3 class="text-sm font-black text-rose-400 uppercase tracking-wider pt-4 border-t border-slate-800">3. Platform Revenue Share Policy</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Platform Commission Fee (%)</label>
                    <input type="number" step="0.1" wire:model="platformFeePercent" required style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Trainer Revenue Share (%)</label>
                    <input type="number" step="0.1" wire:model="trainerRevenueSharePercent" required style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">🔒 Secret keys are never exposed in raw text on screen.</span>
                <button type="submit" style="background-color: #f15153;" class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md">
                    Save Gateway Credentials
                </button>
            </div>
        </form>
    </div>
</div>
