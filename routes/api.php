<?php

use App\Http\Controllers\Api\PaymentWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Production Payment Webhooks (No Auth, Verified by Cryptographic Signatures)
Route::post('/payments/webhook/stripe', [PaymentWebhookController::class, 'handleStripe']);
Route::post('/payments/webhook/razorpay', [PaymentWebhookController::class, 'handleRazorpay']);
