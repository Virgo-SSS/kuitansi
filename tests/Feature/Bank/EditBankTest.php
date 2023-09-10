<?php

namespace Tests\Feature\Bank;

use App\Http\Livewire\EditBank;
use App\Models\Bank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditBankTest extends TestCase
{
    private function createBank(): int
    {
        return Bank::create([
            'name' => 'Bank Name',
        ])->id;
    }

    public function test_user_can_not_edit_bank_if_not_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user'));

        Livewire::test(EditBank::class, ['bank_id' => $this->createBank()])
            ->set('bank.name', 'Bank Name 123')
            ->call('editBank')
            ->assertForbidden();

        $this->assertDatabaseHas('banks',[
            'name' => 'Bank Name',
        ]);

        $this->assertDatabaseMissing('banks',[
            'name' => 'Bank Name 123',
        ]);
    }

    public function test_user_can_edit_bank_if_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('user', 'edit bank'));

        Livewire::test(EditBank::class, ['bank_id' => $this->createBank()])
            ->set('bank.name', 'Bank Name 123')
            ->call('editBank')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('banks', 1);

        $this->assertDatabaseHas('banks', [
            'name' => 'Bank Name 123',
        ]);

        $this->assertDatabaseMissing('banks', [
            'name' => 'Bank Name',
        ]);
    }

    /**
     * @dataProvider editBankRequest
     */
    public function test_create_bank_validation(string|int $value, string $error): void
    {
        $this->actingAs($user = $this->createUser('user', 'edit bank'));

        Livewire::test(EditBank::class, ['bank_id' => $this->createBank()])
            ->set('bank.name', $value)
            ->call('editBank')
            ->assertHasErrors(['bank.name' => $error]);
    }

    public static function editBankRequest(): array
    {
        return [
            'bank name is required' => ['', 'required'],
            'bank name is max 255' => [str_repeat('a', 256), 'max'],
        ];
    }
}
