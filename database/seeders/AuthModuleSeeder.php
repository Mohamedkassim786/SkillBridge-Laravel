<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class AuthModuleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Spatie Roles Exist
        $roles = ['super_admin', 'admin', 'staff', 'student'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@skillbridge.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Administrator',
                'password' => Hash::make('SkillBridge2026!'),
                'phone' => '+1 (555) 000-0001',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');
        UserProfile::firstOrCreate(['user_id' => $superAdmin->id], [
            'headline' => 'Platform Super Administrator',
            'profile_completion_percentage' => 100,
        ]);

        // 3. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@skillbridge.com'],
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'password' => Hash::make('SkillBridge2026!'),
                'phone' => '+1 (555) 000-0002',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');
        UserProfile::firstOrCreate(['user_id' => $admin->id], [
            'headline' => 'System Operations Manager',
            'profile_completion_percentage' => 100,
        ]);

        // 4. Staff (Trainer) User
        $staff = User::firstOrCreate(
            ['email' => 'staff@skillbridge.com'],
            [
                'first_name' => 'Senior',
                'last_name' => 'Trainer',
                'password' => Hash::make('SkillBridge2026!'),
                'phone' => '+1 (555) 000-0003',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $staff->assignRole('staff');
        UserProfile::firstOrCreate(['user_id' => $staff->id], [
            'headline' => 'Lead Full-Stack Trainer',
            'education' => 'M.S. Computer Science',
            'profile_completion_percentage' => 100,
        ]);

        // 5. Demo Student User
        $student = User::firstOrCreate(
            ['email' => 'student@skillbridge.com'],
            [
                'first_name' => 'Demo',
                'last_name' => 'Student',
                'password' => Hash::make('SkillBridge2026!'),
                'phone' => '+1 (555) 000-0004',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $student->assignRole('student');
        UserProfile::firstOrCreate(['user_id' => $student->id], [
            'headline' => 'Software Engineering Student',
            'education' => 'B.S. Information Technology',
            'city' => 'San Francisco',
            'country' => 'United States',
            'skills' => ['PHP', 'Laravel', 'JavaScript', 'SQL'],
            'profile_completion_percentage' => 85,
        ]);
    }
}
