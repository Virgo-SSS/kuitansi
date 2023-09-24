<?php

namespace Tests\Feature\Receipt\Acceptance;

use App\Enums\AcceptancePaymentForCategory;
use App\Enums\BankPaymentMethod;
use App\Enums\PaymentMethod;
use App\Enums\ReceiptCategory;
use App\Enums\ReceiptType;
use App\Models\AcceptanceReceipt;
use App\Models\AcceptanceReceiptPayment;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class EditAcceptanceReceiptTest extends TestCase
{
    private function makeReceipt(int $category): AcceptanceReceipt
    {
        $receipt = AcceptanceReceipt::create([
            'customer_name' => 'test',
            'amount' => 10000000,
            'project_id' => Project::factory()->create()->id,
            'created_by' => User::factory()->create()->id,
            'category_id' => $category,
        ]);

        if($receipt->category_id == ReceiptCategory::CONSUMER->value) {
            $this->consumer($receipt);
        }

        if($receipt->category_id == ReceiptCategory::NON_CONSUMER->value) {
            $this->nonConsumer($receipt);
        }

        return $receipt;
    }

    private function consumer(AcceptanceReceipt $receipt): void
    {
        $data = [
            'acceptance_receipt_id' => $receipt->id,
            'payment_for' => AcceptancePaymentForCategory::ANGSURAN->value,
            'payment_for_description' => 'test',
            'payment_method' => PaymentMethod::TUNAI->value,
        ];

        AcceptanceReceiptPayment::create($data);
    }

    private function nonConsumer(AcceptanceReceipt $receipt): void
    {
        $data = [
            'acceptance_receipt_id' => $receipt->id,
            'payment_for' => 'Test Payment for non consumer',
            'payment_method' => PaymentMethod::TUNAI->value,
        ];

        AcceptanceReceiptPayment::create($data);
    }

    private function makeConsumerReceipt(): AcceptanceReceipt
    {
        return $this->makeReceipt(ReceiptCategory::CONSUMER->value);
    }

    private function makeNonConsumerReceipt(): AcceptanceReceipt
    {
        return $this->makeReceipt(ReceiptCategory::NON_CONSUMER->value);
    }

    public function test_guest_cant_edit_acceptance_receipt(): void
    {
        $receipt = $this->makeConsumerReceipt();

        $this->get(route('receipt.edit', ['type' => ReceiptType::ACCEPTANCE->value, 'receipt' => $receipt]))
            ->assertRedirect(route('login'));
    }

    public function test_user_cant_edit_acceptance_receipt_without_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','false permission'));

        $receipt = $this->makeConsumerReceipt();

        $this->get(route('receipt.edit',  ['type' => ReceiptType::ACCEPTANCE->value, 'receipt' => $receipt]))
            ->assertForbidden();
    }

    public function test_user_can_edit_acceptance_receipt_if_user_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','edit receipt'));

        $consumer_receipt = $this->makeConsumerReceipt();

        $this->put(route('receipt.update.acceptance', $consumer_receipt), [
            'customer_name' => 'test edit customer name',
            'amount' => 33333333,
            'category' => $consumer_receipt->category_id,
            'project_id' => $consumer_receipt->project_id,
            'created_by' => $consumer_receipt->created_by,
            'payment_for_consumer' => $consumer_receipt->acceptanceReceiptPayment->payment_for,
            'payment_for_consumer_description' => $consumer_receipt->acceptanceReceiptPayment->payment_for_description,
            'payment_method' => $consumer_receipt->acceptanceReceiptPayment->payment_method,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('acceptance_receipts', [
            'customer_name' => 'test edit customer name',
            'amount' => 33333333,
            'category_id' => $consumer_receipt->category_id,
            'project_id' => $consumer_receipt->project_id,
            'created_by' => $consumer_receipt->created_by,
        ]);

        $this->assertDatabaseHas('acceptance_receipt_payments', [
            'acceptance_receipt_id' => $consumer_receipt->id,
            'payment_for' => $consumer_receipt->acceptanceReceiptPayment->payment_for,
            'payment_method' => $consumer_receipt->acceptanceReceiptPayment->payment_method,
            'bank_id' => $consumer_receipt->acceptanceReceiptPayment->bank_id,
            'bank_method' => $consumer_receipt->acceptanceReceiptPayment->bank_method,
            'cek_or_giro_number' => $consumer_receipt->acceptanceReceiptPayment->cek_or_giro_number,
        ]);
    }

    /**
     * @dataProvider acceptanceReceiptValidationData
     */
    public function test_validation_edit_acceptance_receipt(string $field, string|int $value, string $error, string $error_message, array $extra_field = null): void
    {
        $this->actingAs($user = $this->createUser('user','edit receipt'));

        $data = [
            $field => $value,
        ];

        if ($extra_field) {
            $data = array_merge($data, $extra_field);
        }
        $non_consumer_receipt = $this->makeNonConsumerReceipt();

        $this->put(route('receipt.update.acceptance', $non_consumer_receipt), $data)
            ->assertSessionHasErrors([$error => $error_message]);
    }

    public static function acceptanceReceiptValidationData(): array
    {
        return [
            'customer_name_is_required' => ['customer_name', '', 'customer_name', 'The customer name field is required.'],
            'customer_name_is_string' => ['customer_name', 123, 'customer_name', 'The customer name field must be a string.'],
            'customer_name_is_max_255' => ['customer_name', str_repeat('a', 256), 'customer_name', 'The customer name field must not be greater than 255 characters.'],
            'amount_is_required' => ['amount', '', 'amount', 'The amount field is required.'],
            'amount_is_numeric' => ['amount', 'abc', 'amount', 'The amount field must be a number.'],
            'category_is_required' => ['category', '', 'category', 'The category field is required.'],
            'category_is_numeric' => ['category', 'abc', 'category', 'The category field must be a number.'],
            'category_is_in_enum' => ['category', 999, 'category', 'The selected category is invalid.'],
            'payment_for_consumer_is_required_if_category_consumer' => ['payment_for_consumer', '', 'payment_for_consumer', 'The payment for consumer field is required.', [
                'category' => ReceiptCategory::CONSUMER->value,
            ]],
            'payment_for_consumer_is_string' => ['payment_for_consumer', 123, 'payment_for_consumer', 'The payment for consumer field must be a string.', [
                'category' => ReceiptCategory::CONSUMER->value,
            ]],
            'payment_for_consumer_is_in_enum' => ['payment_for_consumer', 999, 'payment_for_consumer', 'The selected payment for consumer is invalid.', [
                'category' => ReceiptCategory::CONSUMER->value,
            ]],
            'payment_for_consumer_description_is_required_if_acceptance_payment_for_category_other_than_booking_fee' => ['payment_for_consumer_description', '', 'payment_for_consumer_description', 'The payment for consumer description field is required.', [
                'category' => ReceiptCategory::CONSUMER->value,
                'payment_for_consumer' => AcceptancePaymentForCategory::LAIN_NYA->value,
            ]],
            'payment_for_consumer_description_is_string' => ['payment_for_consumer_description', 123, 'payment_for_consumer_description', 'The payment for consumer description field must be a string.', [
                'category' => ReceiptCategory::CONSUMER->value,
                'payment_for_consumer' => AcceptancePaymentForCategory::LAIN_NYA->value,
            ]],
            'payment_for_consumer_description_is_max_255' => ['payment_for_consumer_description', str_repeat('a', 256), 'payment_for_consumer_description', 'The payment for consumer description field must not be greater than 255 characters.', [
                'category' => ReceiptCategory::CONSUMER->value,
                'payment_for_consumer' => AcceptancePaymentForCategory::LAIN_NYA->value,
            ]],
            'payment_for_non_consumer_is_required_if_category_non_consumer' => ['payment_for_non_consumer', '', 'payment_for_non_consumer', 'The payment for non consumer field is required.', [
                'category' => ReceiptCategory::NON_CONSUMER->value,
            ]],
            'payment_for_non_consumer_is_string' => ['payment_for_non_consumer', 123, 'payment_for_non_consumer', 'The payment for non consumer field must be a string.', [
                'category' => ReceiptCategory::NON_CONSUMER->value,
            ]],
            'payment_for_non_consumer_is_max_255' => ['payment_for_non_consumer', str_repeat('a', 256), 'payment_for_non_consumer', 'The payment for non consumer field must not be greater than 255 characters.', [
                'category' => ReceiptCategory::NON_CONSUMER->value,
            ]],
            'payment_method_is_required' => ['payment_method', '', 'payment_method', 'The payment method field is required.'],
            'payment_method_is_numeric' => ['payment_method', 'abc', 'payment_method', 'The payment method field must be a number.'],
            'payment_method_is_in_enum' => ['payment_method', 999, 'payment_method', 'The selected payment method is invalid.'],
            'bank_id_is_required_if_payment_method_bank' => ['bank_id', '', 'bank_id', 'The bank id field is required.', [
                'payment_method' => PaymentMethod::BANK->value,
            ]],
            'bank_id_is_numeric' => ['bank_id', 'abc', 'bank_id', 'The bank id field must be a number.', [
                'payment_method' => PaymentMethod::BANK->value,
            ]],
            'bank_id_is_exists_in_banks_table' => ['bank_id', 999, 'bank_id', 'The selected bank id is invalid.', [
                'payment_method' => PaymentMethod::BANK->value,
            ]],
            'bank_method_is_required_if_payment_method_bank' => ['bank_method', '', 'bank_method', 'The bank method field is required.', [
                'payment_method' => PaymentMethod::BANK->value,
            ]],
            'bank_method_is_numeric' => ['bank_method', 'abc', 'bank_method', 'The bank method field must be a number.', [
                'payment_method' => PaymentMethod::BANK->value,
            ]],
            'bank_method_is_in_enum' => ['bank_method', 999, 'bank_method', 'The selected bank method is invalid.', [
                'payment_method' => PaymentMethod::BANK->value,
            ]],
            'cek_or_giro_number_is_required_if_bank_method_other_than_transfer' => ['cek_or_giro_number', '', 'cek_or_giro_number', 'The cek or giro number field is required.', [
                'payment_method' => PaymentMethod::BANK->value,
                'bank_method' => BankPaymentMethod::GIRO->value,
            ]],
            'cek_or_giro_number_is_numeric' => ['cek_or_giro_number', 'abc', 'cek_or_giro_number', 'The cek or giro number field must be a number.', [
                'payment_method' => PaymentMethod::BANK->value,
                'bank_method' => BankPaymentMethod::GIRO->value,
            ]],
            'project_id_is_required' => ['project_id', '', 'project_id', 'The project field is required.'],
            'project_id_is_numeric' => ['project_id', 'abc', 'project_id', 'The project field must be a number.'],
            'project_id_is_exists_in_projects_table' => ['project_id', 999, 'project_id', 'The selected project is invalid.'],
        ];

    }
}
