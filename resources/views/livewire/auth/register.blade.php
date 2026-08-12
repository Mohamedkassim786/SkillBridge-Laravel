<div>
    <div class="mb-6">
        <h2 class="text-3xl font-black text-white tracking-tight">Create Student Account</h2>
        <p class="mt-2 text-sm text-purple-200">Join SkillBridge to access sequential courses, chapter quizzes, and verified job postings.</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-extrabold text-white">First Name</label>
                <input wire:model="first_name" id="first_name" type="text" required
                       style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('first_name') border-rose-500 @enderror"
                       placeholder="Alex">
                @error('first_name') <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="last_name" class="block text-sm font-extrabold text-white">Last Name</label>
                <input wire:model="last_name" id="last_name" type="text" required
                       style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                       class="mt-1 w-full px-4 py-2.5 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('last_name') border-rose-500 @enderror"
                       placeholder="Morgan">
                @error('last_name') <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-extrabold text-white">Email Address</label>
            <input wire:model="email" id="email" type="email" autocomplete="email" required
                   style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('email') border-rose-500 @enderror"
                   placeholder="alex.morgan@example.com">
            @error('email') <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-extrabold text-white">Mobile Phone (Optional)</label>
            <input wire:model="phone" id="phone" type="tel"
                   style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('phone') border-rose-500 @enderror"
                   placeholder="+1 (555) 000-0000">
            @error('phone') <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-extrabold text-white">Password</label>
            <input wire:model="password" id="password" type="password" required
                   style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('password') border-rose-500 @enderror"
                   placeholder="••••••••">
            <p class="mt-1 text-[11px] text-purple-300">Min 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special character.</p>
            @error('password') <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-extrabold text-white">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                   style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                   class="mt-1 w-full px-4 py-2.5 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50"
                   placeholder="••••••••">
        </div>

        <div class="pt-2">
            <label class="flex items-start gap-2.5 cursor-pointer">
                <input wire:model="terms" type="checkbox" required class="mt-1 w-4 h-4 rounded border-purple-400 text-[#f15153] focus:ring-[#f15153]">
                <span class="text-xs text-purple-200 leading-normal">
                    I accept the <a href="#" class="font-extrabold text-[#f15153] underline">Terms of Service</a> and <a href="#" class="font-extrabold text-[#f15153] underline">Privacy Policy</a>.
                </span>
            </label>
            @error('terms') <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit" wire:loading.attr="disabled"
                    style="background-color: #f15153; box-shadow: 0 4px 20px rgba(241,81,83,0.4);"
                    class="w-full py-3.5 px-4 rounded-xl text-white font-black text-sm hover:opacity-90 transition-all flex items-center justify-center gap-2">
                <span wire:loading.remove>Create Student Account</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    Processing Registration...
                </span>
            </button>
        </div>
    </form>

    <div class="mt-6 pt-4 text-center" style="border-top: 1px solid rgba(255,255,255,0.1);">
        <p class="text-sm text-purple-200">
            Already registered?
            <a href="{{ route('login') }}" class="font-extrabold text-[#f15153] hover:underline transition-colors">
                Sign In
            </a>
        </p>
    </div>
</div>
