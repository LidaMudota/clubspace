<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('provider')->default('tbank');
            $table->string('provider_payment_id')->nullable()->unique();
            $table->uuid('idempotency_key')->unique();
            $table->string('status')->default('new')->index();
            $table->unsignedInteger('amount');
            $table->string('currency', 3)->default('RUB');
            $table->json('raw_notification')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
