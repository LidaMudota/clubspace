<?php

namespace App\Services\Auth;

use App\Enums\OtpPurpose;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    public function create(string $target, OtpPurpose $purpose = OtpPurpose::Login): OtpCode
    {
        $code = (string) random_int(100000, 999999);
        $user = User::query()->firstOrCreate(
            filter_var($target, FILTER_VALIDATE_EMAIL) ? ['email' => $target] : ['phone' => $target],
            ['name' => 'Clubspace User', 'password' => str()->random(32)]
        );

        return OtpCode::query()->create([
            'user_id' => $user->id,
            'purpose' => $purpose->value,
            'target' => $target,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(config('clubspace.auth.otp_ttl_minutes', 10)),
        ]);
    }

    public function verify(string $target, string $code, OtpPurpose $purpose = OtpPurpose::Login): ?User
    {
        $otp = OtpCode::query()
            ->where('target', $target)
            ->where('purpose', $purpose->value)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (! $otp || ! Hash::check($code, $otp->code_hash)) {
            return null;
        }

        $otp->update(['used_at' => now()]);

        return $otp->user;
    }
}
