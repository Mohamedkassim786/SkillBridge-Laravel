<?php

namespace App\Livewire\Student\Payments;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('My Orders & Payments - SkillBridge')]
class Index extends Component
{
    public function render()
    {
        $orders = Order::with(['items.courseVersion.course', 'payment', 'invoice'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.student.payments.index', compact('orders'));
    }
}
