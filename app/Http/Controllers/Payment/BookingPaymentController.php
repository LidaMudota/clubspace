<?php

namespace App\Http\Controllers\Payment;

use App\Actions\Booking\CreateDraftBookingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Models\Event;
use App\Services\TBank\TBankPaymentService;
use Illuminate\Http\RedirectResponse;

class BookingPaymentController extends Controller
{
    public function store(StoreBookingRequest $request, CreateDraftBookingAction $action, TBankPaymentService $service): RedirectResponse
    {
        $event = Event::query()->findOrFail($request->validated('event_id'));
        $booking = $action->execute($request->user(), $event);
        $service->initPayment($booking);

        return to_route('account.events')->with('status', 'Бронирование создано, ожидается оплата.');
    }
}
