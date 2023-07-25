<?php

namespace Tests\Feature;

use App\Actions\CreateReceipt;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class CreateReceiptTest extends TestCase
{
    public function test_create_screen_can_be_rendered(): void
    {
        $this->actingAs($user = User::factory()->create());
        $this->get(route('receipt.create'))
            ->assertOk()
            ->assertViewIs('receipt.create');
    }

    public function test_create_screen_will_redirect_guest_user(): void
    {
        $this->get(route('receipt.create'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_authorized_user_can_create_receipt(): void
    {
        $this->actingAs($user = User::factory()->create());
        $state = Receipt::factory()->make([
            'created_by' => $user->id,
        ])->toArray();

        $this->post(route('receipt.store'), $state);

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

        $this->post(route('receipt.store'), $state)
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

    public function testActionCreateReceiptClass(): void
    {
        $this->actingAs($user = User::factory()->create());
        $state = Receipt::factory()->make([
            'created_by' => $user->id,
        ])->toArray();

        $action = new CreateReceipt();
        $action->handle($state);

        $this->assertDatabaseHas('receipts', $state);
    }
}
