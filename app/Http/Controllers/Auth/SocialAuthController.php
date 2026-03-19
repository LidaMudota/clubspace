<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $socialUser = Socialite::driver($provider)->user();

        $account = SocialAccount::query()->firstOrCreate([
            'provider' => $provider,
            'provider_user_id' => $socialUser->getId(),
        ], [
            'provider_email' => $socialUser->getEmail(),
            'access_token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken,
            'expires_at' => now()->addSeconds($socialUser->expiresIn ?? 3600),
            'user_id' => User::query()->firstOrCreate(['email' => $socialUser->getEmail()], ['name' => $socialUser->getName() ?? 'Clubspace User', 'password' => str()->random(32)])->id,
        ]);

        Auth::login($account->user, true);

        return to_route('account.profile');
    }
}
