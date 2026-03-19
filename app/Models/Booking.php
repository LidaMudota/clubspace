<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','event_id','status','amount','confirmed_at'];
    protected function casts(): array { return ['status' => BookingStatus::class, 'confirmed_at' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function payment(): HasOne { return $this->hasOne(Payment::class); }
}
