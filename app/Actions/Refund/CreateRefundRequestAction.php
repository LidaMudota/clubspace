<?php

namespace App\Actions\Refund;

use App\Enums\RefundStatus;
use App\Models\Payment;
use App\Models\RefundRequest;

class CreateRefundRequestAction
{
    public function execute(Payment $payment, string $reason): RefundRequest
    {
        return RefundRequest::query()->create([
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'status' => RefundStatus::Requested,
            'reason' => $reason,
            'status_history' => [['status' => RefundStatus::Requested->value, 'at' => now()->toDateTimeString()]],
        ]);
    }
}
