<?php

namespace App\Livewire\SuperAdmin\Configuration;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('API Integrations & Communications - Super Admin')]
class Integrations extends Component
{
    public string $smtpHost = '127.0.0.1';
    public int $smtpPort = 2525;
    public string $smtpUsername = '';
    public string $smtpPassword = '';
    public string $mailFromAddress = 'hello@skillbridge.com';

    public string $testEmailRecipient = '';
    public string $testMessageStatus = '';

    public function mount()
    {
        $this->smtpHost = SystemSetting::get('smtp_host', '127.0.0.1');
        $this->smtpPort = (int) SystemSetting::get('smtp_port', 2525);
        $this->smtpUsername = SystemSetting::get('smtp_username', '');
        $this->mailFromAddress = SystemSetting::get('mail_from_address', 'hello@skillbridge.com');
    }

    public function saveMailConfig()
    {
        SystemSetting::set('smtp_host', $this->smtpHost);
        SystemSetting::set('smtp_port', $this->smtpPort);
        SystemSetting::set('smtp_username', $this->smtpUsername);
        if ($this->smtpPassword) SystemSetting::set('smtp_password', $this->smtpPassword);
        SystemSetting::set('mail_from_address', $this->mailFromAddress);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'mail_integration_config_updated',
            'auditable_type' => SystemSetting::class,
            'auditable_id' => 1,
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'SMTP Mail configuration saved.');
    }

    public function sendTestMessage()
    {
        $this->validate([
            'testEmailRecipient' => 'required|email',
        ]);

        try {
            Mail::raw('SkillBridge Super Admin Integration Test Message - Delivery Confirmed!', function ($message) {
                $message->to($this->testEmailRecipient)
                        ->subject('SkillBridge SMTP Delivery Integration Test');
            });

            $this->testMessageStatus = 'SUCCESS: Test email message dispatched to ' . $this->testEmailRecipient;
        } catch (\Throwable $e) {
            $this->testMessageStatus = 'ERROR: Failed to deliver test message. ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.super-admin.configuration.integrations');
    }
}
