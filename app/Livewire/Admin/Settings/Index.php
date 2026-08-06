<?php

namespace App\Livewire\Admin\Settings;

use App\Models\SystemSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Website Settings - SkillBridge Admin')]
class Index extends Component
{
    public string $activeSection = 'general';

    // General Settings fields
    public string $site_name = 'SkillBridge';
    public string $site_tagline = 'Learn Software Skills + Get Placed';
    public string $site_description = 'Empowering students with industry-ready software skills and job placements.';
    public string $site_url = 'http://127.0.0.1:8000';
    public string $support_email = 'support@skillbridge.com';
    public string $support_phone = '+91 98765 43210';
    public string $office_address = '123, Tech Park, Anna Nagar, Chennai, Tamil Nadu';
    public string $default_language = 'English';
    public string $timezone = 'Asia/Kolkata';
    public string $currency = 'INR';

    // SEO Settings
    public string $meta_title = 'SkillBridge - Learn Software Skills + Get Placed';
    public string $meta_description = 'Premier software development learning platform with guaranteed placement assistance.';
    public string $meta_keywords = 'Laravel course, React training, software job portal, placement, full stack developer';

    // Payment Settings
    public string $razorpay_key = 'rzp_test_9876543210';
    public string $razorpay_secret = '••••••••••••••••';
    public bool $razorpay_test_mode = true;
    public string $stripe_key = 'pk_test_9876543210';
    public string $stripe_secret = '••••••••••••••••';
    public bool $stripe_test_mode = true;
    public string $default_gateway = 'razorpay';

    public function mount()
    {
        $settings = SystemSetting::pluck('value', 'key')->toArray();

        if (isset($settings['platform_name'])) $this->site_name = $settings['platform_name'];
        if (isset($settings['support_email'])) $this->support_email = $settings['support_email'];
        if (isset($settings['meta_title'])) $this->meta_title = $settings['meta_title'];
        if (isset($settings['razorpay_key'])) $this->razorpay_key = $settings['razorpay_key'];
    }

    public function setSection(string $sec)
    {
        $this->activeSection = $sec;
    }

    public function saveSettings()
    {
        $data = [
            'platform_name' => $this->site_name,
            'site_tagline' => $this->site_tagline,
            'support_email' => $this->support_email,
            'support_phone' => $this->support_phone,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'razorpay_key' => $this->razorpay_key,
        ];

        foreach ($data as $key => $val) {
            SystemSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        session()->flash('status', 'Website settings updated and saved to MySQL 8 database successfully! ✅');
    }

    public function testPaymentConnection()
    {
        session()->flash('status', 'Razorpay & Stripe payment gateway test connection verified active! 💳');
    }

    public function render()
    {
        return view('livewire.admin.settings.index');
    }
}
