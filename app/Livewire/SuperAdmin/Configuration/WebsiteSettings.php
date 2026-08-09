<?php

namespace App\Livewire\SuperAdmin\Configuration;

use App\Models\AuditLog;
use App\Models\CmsSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Dynamic Website CMS Settings - Super Admin')]
class WebsiteSettings extends Component
{
    public string $appName = 'SkillBridge';
    public string $heroHeadline = '';
    public string $heroSubheading = '';
    public string $contactEmail = '';
    public string $supportPhone = '';
    public bool $maintenanceMode = false;

    public function mount()
    {
        $this->appName = CmsSetting::get('site_name', 'SkillBridge');
        $this->heroHeadline = CmsSetting::get('hero_headline', 'Master Enterprise Software Engineering with Real Code');
        $this->heroSubheading = CmsSetting::get('hero_subheading', 'Learn full-stack software architecture, domain-driven design, microservices, and modern PHP/Laravel through production projects built by senior engineers.');
        $this->contactEmail = CmsSetting::get('contact_email', 'support@skillbridge.com');
        $this->supportPhone = CmsSetting::get('support_phone', '+91 98765 43210');
        $this->maintenanceMode = (bool) CmsSetting::get('maintenance_mode', false);
    }

    public function saveSettings()
    {
        CmsSetting::set('site_name', $this->appName);
        CmsSetting::set('hero_headline', $this->heroHeadline);
        CmsSetting::set('hero_subheading', $this->heroSubheading);
        CmsSetting::set('contact_email', $this->contactEmail);
        CmsSetting::set('support_phone', $this->supportPhone);
        CmsSetting::set('maintenance_mode', $this->maintenanceMode);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'website_cms_settings_updated',
            'auditable_type' => CmsSetting::class,
            'auditable_id' => 1,
            'new_values' => ['site_name' => $this->appName, 'maintenance' => $this->maintenanceMode],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'Website CMS content settings saved dynamically to DB.');
    }

    public function render()
    {
        return view('livewire.super-admin.configuration.website-settings');
    }
}
