<?php

namespace App\Livewire\Admin\Payments;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Payment Audit & Invoices - Admin Portal')]
class Manage extends Component
{
    public function render()
    {
        return view('livewire.admin.payments.manage');
    }
}
