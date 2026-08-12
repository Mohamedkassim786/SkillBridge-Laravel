<div class="space-y-6 max-w-4xl mx-auto">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Server-Side Jitsi WebRTC Credentials & Token Policy</h1>
            <p class="text-xs text-slate-300">Configure WebRTC video server domain, JWT authentication credentials, token expiration times, and room naming rules.</p>
        </div>
    </div>

    <!-- JITSI FORM CARD -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-6 text-white">
        <form wire:submit.prevent="saveSettings" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Jitsi Domain Server</label>
                    <input type="text" wire:model="domain" required placeholder="meet.jit.si or jitsi.yourdomain.com" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">JWT Authentication Mode</label>
                    <select wire:model="useJwt" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold">
                        <option value="0">Disabled (Public Jitsi Rooms)</option>
                        <option value="1">Enabled (Private JWT Authenticated Rooms)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">JWT App ID (App Key)</label>
                    <input type="text" wire:model="appId" placeholder="vpaas-magic-cookie-..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">JWT Secret / Private Key (Masked)</label>
                    <input type="password" wire:model="appSecret" placeholder="••••••••••••••••" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Room Naming Pattern</label>
                    <input type="text" wire:model="roomNamingPattern" placeholder="live_class_{ulid}" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">JWT Token Expiration (Minutes)</label>
                    <input type="number" wire:model="tokenExpirationMins" min="15" max="1440" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs font-mono">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">🔒 Credentials remain strictly server-side and are signed dynamically into meeting options.</span>
                <button type="submit" style="background-color: #f15153;" class="px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md">
                    Save Jitsi Configuration
                </button>
            </div>
        </form>
    </div>
</div>
