<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Contracts\UserProfileRepositoryInterface;
use App\Models\UserProfile;

class ProfileCompletionService
{
    public function __construct(
        protected UserProfileRepositoryInterface $profileRepository
    ) {}

    public function calculateAndUpdate(UserProfile $profile): int
    {
        $score = 0;

        if (! empty($profile->avatar_url)) {
            $score += 15;
        }

        if (! empty($profile->date_of_birth)) {
            $score += 10;
        }

        if (! empty($profile->gender)) {
            $score += 10;
        }

        if (! empty($profile->education)) {
            $score += 15;
        }

        if (! empty($profile->address) || ! empty($profile->city) || ! empty($profile->country)) {
            $score += 15;
        }

        if (! empty($profile->bio) || ! empty($profile->headline)) {
            $score += 15;
        }

        if (! empty($profile->skills) && is_array($profile->skills) && count($profile->skills) > 0) {
            $score += 10;
        }

        if (! empty($profile->linkedin_url) || ! empty($profile->github_url)) {
            $score += 10;
        }

        $percentage = min(100, $score);
        $this->profileRepository->updateCompletionPercentage($profile, $percentage);

        return $percentage;
    }
}
