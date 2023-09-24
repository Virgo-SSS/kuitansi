<?php

namespace App\Http\Requests\Receipt;

use App\Enums\ReceiptCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class EditPaymentReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->can('edit receipt');
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
            'payment_for' => 'required|string|max:255',
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
