<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Razorpay subscription payments.
 *
 * payment_status (string, not ENUM):
 *   pending | success | failed | refunded
 *
 * pack_duration_days: 30 (Rs 799) | 90 (Rs 1,999) | 365 (Rs 5,999)
 *
 * property_id is nullable because a host may pay before the listing
 * row exists; it is nullOnDelete so removing a property does not
 * destroy the payment record.
 *
 * paid_at is nullable: a 'pending' or 'failed' transaction has no
 * settlement time yet. Making it NOT NULL would make those rows
 * impossible to insert.
 *
 * refund_reason is filled by the admin when a listing is rejected and
 * enters the manual Razorpay refund queue.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('property_id')->nullable()->constrained('properties')->nullOnDelete();
            $table->string('gateway_payment_id', 100)->unique();
            $table->integer('pack_duration_days');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_status', 20);
            $table->string('refund_reason', 255)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->index('host_id');
            $table->index('property_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
