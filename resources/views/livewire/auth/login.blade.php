<div>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-white tracking-tight">Welcome Back</h2>
        <p class="mt-2 text-sm text-purple-200">Sign in to your SkillBridge account to continue learning or managing jobs.</p>
    </div>

    <form wire:submit="authenticate" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-extrabold text-white">Email Address</label>
            <div class="mt-1.5 relative rounded-lg shadow-sm">
                <input wire:model="email" id="email" type="email" autocomplete="email" required
                       style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                       class="w-full px-4 py-3 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('email') border-rose-500 @enderror"
                       placeholder="name@example.com">
            </div>
            @error('email') <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-extrabold text-white">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs font-extrabold text-[#f15153] hover:underline transition-colors">
                    Forgot Password?
                </a>
            </div>
            <div class="mt-1.5 relative rounded-lg shadow-sm">
                <input wire:model="password" id="password" type="password" autocomplete="current-password" required
                       style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: #ffffff;"
                       class="w-full px-4 py-3 rounded-lg focus:border-[#f15153] focus:ring-2 focus:ring-[#f15153]/30 transition-all text-sm placeholder-purple-300/50 @error('password') border-rose-500 @enderror"
                       placeholder="••••••••">
            </div>
            @error('password') <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input wire:model="remember" type="checkbox" class="w-4 h-4 rounded border-purple-400 text-[#f15153] focus:ring-[#f15153]">
                <span class="text-sm font-medium text-purple-200">Remember this device</span>
            </label>
        </div>

        <div>
            <button type="submit" wire:loading.attr="disabled"
                    style="background-color: #f15153; box-shadow: 0 4px 20px rgba(241,81,83,0.4);"
                    class="w-full py-3.5 px-4 rounded-xl text-white font-black text-sm hover:opacity-90 transition-all duration-200 flex items-center justify-center gap-2">
                <span wire:loading.remove>Sign In to Account</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Authenticating...
                </span>
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 text-center" style="border-top: 1px solid rgba(255,255,255,0.1);">
        <p class="text-sm text-purple-200">
            Don't have a student account?
            <a href="{{ route('register') }}" class="font-extrabold text-[#f15153] hover:underline transition-colors">
                Register as Student
            </a>
        </p>
    </div>
</div>
