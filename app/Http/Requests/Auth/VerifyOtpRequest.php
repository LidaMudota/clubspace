<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'target' => ['required', 'string', 'max:255'],
            'code' => ['required', 'digits:6'],
        ];
    }
}
