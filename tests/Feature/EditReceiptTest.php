<?php

namespace Tests\Feature;

use App\Actions\UpdateReceipt;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EditReceiptTest extends TestCase
{
    public function test_unauthenticated_user_cant_access_edit_receipt_page():void
    {
        $this->get(route('receipt.edit', 1))->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_edit_receipt_page(): void
    {
        $this->actingAs($user = User::factory()->create());
        $receipt = Receipt::factory()->create();
        $this->get(route('receipt.edit', $receipt->id))
            ->assertOk()
            ->assertViewHas('receipt')
            ->assertViewIs('receipt.edit');
    }

    public function test_can_update_receipt(): void
    {
        $this->actingAS($user = User::factory()->create());

        $receipt = Receipt::factory()->create();
        $state = Receipt::factory()->make([
            'created_by' => $receipt->created_by,
        ])->toArray();

        $this->put(route('receipt.update', $receipt->id), $state)
            ->assertSessionHas('success', 'Receipt updated successfully');

        $this->assertDatabaseHas('receipts', $state);
    }

    /**
     * @dataProvider validationDataProvider
     */
    public function test_create_receipt_validation(string|int $value, string $field, string $message): void
    {
        $this->actingAs($user = User::factory()->create());

        $state = Receipt::factory()->make()->toArray();
        if($field === 'giro_bank') {
            $state['payment_method'] = 'GIRO';
        }

        $state[$field] = $value;

        $receipt = Receipt::factory()->create();
        $this->put(route('receipt.update', $receipt->id), $state)
            ->assertSessionHasErrors([$field => $message]);
    }

    public static function validationDataProvider(): array
    {
        return [
            'received_from_required' => ['', 'received_from', 'The received from field is required.'],
            'received_from_string' => [123, 'received_from', 'The received from field must be a string.'],
            'received_from_max' => [Str::random(256), 'received_from', 'The received from field must not be greater than 255 characters.'],
            'amount_required' => ['', 'amount', 'The amount field is required.'],
            'amount_numeric' => ['abc', 'amount', 'The amount field must be a number.'],
            'amount_min' => [-1, 'amount', 'The amount field must be at least 0.'],
            'in_payment_for_required' => ['', 'in_payment_for', 'The in payment for field is required.'],
            'in_payment_for_string' => [123, 'in_payment_for', 'The in payment for field must be a string.'],
            'in_payment_for_max' => [Str::random(256), 'in_payment_for', 'The in payment for field must not be greater than 255 characters.'],
            'payment_method_required' => ['', 'payment_method', 'The payment method field is required.'],
            'payment_method_string' => [123, 'payment_method', 'The payment method field must be a string.'],
            'payment_method_uppercase' => ['giro', 'payment_method', 'The payment method field must be uppercase.'],
            'payment_method_in' => ['abc', 'payment_method', 'The selected payment method is invalid.'],
            'giro_bank_required' => ['', 'giro_bank', 'The giro bank field is required when payment method is GIRO.'],
            'giro_bank_string' => [123, 'giro_bank', 'The giro bank field must be a string.'],
            'giro_bank_max' => [Str::random(256), 'giro_bank', 'The giro bank field must not be greater than 255 characters.'],
        ];
    }

    public function test_class_action_update_receipt(): void
    {
        $this->actingAs($user = User::factory()->create());

        $receipt = Receipt::factory()->create();
        $state = Receipt::factory()->make([
            'created_by' => $receipt->created_by,
        ])->toArray();

        $action = new UpdateReceipt();
        $action->handle($state, $receipt);

        $this->assertDatabaseHas('receipts', $state);
    }
}
