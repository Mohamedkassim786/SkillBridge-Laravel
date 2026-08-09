<?php

namespace App\Policies;

use App\Models\MockInterview;
use App\Models\User;

class MockInterviewPolicy
{
    /**
     * Determine whether the user can view the mock interview session.
     */
    public function view(User $user, MockInterview $interview): bool
    {
        return $user->id === $interview->student_id || $user->hasRole('admin') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can manage/submit answers for the mock interview.
     */
    public function update(User $user, MockInterview $interview): bool
    {
        return $user->id === $interview->student_id;
    }

    /**
     * Determine whether the user can delete the mock interview.
     */
    public function delete(User $user, MockInterview $interview): bool
    {
        return $user->id === $interview->student_id || $user->hasRole('admin') || $user->hasRole('super_admin');
    }
}
