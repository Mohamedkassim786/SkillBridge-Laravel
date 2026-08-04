<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentWebhook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    /**
     * Handle Stripe HMAC signature verified webhooks.
     */
    public function handleStripe(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $payloadHash = md5($payload);

        if (PaymentWebhook::where('payload_hash', $payloadHash)->exists()) {
            return response()->json(['message' => 'Duplicate webhook payload ignored'], 200);
        }

        PaymentWebhook::create([
            'gateway' => 'stripe',
            'event_type' => $request->input('type', 'stripe.event'),
            'payload_hash' => $payloadHash,
            'payload' => $request->all(),
        ]);

        return response()->json(['success' => true], 200);
    }

    /**
     * Handle Razorpay HMAC signature verified webhooks.
     */
    public function handleRazorpay(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $payloadHash = md5($payload);

        if (PaymentWebhook::where('payload_hash', $payloadHash)->exists()) {
            return response()->json(['message' => 'Duplicate webhook payload ignored'], 200);
        }

        PaymentWebhook::create([
            'gateway' => 'razorpay',
            'event_type' => $request->input('event', 'razorpay.event'),
            'payload_hash' => $payloadHash,
            'payload' => $request->all(),
        ]);

        return response()->json(['success' => true], 200);
    }
}
