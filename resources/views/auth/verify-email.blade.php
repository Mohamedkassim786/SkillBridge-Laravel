<x-layouts.guest title="Verify email | SkillBridge">
    <div class="text-center">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-action-red">SkillBridge</p>
        <h1 class="mt-2 text-3xl font-bold text-primary-navy">Verify your email</h1>
        <p class="mt-3 text-sm text-slate-600">We sent a verification link to your email address. Open it to unlock your account.</p>
    </div>
    @if (session('status') === 'verification-link-sent') <p class="mt-5 rounded-lg bg-green-50 p-3 text-sm text-green-800">A new verification link has been sent.</p> @endif
    <form method="POST" action="{{ route('verification.send') }}" class="mt-6">@csrf <button class="w-full rounded-lg bg-action-red px-4 py-3 font-semibold text-white hover:bg-hover-red">Resend verification email</button></form>
    <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf <button class="w-full text-sm font-medium text-slate-600 hover:text-action-red">Sign out</button></form>
</x-layouts.guest>
