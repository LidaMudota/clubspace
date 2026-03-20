<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\RefundRequest;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function profile(): Response
    {
        return Inertia::render('Account/Profile');
    }

    public function events(): Response
    {
        $user = auth()->user();

        return Inertia::render('Account/Events', [
            'bookings' => $user->bookings()->with('event')->latest()->paginate(10),
        ]);
    }

    public function payments(): Response
    {
        $user = auth()->user();

        return Inertia::render('Account/Payments', [
            'payments' => $user->payments()->with('booking.event')->latest()->paginate(10),
        ]);
    }

    public function refunds(): Response
    {
        $user = auth()->user();

        return Inertia::render('Account/Refunds', [
            'refunds' => RefundRequest::query()->where('user_id', $user->id)->with('payment.booking.event')->latest()->paginate(10),
            'eligiblePayments' => Payment::query()->where('user_id', $user->id)->where('status', 'paid')->with('booking.event')->latest()->get(),
        ]);
    }
}
