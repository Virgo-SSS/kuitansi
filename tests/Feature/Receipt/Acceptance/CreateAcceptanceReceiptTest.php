<?php

namespace Tests\Feature\Receipt\Acceptance;

use App\Enums\AcceptancePaymentForCategory;
use App\Enums\BankPaymentMethod;
use App\Enums\PaymentMethod;
use App\Enums\ReceiptCategory;
use App\Models\Bank;
use App\Models\Project;
use Tests\TestCase;

class CreateAcceptanceReceiptTest extends TestCase
{
    public function test_guest_cant_create_acceptance_receipt(): void
    {
        $this->post(route('receipt.store.acceptance'))
            ->assertRedirect(route('login'));
    }

    public function test_user_cant_create_acceptance_receipt_without_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','false permission'));

        $this->post(route('receipt.store.acceptance'))
            ->assertForbidden();
    }

    public function test_user_can_create_acceptance_receipt_if_user_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user','create receipt'));

        $project = Project::factory()->create();
        $bank = Bank::factory()->create();

        // create Non Consumer Receipt
        $non_consumer_receipt_data = [
            "customer_name" => "Oliver Roberson",
            "amount" => 2222223121,
            "category" => ReceiptCategory::NON_CONSUMER->value,
            "payment_for_consumer_description" => null,
            "payment_for_non_consumer" => "asfawfawfawew",
            "payment_method" => PaymentMethod::BANK->value,
            "bank_id" => $bank->id,
            "bank_method" => BankPaymentMethod::GIRO->value,
            "cek_or_giro_number" => 232323232,
            "project_id" => $project->id
        ];
        $this->post(route('receipt.store.acceptance'), $non_consumer_receipt_data)->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('acceptance_receipts', [
            'customer_name' => $non_consumer_receipt_data['customer_name'],
            'amount' => $non_consumer_receipt_data['amount'],
            'category_id' => $non_consumer_receipt_data['category'],
            'project_id' => $non_consumer_receipt_data['project_id'],
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('acceptance_receipt_payments', [
            'payment_for' => $non_consumer_receipt_data['payment_for_non_consumer'],
            'payment_method' => $non_consumer_receipt_data['payment_method'],
            'bank_id' => $non_consumer_receipt_data['bank_id'],
            'bank_method' => $non_consumer_receipt_data['bank_method'],
            'cek_or_giro_number' => $non_consumer_receipt_data['cek_or_giro_number'],
        ]);

        // create Consumer Receipt
        $consumer_receipt_data = [
            "customer_name" => "Adele Owen",
            "amount" => 2222222,
            "category" => ReceiptCategory::CONSUMER->value,
            "payment_for_consumer" => AcceptancePaymentForCategory::LAIN_NYA->value,
            "payment_for_consumer_description" => "qweqweqeqweq",
            "payment_for_non_consumer" => null,
            "payment_method" => PaymentMethod::TUNAI->value,
            "project_id" => $project->id,
        ];
        $this->post(route('receipt.store.acceptance'), $consumer_receipt_data)->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('acceptance_receipts', [
            'customer_name' => $consumer_receipt_data['customer_name'],
            'amount' => $consumer_receipt_data['amount'],
            'category_id' => $consumer_receipt_data['category'],
            'project_id' => $consumer_receipt_data['project_id'],
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('acceptance_receipt_payments', [
            'payment_for' => $consumer_receipt_data['payment_for_consumer'],
            'payment_for_description' => $consumer_receipt_data['payment_for_consumer_description'],
            'payment_method' => $consumer_receipt_data['payment_method'],
        ]);
    }

    /**
     * @dataProvider acceptanceReceiptValidationData
     */
    public function test_validation_create_acceptance_receipt(string $field, string|int $value, string $error, string $error_message, array $extra_field = null): void
    {
        $this->actingAs($user = $this->createUser('user','create receipt'));

        $data = [
            $field => $value,
        ];

        if ($extra_field) {
            $data = array_merge($data, $extra_field);
        }

        $this->post(route('receipt.store.acceptance'), $data)
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
            'payment_for_consumer_is_required_if_category_consumer' => ['payment_for_consumer', '', 'payment_for_consumer', 'The payment for consumer field is required.',[
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
