<div class="text-center py-6">
    <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 mx-auto flex items-center justify-center mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Too Many Login Attempts</h2>
    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
        You have exceeded the maximum 5 allowed failed login attempts. Your account has been temporarily locked for 15 minutes for your security.
    </p>

    <div class="mt-8 space-y-4">
        <a href="{{ route('password.request') }}" class="w-full inline-flex justify-center py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
            Reset Your Password Now
        </a>
        <div>
            <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-500 hover:text-[#0B1F3A]">
                Back to Sign In
            </a>
        </div>
    </div>
</div>
