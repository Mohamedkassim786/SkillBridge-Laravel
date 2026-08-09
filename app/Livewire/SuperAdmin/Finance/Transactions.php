<?php

namespace App\Livewire\SuperAdmin\Finance;

use App\Models\AuditLog;
use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Finance Transactions & Refunds - Super Admin')]
class Transactions extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    public function updatedStatusFilter() { $this->resetPage(); }

    public function processRefund(string $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => 'refunded']);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'payment_refunded_by_super_admin',
            'auditable_type' => Payment::class,
            'auditable_id' => $paymentId,
            'new_values' => ['status' => 'refunded', 'amount' => $payment->amount],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Payment #{$payment->id} refunded successfully.");
    }

    public function render()
    {
        $query = Payment::with(['user', 'order.user']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $refundedTotal = Payment::where('status', 'refunded')->sum('amount');

        return view('livewire.super-admin.finance.transactions', [
            'payments' => $payments,
            'totalRevenue' => $totalRevenue,
            'refundedTotal' => $refundedTotal,
        ]);
    }
}
