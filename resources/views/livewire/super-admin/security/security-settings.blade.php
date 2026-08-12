<div class="space-y-6 max-w-4xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Platform Security Policies & Session Restrictions</h1>
            <p class="text-xs text-slate-300">Enforce two-factor authentication, session timeout durations, login attempt throttling, and IP blocklists.</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-6 text-white">
        <form wire:submit.prevent="saveSecurity" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Require 2-Factor Authentication (2FA)</label>
                    <select wire:model="enforce2FA" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold">
                        <option value="0">Optional</option>
                        <option value="1">Required for All Admins & Trainers</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Session Inactivity Timeout (Minutes)</label>
                    <input type="number" wire:model="sessionTimeoutMins" required min="15" max="1440" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Max Login Failed Attempt Limit</label>
                    <input type="number" wire:model="maxLoginAttempts" required min="3" max="10" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">IP Address Blocklist (Comma-separated IPs)</label>
                <textarea wire:model="ipBlocklist" rows="3" placeholder="192.168.1.100, 10.0.0.45" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full p-4 rounded-xl text-xs font-mono focus:outline-none"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">🛡️ Security changes write directly to system audit trail.</span>
                <button type="submit" style="background-color: #f15153;" class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md">
                    Save Security Policies
                </button>
            </div>
        </form>
    </div>
</div>
