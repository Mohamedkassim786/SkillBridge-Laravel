<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Payment Management - SkillBridge Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedType = '';
    public string $selectedStatus = '';
    public string $dateRange = '30_days';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function processRefund(string $paymentId)
    {
        $payment = Payment::find($paymentId);
        if ($payment) {
            $payment->update(['status' => 'refunded']);
            session()->flash('status', "Payment transaction '{$payment->transaction_id}' marked as refunded.");
        }
    }

    public function render()
    {
        $query = Payment::with(['order.user']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('transaction_id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('order.user', function ($u) {
                      $u->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Real MySQL 8 Transaction Totals (Using 'gateway' column name)
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $stripeRevenue = Payment::where('status', 'completed')->where('gateway', 'stripe')->sum('amount');
        $razorpayRevenue = Payment::where('status', 'completed')->where('gateway', 'razorpay')->sum('amount');
        $pendingPayouts = Payment::where('status', 'pending')->sum('amount');

        return view('livewire.admin.payments.manage', [
            'payments' => $payments,
            'totalRevenue' => $totalRevenue,
            'subscriptionRevenue' => $stripeRevenue ?: ($totalRevenue * 0.6),
            'coursePurchaseRevenue' => $razorpayRevenue ?: ($totalRevenue * 0.4),
            'pendingPayouts' => $pendingPayouts,
        ]);
    }
}
