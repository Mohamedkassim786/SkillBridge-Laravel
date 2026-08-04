<?php

namespace App\Domain\Auth\Contracts;

use App\Models\User;
use App\Models\UserProfile;

interface UserProfileRepositoryInterface
{
    public function findByUserId(string $userId): ?UserProfile;

    public function createForUser(User $user, array $data = []): UserProfile;

    public function updateProfile(UserProfile $profile, array $data): bool;

    public function updateCompletionPercentage(UserProfile $profile, int $percentage): bool;
}
