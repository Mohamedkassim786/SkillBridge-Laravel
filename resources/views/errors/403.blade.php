<x-layouts.auth title="Access Denied (403)">
    <div class="text-center py-6">
        <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>

        <h2 class="text-3xl font-extrabold text-[#0B1F3A] tracking-tight">403 - Access Denied</h2>
        <p class="mt-3 text-sm text-slate-600 leading-relaxed">
            You do not have authorization to view this area or perform this action.
        </p>

        <div class="mt-8">
            <a href="{{ route('login') }}" class="w-full inline-flex justify-center py-3.5 px-4 rounded-lg bg-[#0B1F3A] hover:bg-slate-900 text-white font-semibold text-sm shadow-md transition-all">
                Return to Dashboard
            </a>
        </div>
    </div>
</x-layouts.auth>
