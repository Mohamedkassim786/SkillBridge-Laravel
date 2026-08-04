<?php

namespace App\Domain\Auth\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findById(string $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(array $data): User;

    public function update(User $user, array $data): bool;

    public function updateStatus(User $user, string $status): bool;

    public function lockAccount(User $user, int $minutes = 15): void;

    public function unlockAccount(User $user): void;
}
