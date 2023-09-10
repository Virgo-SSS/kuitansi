<?php

namespace Tests\Feature\Bank;

use App\Http\Livewire\CreateBank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateBankTest extends TestCase
{
    public function test_user_can_not_create_bank_if_not_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user'));

        Livewire::test(CreateBank::class)
            ->set('bankName', 'Bank Name')
            ->call('createBank')
            ->assertForbidden();

        $this->assertDatabaseCount('banks', 0);
    }

    public function test_user_can_create_bank_if_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'create bank'));

        Livewire::test(CreateBank::class)
            ->set('bankName', 'Bank Name')
            ->call('createBank')
            ->assertSuccessful();

        $this->assertDatabaseCount('banks', 1);
        $this->assertDatabaseHas('banks', [
            'name' => 'Bank Name',
        ]);
    }

    /**
     * @dataProvider createBankRequest
     */
    public function test_create_bank_validation(string|int $value, string $error): void
    {
        $this->actingAs($user = $this->createUser('user', 'create bank'));

        Livewire::test(CreateBank::class)
            ->set('bankName', $value)
            ->call('createBank')
            ->assertHasErrors(['bankName' => $error]);
    }

    public static function createBankRequest(): array
    {
        return [
            'bank name is required' => ['', 'required'],
            'bank name is max 255' => [str_repeat('a', 256), 'max'],
        ];
    }
}
