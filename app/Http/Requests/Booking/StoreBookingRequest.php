<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return ['event_id' => ['required', 'integer', 'exists:events,id']];
    }
}
