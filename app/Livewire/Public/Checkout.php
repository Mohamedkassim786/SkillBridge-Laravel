<?php

namespace App\Livewire\Public;

use App\Domain\Payments\Services\PaymentGatewayService;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Secure Checkout - SkillBridge')]
class Checkout extends Component
{
    public ?string $courseId = null;
    public ?Course $course = null;

    // Payment Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $paymentMethod = 'razorpay';
    public string $razorpayKey = 'rzp_test_9876543210';

    public function mount(?string $courseId = null)
    {
        $this->courseId = $courseId;

        if ($this->courseId) {
            $this->course = Course::with(['currentVersion', 'trainer'])->find($this->courseId);
        }

        $user = auth()->user();
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone ?? '+91 98765 43210';
        }
    }

    public function handleRazorpaySuccess(string $razorpayPaymentId, string $method = 'upi')
    {
        $user = auth()->user();
        if (! $user) {
            session()->flash('error', 'Please sign in to complete your course purchase.');
            return redirect()->route('login');
        }

        if (! $this->course || ! $this->course->currentVersion) {
            session()->flash('error', 'Invalid course selection.');
            return redirect()->route('courses.index');
        }

        $price = (float) $this->course->currentVersion->price;

        $paymentService = app(PaymentGatewayService::class);
        $paymentService->processSuccessfulPayment($user, $this->course->id, $price, 'razorpay', $razorpayPaymentId);

        session()->flash('status', "Payment successful via Razorpay! You are now enrolled in '{$this->course->title}'. Welcome!");

        return redirect()->route('student.courses.player', ['courseId' => $this->course->id]);
    }

    public function processPayment()
    {
        return $this->handleRazorpaySuccess('pay_rzp_test_' . rand(1000, 9999));
    }

    public function render()
    {
        return view('livewire.public.checkout');
    }
}
