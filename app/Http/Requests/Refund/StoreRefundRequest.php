<?php

namespace App\Http\Requests\Refund;

use Illuminate\Foundation\Http\FormRequest;

class StoreRefundRequest extends FormRequest
{
    public function rules(): array
    {
        return ['payment_id' => ['required', 'integer', 'exists:payments,id'], 'reason' => ['required', 'string', 'max:2000']];
    }
}
