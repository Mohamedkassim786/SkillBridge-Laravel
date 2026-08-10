<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Enterprise Auth & Spatie Roles
        $this->call(AuthModuleSeeder::class);

        // 2. Seed Default Course Categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'icon_path' => 'icons/web-dev.svg'],
            ['name' => 'Mobile App Development', 'slug' => 'mobile-development', 'icon_path' => 'icons/mobile.svg'],
            ['name' => 'AI & Data Science', 'slug' => 'ai-data-science', 'icon_path' => 'icons/ai.svg'],
            ['name' => 'Cloud & DevOps', 'slug' => 'cloud-devops', 'icon_path' => 'icons/cloud.svg'],
            ['name' => 'Cyber Security', 'slug' => 'cyber-security', 'icon_path' => 'icons/security.svg'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Seed Essential System Settings
        $settings = [
            ['key' => 'platform_name', 'value' => 'SkillBridge Learning & Career Portal', 'description' => 'Global Application Title'],
            ['key' => 'platform_fee_percent', 'value' => '30', 'description' => 'Platform Revenue Percentage Share'],
            ['key' => 'certificate_pass_percentage', 'value' => '80', 'description' => 'Minimum Quiz Score for Certification'],
            ['key' => 'lesson_watch_unlock_percentage', 'value' => '90', 'description' => 'Minimum Watch Time Percentage to Unlock Next Lesson'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }

        // 4. Seed My Learning Module Sample Courses & Lessons
        $this->call(MyLearningSeeder::class);

        // 5. Seed Enterprise Master Real Data
        $this->call(MasterSeeder::class);

        // 6. Seed CMS Content (Success Stories, FAQs, Blog Posts, Pricing Plans)
        $this->call(CmsSeeder::class);
    }
}
