<?php

namespace App\Domain\Auth\Repositories;

use App\Domain\Auth\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $id): ?User
    {
        return User::with('profile')->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::with('profile')->where('email', strtolower(trim($email)))->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function updateStatus(User $user, string $status): bool
    {
        return $user->update(['status' => $status]);
    }

    public function lockAccount(User $user, int $minutes = 15): void
    {
        $user->update([
            'status' => 'suspended',
            'locked_until' => now()->addMinutes($minutes),
        ]);
    }

    public function unlockAccount(User $user): void
    {
        $user->update([
            'status' => 'active',
            'locked_until' => null,
        ]);
    }
}
