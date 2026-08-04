<div>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Set New Password</h2>
        <p class="mt-2 text-sm text-slate-600">Enter your new password below to reset your SkillBridge account access.</p>
    </div>

    <form wire:submit="resetPassword" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-800">Email Address</label>
            <input wire:model="email" id="email" type="email" required readonly
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-200 bg-slate-100 text-sm text-slate-600 cursor-not-allowed">
            @error('email') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-800">New Password</label>
            <input wire:model="password" id="password" type="password" required
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('password') border-rose-500 @enderror"
                   placeholder="••••••••">
            @error('password') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-800">Confirm New Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                   placeholder="••••••••">
        </div>

        <div>
            <button type="submit" wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
                <span wire:loading.remove>Update Password</span>
                <span wire:loading>Resetting Password...</span>
            </button>
        </div>
    </form>
</div>
