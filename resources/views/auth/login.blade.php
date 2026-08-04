<x-layouts.guest title="Sign in | SkillBridge">
    <div class="text-center">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-action-red">SkillBridge</p>
        <h1 class="mt-2 text-3xl font-bold text-primary-navy">Welcome back</h1>
        <p class="mt-2 text-sm text-slate-600">Sign in to continue your learning and career journey.</p>
    </div>

    @if (session('status')) <p class="rounded-lg bg-green-50 p-3 text-sm text-green-800">{{ session('status') }}</p> @endif

    <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
        @csrf
        <div>
            <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="mt-1 w-full rounded-lg border-slate-300 focus:border-red-600 focus:ring-red-600">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-1 w-full rounded-lg border-slate-300 focus:border-red-600 focus:ring-red-600">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600"><input name="remember" type="checkbox" class="rounded border-slate-300 text-red-600 focus:ring-red-600"> Remember me</label>
        <button class="w-full rounded-lg bg-action-red px-4 py-3 font-semibold text-white transition hover:bg-hover-red">Sign in</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">New to SkillBridge? <a class="font-semibold text-action-red hover:underline" href="{{ route('register') }}">Create a student account</a></p>
</x-layouts.guest>
