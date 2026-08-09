<?php

namespace App\Livewire\SuperAdmin\Finance;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Payment Gateways & Revenue Share Settings - Super Admin')]
class GatewaySettings extends Component
{
    public string $razorpayKey = '';
    public string $razorpaySecret = '';
    public string $stripeKey = '';
    public string $stripeSecret = '';
    public float $platformFeePercent = 10.0;
    public float $trainerRevenueSharePercent = 90.0;

    public function mount()
    {
        $this->razorpayKey = SystemSetting::get('razorpay_key', 'rzp_test_samplekey123');
        $this->razorpaySecret = SystemSetting::get('razorpay_secret', '');
        $this->stripeKey = SystemSetting::get('stripe_key', 'pk_test_samplekey123');
        $this->stripeSecret = SystemSetting::get('stripe_secret', '');
        $this->platformFeePercent = (float) SystemSetting::get('platform_fee_percent', 10.0);
        $this->trainerRevenueSharePercent = (float) SystemSetting::get('trainer_revenue_share_percent', 90.0);
    }

    public function saveSettings()
    {
        SystemSetting::set('razorpay_key', $this->razorpayKey);
        if ($this->razorpaySecret) SystemSetting::set('razorpay_secret', $this->razorpaySecret);

        SystemSetting::set('stripe_key', $this->stripeKey);
        if ($this->stripeSecret) SystemSetting::set('stripe_secret', $this->stripeSecret);

        SystemSetting::set('platform_fee_percent', $this->platformFeePercent);
        SystemSetting::set('trainer_revenue_share_percent', $this->trainerRevenueSharePercent);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'gateway_settings_updated',
            'auditable_type' => SystemSetting::class,
            'auditable_id' => 1,
            'new_values' => [
                'platform_fee_percent' => $this->platformFeePercent,
                'trainer_share' => $this->trainerRevenueSharePercent
            ],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', 'Payment gateway credentials and revenue share percentages updated.');
    }

    public function render()
    {
        return view('livewire.super-admin.finance.gateway-settings');
    }
}
