<div class="space-y-6 max-w-4xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">API Integrations, SMTP Mail & Communication Providers</h1>
            <p class="text-xs text-slate-300">Configure SMTP mail servers, notification providers, and trigger real-time delivery test messages.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-6 text-white">
        <form wire:submit.prevent="saveMailConfig" class="space-y-6">
            <h3 class="text-sm font-black text-rose-400 uppercase tracking-wider">1. SMTP Mail Server Configuration</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">SMTP Host</label>
                    <input type="text" wire:model="smtpHost" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">SMTP Port</label>
                    <input type="number" wire:model="smtpPort" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">SMTP Username</label>
                    <input type="text" wire:model="smtpUsername" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">SMTP Password (Masked)</label>
                    <input type="password" wire:model="smtpPassword" placeholder="••••••••••••" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 mb-1">Mail Sender Address</label>
                    <input type="email" wire:model="mailFromAddress" required style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">📧 System notifications & live class reminders use this mail driver.</span>
                <button type="submit" style="background-color: #D62828;" class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md">
                    Save Mail Credentials
                </button>
            </div>
        </form>
    </div>

    <!-- TEST MESSAGE DISPATCHER CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <h3 class="text-base font-black text-white">Trigger Real-Time Delivery Test Message</h3>

        <form wire:submit.prevent="sendTestMessage" class="flex flex-col sm:flex-row gap-3">
            <input type="email" wire:model="testEmailRecipient" required placeholder="Enter recipient email address..." style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-mono">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md whitespace-nowrap">
                🚀 Send Test Message
            </button>
        </form>

        @if ($testMessageStatus)
            <div class="p-4 rounded-xl text-xs font-mono font-bold border {{ str_contains($testMessageStatus, 'SUCCESS') ? 'bg-emerald-500/20 border-emerald-500/30 text-emerald-300' : 'bg-rose-500/20 border-rose-500/30 text-rose-300' }}">
                {{ $testMessageStatus }}
            </div>
        @endif
    </div>
</div>
