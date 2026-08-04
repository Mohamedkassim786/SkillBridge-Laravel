<div class="text-center py-6">
    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-600 mx-auto flex items-center justify-center mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">Session Timed Out</h2>
    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
        Your browser session expired due to inactivity. Please sign in again to continue working.
    </p>

    <div class="mt-8">
        <a href="{{ route('login') }}" class="w-full inline-flex justify-center py-3.5 px-4 rounded-lg bg-[#D62828] hover:bg-[#b7102a] text-white font-semibold text-sm shadow-md transition-all">
            Sign In Again
        </a>
    </div>
</div>
