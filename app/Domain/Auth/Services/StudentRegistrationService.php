<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Contracts\UserProfileRepositoryInterface;
use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Domain\Auth\Events\UserRegisteredEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentRegistrationService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserProfileRepositoryInterface $profileRepository
    ) {}

    public function registerStudent(array $data): User
    {
        $user = $this->userRepository->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => strtolower(trim($data['email'])),
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'status' => 'pending_verification',
        ]);

        $user->assignRole('student');

        $this->profileRepository->createForUser($user, [
            'profile_completion_percentage' => 10,
        ]);

        event(new UserRegisteredEvent($user));

        return $user;
    }
}
