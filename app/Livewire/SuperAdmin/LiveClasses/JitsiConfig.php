<?php

namespace App\Livewire\SuperAdmin\LiveClasses;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Server-Side Jitsi WebRTC Settings - Super Admin')]
class JitsiConfig extends Component
{
    public string $domain = 'meet.jit.si';
    public bool $useJwt = false;
    public string $appId = '';
    public string $appSecret = '';
    public string $roomNamingPattern = 'live_class_{ulid}';
    public int $tokenExpirationMins = 120;

    public function mount()
    {
        $this->domain = SystemSetting::get('jitsi_domain', 'meet.jit.si');
        $this->useJwt = (bool) SystemSetting::get('jitsi_use_jwt', false);
        $this->appId = SystemSetting::get('jitsi_app_id', '');
        $this->appSecret = SystemSetting::get('jitsi_app_secret', '');
        $this->roomNamingPattern = SystemSetting::get('jitsi_room_naming_pattern', 'live_class_{ulid}');
        $this->tokenExpirationMins = (int) SystemSetting::get('jitsi_token_expiration', 120);
    }

    public function saveSettings()
    {
        SystemSetting::set('jitsi_domain', $this->domain);
        SystemSetting::set('jitsi_use_jwt', $this->useJwt);
        SystemSetting::set('jitsi_app_id', $this->appId);
        SystemSetting::set('jitsi_app_secret', $this->appSecret);
        SystemSetting::set('jitsi_room_naming_pattern', $this->roomNamingPattern);
        SystemSetting::set('jitsi_token_expiration', $this->tokenExpirationMins);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'jitsi_config_updated_by_super_admin',
            'auditable_type' => SystemSetting::class,
            'auditable_id' => 1,
            'new_values' => ['domain' => $this->domain, 'use_jwt' => $this->useJwt],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'Jitsi WebRTC server-side configuration saved securely.');
    }

    public function render()
    {
        return view('livewire.super-admin.live-classes.jitsi-config');
    }
}
