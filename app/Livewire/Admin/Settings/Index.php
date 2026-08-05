<?php

namespace App\Livewire\Admin\Settings;

use App\Models\CmsSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('System Settings - Admin Portal')]
class Index extends Component
{
    public string $siteName = 'SkillBridge';
    public string $siteEmail = 'support@skillbridge.io';
    public string $sitePhone = '+91 98765 43210';

    public function mount()
    {
        $this->siteName = CmsSetting::get('site_name', 'SkillBridge');
        $this->siteEmail = CmsSetting::get('site_email', 'support@skillbridge.io');
        $this->sitePhone = CmsSetting::get('site_phone', '+91 98765 43210');
    }

    public function save()
    {
        CmsSetting::set('site_name', $this->siteName);
        CmsSetting::set('site_email', $this->siteEmail);
        CmsSetting::set('site_phone', $this->sitePhone);

        session()->flash('status', 'System settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings.index');
    }
}
