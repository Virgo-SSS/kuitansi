<?php

namespace Tests\Feature;

use App\Http\Livewire\receipt\CreateReceiptForm;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class CreateReceiptest extends TestCase
{
    use RefreshDatabase;

    private function liveWireTest(array $state): TestableLivewire
    {
        return Livewire::test(CreateReceiptForm::class)
            ->set('state', $state)
            ->call('store');
    }

    public function test_create_screen_can_be_rendered(): void
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get(route('receipt.create'))->assertSeeLivewire(CreateReceiptForm::class);

        $response->assertStatus(200);
    }

    public function test_create_screen_will_redirect_guest_user(): void
    {
        $response = $this->get(route('receipt.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_authorized_user_can_create_receipt(): void
    {
        $this->actingAs($user = User::factory()->create());
        $state = Receipt::factory()->make()->toArray();

        $this->liveWireTest($state);

        $this->assertDatabaseHas('receipts', $state);
    }


    /**
     * @dataProvider validationDataProvider
     */
    public function test_create_recipt_validation(string|int $value, string $field, string $validation): void
    {
        $this->actingAs($user = User::factory()->create());

        $state = Receipt::factory()->make()->toArray();
        $state[$field] = $value;

        $this->liveWireTest($state)
            ->assertHasErrors(['state.'.$field => $validation]);
    }

    protected static function validationDataProvider(): array
    {
        return [
            'received_from_required' => ['', 'received_from', 'required'],
            'received_from_string' => [123, 'received_from', 'string'],
            'received_from_max' => [Str::random(256), 'received_from', 'max'],
            'amount_required' => ['', 'amount', 'required'],
            'amount_numeric' => ['abc', 'amount', 'numeric'],
            'amount_min' => [-1, 'amount', 'min'],
            'in_payment_for_required' => ['', 'in_payment_for', 'required'],
            'in_payment_for_string' => [123, 'in_payment_for', 'string'],
            'in_payment_for_max' => [Str::random(256), 'in_payment_for', 'max'],
        ];
    }
}
