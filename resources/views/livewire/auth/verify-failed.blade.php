<div class="text-center py-6">
    <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Verification Link Invalid</h2>
    <p class="mt-3 text-sm text-slate-600">The verification link is either invalid or has expired. Please request a new verification link.</p>

    <div class="mt-8 space-y-4">
        <a href="{{ route('verification.notice') }}" class="w-full inline-flex justify-center py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
            Request New Verification Link
        </a>
        <div>
            <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-500 hover:text-[#0B1F3A]">
                Back to Sign In
            </a>
        </div>
    </div>
</div>
