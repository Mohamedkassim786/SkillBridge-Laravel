<?php

namespace App\Domain\Auth\Actions;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function execute(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'role' => $data['role'] ?? 'student',
            'status' => 'active',
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'headline' => $data['headline'] ?? null,
            'bio' => $data['bio'] ?? null,
        ]);

        return $user;
    }
}
