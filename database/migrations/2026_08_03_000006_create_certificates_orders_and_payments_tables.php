<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('uuid', 36)->unique();
            $table->string('certificate_hash', 64)->unique()->comment('SHA-256 tamper-proof credential hash');
            $table->foreignUlid('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignUlid('course_version_id')->constrained('course_versions')->onDelete('restrict');
            $table->string('pdf_s3_key');
            $table->timestamp('issued_at');
            $table->timestamps();

            $table->index('uuid');
            $table->index('certificate_hash');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('order_number', 32)->unique();
            $table->foreignUlid('user_id')->constrained('users')->onDelete('restrict');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->enum('status', ['pending', 'paid', 'cancelled', 'refunded'])->default('pending');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignUlid('course_version_id')->constrained('course_versions')->onDelete('restrict');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->unique()->constrained('orders')->onDelete('restrict');
            $table->string('invoice_number', 32)->unique();
            $table->decimal('net_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('gross_amount', 10, 2);
            $table->string('pdf_url')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained('orders')->onDelete('restrict');
            $table->string('transaction_id')->unique();
            $table->enum('gateway', ['razorpay', 'stripe']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->timestamps();
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('payment_id')->constrained('payments')->onDelete('restrict');
            $table->string('refund_transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_webhooks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('gateway', ['razorpay', 'stripe']);
            $table->string('event_type');
            $table->string('payload_hash')->unique();
            $table->json('payload');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_webhooks');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('certificates');
    }
};
