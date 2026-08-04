<div>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Forgot Password</h2>
        <p class="mt-2 text-sm text-slate-600">Enter your registered email address and we'll send you a password reset link.</p>
    </div>

    <form wire:submit="sendResetLink" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-800">Email Address</label>
            <input wire:model="email" id="email" type="email" autocomplete="email" required
                   class="mt-1.5 w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('email') border-rose-500 @enderror"
                   placeholder="name@example.com">
            @error('email') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit" wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
                <span wire:loading.remove>Send Password Reset Link</span>
                <span wire:loading>Processing...</span>
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-200 text-center">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-[#0B1F3A]">
            Remember your password? Sign In
        </a>
    </div>
</div>
