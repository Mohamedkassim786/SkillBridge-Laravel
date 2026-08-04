<div>
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Create Student Account</h2>
        <p class="mt-2 text-sm text-slate-600">Join SkillBridge to access sequential courses, chapter quizzes, and verified job postings.</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-semibold text-slate-800">First Name</label>
                <input wire:model="first_name" id="first_name" type="text" required
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('first_name') border-rose-500 @enderror"
                       placeholder="Alex">
                @error('first_name') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="last_name" class="block text-sm font-semibold text-slate-800">Last Name</label>
                <input wire:model="last_name" id="last_name" type="text" required
                       class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('last_name') border-rose-500 @enderror"
                       placeholder="Morgan">
                @error('last_name') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-800">Email Address</label>
            <input wire:model="email" id="email" type="email" autocomplete="email" required
                   class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('email') border-rose-500 @enderror"
                   placeholder="alex.morgan@example.com">
            @error('email') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-semibold text-slate-800">Mobile Phone (Optional)</label>
            <input wire:model="phone" id="phone" type="tel"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('phone') border-rose-500 @enderror"
                   placeholder="+1 (555) 000-0000">
            @error('phone') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-800">Password</label>
            <input wire:model="password" id="password" type="password" required
                   class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm @error('password') border-rose-500 @enderror"
                   placeholder="••••••••">
            <p class="mt-1 text-[11px] text-slate-500">Min 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special character.</p>
            @error('password') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-800">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                   class="mt-1 w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:border-[#D62828] focus:ring-2 focus:ring-[#D62828]/20 transition-all text-sm"
                   placeholder="••••••••">
        </div>

        <div class="pt-2">
            <label class="flex items-start gap-2.5 cursor-pointer">
                <input wire:model="terms" type="checkbox" required class="mt-1 w-4 h-4 rounded border-slate-300 text-[#D62828] focus:ring-[#D62828]">
                <span class="text-xs text-slate-600 leading-normal">
                    I accept the <a href="#" class="font-semibold text-[#0B1F3A] underline">Terms of Service</a> and <a href="#" class="font-semibold text-[#0B1F3A] underline">Privacy Policy</a>.
                </span>
            </label>
            @error('terms') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit" wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-lg shadow-[#D62828]/25 transition-all flex items-center justify-center gap-2">
                <span wire:loading.remove>Create Student Account</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    Processing Registration...
                </span>
            </button>
        </div>
    </form>

    <div class="mt-6 pt-4 border-t border-slate-200 text-center">
        <p class="text-sm text-slate-600">
            Already registered?
            <a href="{{ route('login') }}" class="font-bold text-[#0B1F3A] hover:text-[#D62828] transition-colors">
                Sign In
            </a>
        </p>
    </div>
</div>
