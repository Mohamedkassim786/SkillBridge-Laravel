<div>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Change Password</h2>
        <p class="mt-2 text-sm text-slate-600">Ensure your account is using a long, random password to stay secure.</p>
    </div>

    <form wire:submit="updatePassword" class="space-y-6">
        <div>
            <label for="current_password" class="block text-sm font-semibold text-slate-800">Current Password</label>
            <input wire:model="current_password" id="current_password" type="password" required
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('current_password') border-rose-500 @enderror">
            @error('current_password') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-800">New Password</label>
            <input wire:model="password" id="password" type="password" required
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('password') border-rose-500 @enderror">
            @error('password') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-800">Confirm New Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm">
        </div>

        <div>
            <button type="submit" wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
                <span wire:loading.remove>Save New Password</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </form>
</div>
