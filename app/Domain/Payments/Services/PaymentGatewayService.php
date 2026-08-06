<?php

namespace App\Domain\Payments\Services;

use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    /**
     * Process order creation, invoice generation, payment transaction logging, and course enrollment.
     */
    public function processSuccessfulPayment(User $user, string $courseId, float $price, string $gateway = 'razorpay', ?string $transactionId = null): Order
    {
        // 1. Create Order
        $order = Order::create([
            'order_number' => 'ORD-' . date('Y') . '-' . rand(10000, 99999),
            'user_id' => $user->id,
            'subtotal' => $price,
            'discount_amount' => 0.00,
            'tax_amount' => 0.00,
            'total_amount' => $price,
            'currency' => 'INR',
            'status' => 'paid',
        ]);

        // 2. Create Order Item
        $course = \App\Models\Course::find($courseId);
        OrderItem::create([
            'order_id' => $order->id,
            'course_version_id' => $course?->current_version_id,
            'unit_price' => $price,
        ]);

        // 3. Create Invoice
        Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => 'INV-' . date('Y') . '-' . rand(10000, 99999),
            'net_amount' => $price,
            'tax_amount' => 0.00,
            'gross_amount' => $price,
            'pdf_url' => 'invoices/' . $order->order_number . '.pdf',
        ]);

        // 4. Create Payment Record
        $txnId = $transactionId ?: ('pay_' . Str::random(12));
        Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $txnId,
            'gateway' => $gateway,
            'amount' => $price,
            'currency' => 'INR',
            'status' => 'completed',
            'gateway_response' => [
                'status' => 'captured',
                'method' => 'upi',
                'transaction_id' => $txnId,
            ],
        ]);

        // 5. Grant Course Enrollment
        if ($course) {
            Enrollment::firstOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                [
                    'course_version_id' => $course->current_version_id,
                    'progress_percent' => 0,
                    'status' => 'active',
                ]
            );
        }

        return $order;
    }
}
