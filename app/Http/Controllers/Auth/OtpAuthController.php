<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Services\Auth\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class OtpAuthController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/OtpLogin');
    }

    public function send(SendOtpRequest $request, OtpService $otpService): RedirectResponse
    {
        $otpService->create($request->validated('target'));
        return back()->with('status', 'Код отправлен.');
    }

    public function verify(VerifyOtpRequest $request, OtpService $otpService): RedirectResponse
    {
        $user = $otpService->verify($request->validated('target'), $request->validated('code'));
        abort_if(! $user, 422, 'Неверный код');
        Auth::login($user, true);
        return to_route('account.profile');
    }
}
