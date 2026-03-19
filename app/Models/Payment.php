<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['user_id','booking_id','provider','provider_payment_id','idempotency_key','status','amount','currency','raw_notification','paid_at'];
    protected function casts(): array { return ['status' => PaymentStatus::class, 'raw_notification' => 'array', 'paid_at' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
}
