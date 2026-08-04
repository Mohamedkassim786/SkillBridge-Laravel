<x-layouts.guest title="Create account | SkillBridge">
    <div class="text-center">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-action-red">SkillBridge</p>
        <h1 class="mt-2 text-3xl font-bold text-primary-navy">Start learning</h1>
        <p class="mt-2 text-sm text-slate-600">Create your student account. We will verify your email before access is granted.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-7 space-y-4">
        @csrf
        <div><label for="name" class="text-sm font-medium text-slate-700">Full name</label><input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-1 w-full rounded-lg border-slate-300 focus:border-red-600 focus:ring-red-600">@error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
        <div><label for="email" class="text-sm font-medium text-slate-700">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="mt-1 w-full rounded-lg border-slate-300 focus:border-red-600 focus:ring-red-600">@error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
        <div><label for="password" class="text-sm font-medium text-slate-700">Password</label><input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-lg border-slate-300 focus:border-red-600 focus:ring-red-600"><p class="mt-1 text-xs text-slate-500">Use at least 12 characters.</p>@error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
        <div><label for="password_confirmation" class="text-sm font-medium text-slate-700">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-lg border-slate-300 focus:border-red-600 focus:ring-red-600"></div>
        <button class="w-full rounded-lg bg-action-red px-4 py-3 font-semibold text-white transition hover:bg-hover-red">Create account</button>
    </form>
    <p class="mt-6 text-center text-sm text-slate-600">Already registered? <a class="font-semibold text-action-red hover:underline" href="{{ route('login') }}">Sign in</a></p>
</x-layouts.guest>
