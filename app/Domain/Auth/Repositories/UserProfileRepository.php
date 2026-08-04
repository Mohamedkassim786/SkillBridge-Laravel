<?php

namespace App\Domain\Auth\Repositories;

use App\Domain\Auth\Contracts\UserProfileRepositoryInterface;
use App\Models\User;
use App\Models\UserProfile;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function findByUserId(string $userId): ?UserProfile
    {
        return UserProfile::where('user_id', $userId)->first();
    }

    public function createForUser(User $user, array $data = []): UserProfile
    {
        return UserProfile::create(array_merge(['user_id' => $user->id], $data));
    }

    public function updateProfile(UserProfile $profile, array $data): bool
    {
        return $profile->update($data);
    }

    public function updateCompletionPercentage(UserProfile $profile, int $percentage): bool
    {
        return $profile->update(['profile_completion_percentage' => $percentage]);
    }
}
