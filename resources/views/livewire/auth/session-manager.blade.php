<div>
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Active Device Sessions</h2>
        <p class="mt-1.5 text-sm text-slate-600">Manage and log out your active sessions on other browsers and devices.</p>
    </div>

    <div class="space-y-4 mb-8">
        @foreach ($this->sessions as $s)
            <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-sm flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                            {{ $s->ip_address }}
                            @if ($s->is_current_device)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">This Device</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-500 truncate max-w-xs">{{ $s->user_agent }}</div>
                        <div class="text-[11px] text-slate-400">Last active: {{ $s->last_active }}</div>
                    </div>
                </div>

                @if (!$s->is_current_device)
                    <button wire:click="deleteSession('{{ $s->id }}')" class="text-xs font-semibold text-rose-600 hover:text-rose-800">
                        Revoke
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <div class="p-6 rounded-xl border border-slate-200 bg-slate-50">
        <h3 class="text-base font-bold text-[#0B1F3A]">Log Out Other Browser Sessions</h3>
        <p class="mt-1 text-xs text-slate-600 mb-4">Please enter your password to confirm you would like to log out of all other browser sessions across all your devices.</p>

        <form wire:submit="logoutOtherDevices" class="space-y-4">
            <div>
                <input wire:model="password" type="password" required
                       class="w-full px-4 py-2.5 rounded-lg border border-slate-300 text-sm focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20"
                       placeholder="Enter current password">
                @error('password') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="py-2.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm transition-all">
                Log Out Other Browser Sessions
            </button>
        </form>
    </div>
</div>
