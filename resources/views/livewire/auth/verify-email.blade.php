<div class="text-center py-4">
    <div class="w-16 h-16 rounded-full bg-blue-50 text-[#0B1F3A] mx-auto flex items-center justify-center mb-6 border border-blue-100">
        <svg class="w-8 h-8 text-[#D62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Verify Your Email</h2>
    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
        Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
    </p>

    <div class="mt-8 space-y-4">
        <button wire:click="resendNotification" wire:loading.attr="disabled"
                class="w-full py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
            <span wire:loading.remove>Resend Verification Email</span>
            <span wire:loading>Sending fresh verification link...</span>
        </button>

        <div>
            <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-500 hover:text-[#0B1F3A]">
                Back to Sign In
            </a>
        </div>
    </div>
</div>
