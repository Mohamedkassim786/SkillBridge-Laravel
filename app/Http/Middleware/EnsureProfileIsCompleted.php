<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileIsCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->hasRole('student')) {
            $percentage = $user->profile?->profile_completion_percentage ?? 0;

            if ($percentage < 50 && ! $request->routeIs('profile.complete', 'profile.complete.store', 'logout')) {
                return redirect()->route('profile.complete')->with('warning', 'Please complete your student profile details before proceeding.');
            }
        }

        return $next($request);
    }
}
