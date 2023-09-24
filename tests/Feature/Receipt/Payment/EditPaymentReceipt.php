<?php

namespace Tests\Feature\Receipt\Payment;

use App\Enums\ReceiptCategory;
use App\Enums\ReceiptType;
use App\Models\PaymentReceipt;
use App\Models\Project;
use Tests\TestCase;

class EditPaymentReceipt extends TestCase
{
    private function makeReceipt(): PaymentReceipt
    {
        return PaymentReceipt::create([
            'customer_name' => 'John Doe',
            'amount' => 10000000000,
            'payment_for' => 'Payment for something',
            'project_id' => Project::factory()->create()->id,
            'created_by' => $this->createUser('any role')->id,
            'category_id' => ReceiptCategory::CONSUMER->value,
        ]);
    }
    public function test_guest_cannot_edit_payment_receipt(): void
    {
        $this->get(route('receipt.edit', ['type' => ReceiptType::PAYMENT->value, 'receipt' => $this->makeReceipt()->id]))
            ->assertRedirect(route('login'));
    }

    public function test_user_cannot_edit_payment_receipt_if_user_does_not_have_permission(): void
    {
        $this->actingAs($user = $this->createUser('user'))
            ->get(route('receipt.edit', ['type' => ReceiptType::PAYMENT->value, 'receipt' => $this->makeReceipt()->id]))
            ->assertForbidden();
    }

    public function test_user_can_edit_payment_receipt_if_user_has_permission(): void
    {
        $receipt = $this->makeReceipt();

        $this->actingAs($user = $this->createUser('user', ['edit receipt']))
            ->get(route('receipt.edit', ['type' => ReceiptType::PAYMENT->value, 'receipt' =>$receipt->id]))
            ->assertSuccessful()
            ->assertViewIs('receipt.edit');

        $project = Project::factory()->create();

        $this->put(route('receipt.update.payment', $receipt), [
            'customer_name' => 'John Doe update',
            'amount' => "Rp 100,000,000,00" ,
            'payment_for' => 'Payment for something update',
            'project_id' => $project->id,
            'category' => ReceiptCategory::CONSUMER->value,
        ])->assertRedirect(route('dashboard'))
            ->assertSessionHas('success', 'Receipt updated successfully');

        $this->assertDatabaseHas('payment_receipts', [
            'customer_name' => 'John Doe update',
            'amount' => "10000000000" ,
            'payment_for' => 'Payment for something update',
            'project_id' => $project->id,
            'category_id' => ReceiptCategory::CONSUMER->value,
            'created_by' => $receipt->created_by,
        ]);
    }

    /**
     * @dataProvider paymentReceiptValidationData
     */
    public function test_update_payment_receipt_validation(string $field, string|int $value, string $error_message): void
    {
        $receipt = $this->makeReceipt();

        $this->actingAs($user = $this->createUser('user', ['edit receipt']))
            ->get(route('receipt.edit', ['type' => ReceiptType::PAYMENT->value, 'receipt' => $receipt->id]))
            ->assertSuccessful()
            ->assertViewIs('receipt.edit');

        $this->put(route('receipt.update.payment', $receipt), [
            $field => $value,
        ])->assertSessionHasErrors([$field => $error_message]);
    }

    public static function paymentReceiptValidationData(): array
    {
        return [
            'customer_name_is_required' => ['customer_name', '', 'The customer name field is required.'],
            'customer_name_is_string' => ['customer_name', 123, 'The customer name field must be a string.'],
            'customer_name_is_not_longer_than_255_chars' => ['customer_name', str_repeat('a', 256), 'The customer name field must not be greater than 255 characters.'],
            'amount_is_required' => ['amount', '', 'The amount field is required.'],
            'amount_is_not_numeric' => ['amount', 'abc', 'The amount field must be a number.'],
            'category_is_required' => ['category', '', 'The category field is required.'],
            'category_is_not_numeric' => ['category', 'abc', 'The category field must be a number.'],
            'category_is_not_in_enum' => ['category', 4, 'The selected category is invalid.'],
            'payment_for_is_required' => ['payment_for', '', 'The payment for field is required.'],
            'payment_for_is_not_string' => ['payment_for', 123, 'The payment for field must be a string.'],
            'payment_for_is_not_longer_than_255_chars' => ['payment_for', str_repeat('a', 256), 'The payment for field must not be greater than 255 characters.'],
            'project_id_is_required' => ['project_id', '', 'The project field is required.'],
            'project_id_is_not_numeric' => ['project_id', 'abc', 'The project field must be a number.'],
            'project_id_is_not_exists' => ['project_id', 123, 'The selected project is invalid.'],
        ];
    }
}
