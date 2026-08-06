<?php

namespace App\Policies;

use App\Models\LiveClass;
use App\Models\User;
use App\Services\JitsiLiveClassService;

class LiveClassPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'staff', 'trainer', 'student']);
    }

    public function view(User $user, LiveClass $liveClass): bool
    {
        if ($user->hasRole(['super_admin', 'admin'])) {
            return true;
        }

        if ($user->hasRole(['staff', 'trainer'])) {
            return $liveClass->trainer_id === $user->id || $liveClass->created_by === $user->id;
        }

        if ($user->hasRole('student')) {
            $service = app(JitsiLiveClassService::class);
            return $service->canJoin($liveClass, $user);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'staff', 'trainer']);
    }

    public function update(User $user, LiveClass $liveClass): bool
    {
        if ($user->hasRole(['super_admin', 'admin'])) {
            return true;
        }

        return $user->hasRole(['staff', 'trainer']) && ($liveClass->trainer_id === $user->id || $liveClass->created_by === $user->id);
    }

    public function delete(User $user, LiveClass $liveClass): bool
    {
        return $this->update($user, $liveClass);
    }

    public function join(User $user, LiveClass $liveClass): bool
    {
        $service = app(JitsiLiveClassService::class);
        return $service->canJoin($liveClass, $user);
    }

    public function viewAttendance(User $user, LiveClass $liveClass): bool
    {
        return $this->update($user, $liveClass);
    }

    public function uploadRecording(User $user, LiveClass $liveClass): bool
    {
        return $this->update($user, $liveClass);
    }

    public function publishRecording(User $user, LiveClass $liveClass): bool
    {
        return $this->update($user, $liveClass);
    }
}
