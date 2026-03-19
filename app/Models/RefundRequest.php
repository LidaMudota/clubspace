<?php

namespace App\Models;

use App\Enums\RefundStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundRequest extends Model
{
    protected $fillable = ['user_id','payment_id','status','reason','processed_at','admin_comment','status_history'];
    protected function casts(): array { return ['status' => RefundStatus::class, 'processed_at' => 'datetime', 'status_history' => 'array']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function payment(): BelongsTo { return $this->belongsTo(Payment::class); }
}
