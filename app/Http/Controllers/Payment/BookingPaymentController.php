<?php

namespace App\Http\Controllers\Payment;

use App\Actions\Booking\CreateDraftBookingAction;
use App\Enums\BookingStatus;
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

        if ($booking->status === BookingStatus::Confirmed) {
            return to_route('account.events')->with('status', 'Вы уже участвуете в этом мероприятии.');
        }

        $payment = $service->initPayment($booking);
        $paymentUrl = data_get($payment->raw_notification, 'PaymentURL');

        if (is_string($paymentUrl) && $paymentUrl !== '') {
            return redirect()->away($paymentUrl);
        }

        return to_route('account.payments')->with('status', 'Платеж инициализирован. Завершите оплату в банке.');
    }
}
