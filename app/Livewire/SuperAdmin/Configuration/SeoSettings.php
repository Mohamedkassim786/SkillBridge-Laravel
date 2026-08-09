<?php

namespace App\Livewire\SuperAdmin\Configuration;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Database-Driven SEO Management - Super Admin')]
class SeoSettings extends Component
{
    public string $globalMetaTitle = 'SkillBridge - Enterprise Software Engineering LMS';
    public string $globalMetaDescription = 'Learn full-stack software architecture, domain-driven design, microservices, and modern PHP/Laravel through production projects.';
    public string $ogImageUrl = 'https://skillbridge.com/og-image.png';
    public string $canonicalUrl = 'https://skillbridge.com';
    public string $robotsTxt = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /super-admin/\nSitemap: https://skillbridge.com/sitemap.xml";

    public function mount()
    {
        $this->globalMetaTitle = SystemSetting::get('seo_meta_title', 'SkillBridge - Enterprise Software Engineering LMS');
        $this->globalMetaDescription = SystemSetting::get('seo_meta_desc', 'Learn full-stack software architecture through production projects.');
        $this->ogImageUrl = SystemSetting::get('seo_og_image', 'https://skillbridge.com/og-image.png');
        $this->canonicalUrl = SystemSetting::get('seo_canonical_url', 'https://skillbridge.com');
        $this->robotsTxt = SystemSetting::get('seo_robots_txt', "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /super-admin/\nSitemap: https://skillbridge.com/sitemap.xml");
    }

    public function saveSeo()
    {
        SystemSetting::set('seo_meta_title', $this->globalMetaTitle);
        SystemSetting::set('seo_meta_desc', $this->globalMetaDescription);
        SystemSetting::set('seo_og_image', $this->ogImageUrl);
        SystemSetting::set('seo_canonical_url', $this->canonicalUrl);
        SystemSetting::set('seo_robots_txt', $this->robotsTxt);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'seo_settings_updated',
            'auditable_type' => SystemSetting::class,
            'auditable_id' => 1,
            'new_values' => ['title' => $this->globalMetaTitle],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'Database-driven SEO meta values and Robots.txt saved.');
    }

    public function render()
    {
        return view('livewire.super-admin.configuration.seo-settings');
    }
}
