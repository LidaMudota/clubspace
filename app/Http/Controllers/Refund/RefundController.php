<?php

namespace App\Http\Controllers\Refund;

use App\Actions\Refund\CreateRefundRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Refund\StoreRefundRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

class RefundController extends Controller
{
    public function store(StoreRefundRequest $request, CreateRefundRequestAction $action): RedirectResponse
    {
        $payment = Payment::query()->where('user_id', $request->user()->id)->findOrFail($request->validated('payment_id'));
        $action->execute($payment, $request->validated('reason'));

        return back()->with('status', 'Запрос на возврат создан.');
    }
}
