<?php

namespace App\Livewire\SuperAdmin\Security;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Security Policies & Active Sessions - Super Admin')]
class SecuritySettings extends Component
{
    public bool $enforce2FA = false;
    public int $sessionTimeoutMins = 120;
    public int $maxLoginAttempts = 5;
    public string $ipBlocklist = '';

    public function mount()
    {
        $this->enforce2FA = (bool) SystemSetting::get('security_enforce_2fa', false);
        $this->sessionTimeoutMins = (int) SystemSetting::get('security_session_timeout', 120);
        $this->maxLoginAttempts = (int) SystemSetting::get('security_max_login_attempts', 5);
        $this->ipBlocklist = SystemSetting::get('security_ip_blocklist', '');
    }

    public function saveSecurity()
    {
        SystemSetting::set('security_enforce_2fa', $this->enforce2FA);
        SystemSetting::set('security_session_timeout', $this->sessionTimeoutMins);
        SystemSetting::set('security_max_login_attempts', $this->maxLoginAttempts);
        SystemSetting::set('security_ip_blocklist', $this->ipBlocklist);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'security_settings_updated',
            'auditable_type' => SystemSetting::class,
            'auditable_id' => 1,
            'new_values' => ['enforce_2fa' => $this->enforce2FA, 'timeout' => $this->sessionTimeoutMins],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'Security policies and active session rules saved.');
    }

    public function render()
    {
        return view('livewire.super-admin.security.security-settings');
    }
}
