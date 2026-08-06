<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();

        // Support pipe-delimited roles e.g. "admin|super_admin"
        $expandedRoles = [];
        foreach ($roles as $role) {
            foreach (explode('|', $role) as $r) {
                $expandedRoles[] = trim($r);
            }
        }

        foreach ($expandedRoles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden access.'], 403);
        }

        return response()->view('errors.403', [], 403);
    }
}
