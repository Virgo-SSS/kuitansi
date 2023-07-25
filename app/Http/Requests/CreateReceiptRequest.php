<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'received_from' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'in_payment_for' => 'required|string|max:255',
            'payment_method' => 'required|string|uppercase|in:CASH,TRANSFER,GIRO',
            'giro_bank' => ['nullable', 'string', 'max:255', 'required_if:payment_method,GIRO']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => Str::replace([',', '.'], '', $this->amount),
        ]);
    }
}
