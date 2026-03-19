<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'phone', 'password', 'telegram_chat_id'];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function socialAccounts(): HasMany { return $this->hasMany(SocialAccount::class); }
    public function bookings(): HasMany { return $this->hasMany(Booking::class); }
    public function payments(): HasMany { return $this->hasMany(Payment::class); }
    public function refundRequests(): HasMany { return $this->hasMany(RefundRequest::class); }
    public function otpCodes(): HasMany { return $this->hasMany(OtpCode::class); }
}
