<?php

namespace App\Domain\Auth\Services;

use App\Models\User;

class RoleRedirectionService
{
    public function getRedirectRoute(User $user): string
    {
        if ($user->hasRole('super_admin')) {
            return route('super_admin.dashboard');
        }

        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('staff') || $user->hasRole('trainer')) {
            return route('staff.dashboard');
        }

        return route('student.dashboard');
    }

    public function getRedirectPath(User $user): string
    {
        if ($user->hasRole('super_admin')) {
            return '/super-admin/dashboard';
        }

        if ($user->hasRole('admin')) {
            return '/admin/dashboard';
        }

        if ($user->hasRole('staff') || $user->hasRole('trainer')) {
            return '/staff/dashboard';
        }

        return '/student/dashboard';
    }
}
