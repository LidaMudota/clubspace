<?php

namespace App\Http\Requests\Refund;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRefundRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_id' => [
                'required',
                'integer',
                Rule::exists('payments', 'id')->where('user_id', $this->user()?->id)->where('status', 'paid'),
                Rule::unique('refund_requests', 'payment_id'),
            ],
            'reason' => ['required', 'string', 'max:2000'],
        ];
    }
}
