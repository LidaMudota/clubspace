<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider');
            $table->string('provider_user_id');
            $table->string('provider_email')->nullable();
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->unique(['provider', 'provider_user_id']);
        });

        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('purpose')->index();
            $table->string('target')->index();
            $table->string('code_hash');
            $table->timestamp('expires_at')->index();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });

        Schema::create('refund_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('requested')->index();
            $table->text('reason');
            $table->text('admin_comment')->nullable();
            $table->json('status_history')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('channel')->index();
            $table->string('type');
            $table->string('recipient');
            $table->json('payload')->nullable();
            $table->string('status')->index();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->json('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('notification_logs');
        Schema::dropIfExists('refund_requests');
        Schema::dropIfExists('otp_codes');
        Schema::dropIfExists('social_accounts');
    }
};
