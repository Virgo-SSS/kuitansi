<?php

namespace App\Http\Requests\Receipt;

use App\Enums\AcceptancePaymentForCategory;
use App\Enums\BankPaymentMethod;
use App\Enums\PaymentMethod;
use App\Enums\ReceiptCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CreateAcceptanceReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->can('create receipt');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category' => ['required', 'numeric', new Enum(ReceiptCategory::class)],
            'payment_for_consumer' => ['nullable', Rule::requiredIf(fn() => $this->category == ReceiptCategory::CONSUMER->value), 'string', new Enum(AcceptancePaymentForCategory::class)],
            'payment_for_consumer_description' => ['nullable', Rule::requiredIf(fn() => $this->payment_for_consumer && $this->payment_for_consumer != AcceptancePaymentForCategory::BOOKING_FEE->value), 'string', 'max:255'],
            'payment_for_non_consumer' => ['nullable', Rule::requiredIf(fn() => $this->category == ReceiptCategory::NON_CONSUMER->value), 'string', 'max:255'],
            'payment_method' => ['required', 'numeric', new Enum(PaymentMethod::class)],
            'bank_id' => ['nullable', Rule::requiredIf(fn () => $this->payment_method == PaymentMethod::BANK->value),'numeric', 'exists:banks,id'],
            'bank_method' => ['nullable',Rule::requiredIf(fn () => $this->payment_method == PaymentMethod::BANK->value),  'numeric',  new Enum(BankPaymentMethod::class)],
            'cek_or_giro_number' => ['nullable', Rule::requiredIf(fn () => $this->bank_method && $this->bank_method != BankPaymentMethod::TRANSFER->value), 'numeric'],
            'project_id' => 'required|numeric|exists:projects,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $amount = explode(' ', $this->amount);
        if(count($amount) > 1) {
            $this->merge([
                'amount' => Str::replace([',', '.'], '', $amount[1]),
            ]);
        }
    }

    public function attributes(): array
    {
        return [
            'project_id' => 'project',
        ];
    }
}
