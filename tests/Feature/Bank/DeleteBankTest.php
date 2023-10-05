<?php

namespace Tests\Feature\Bank;

use App\Http\Livewire\BankData;
use App\Http\Livewire\DeleteBankModal;
use App\Models\Bank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\View\View;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteBankTest extends TestCase
{
    private function createBank(): Bank
    {
        return Bank::create([
            'name' => 'Bank Name',
        ]);
    }

    public function test_load_component(): void
    {
        $user = $this->createUser('user', ['delete bank']);
        $bank = $this->createBank();

        $this->actingAs($user);

        Livewire::test(DeleteBankModal::class, ['bankId' => $bank->id])
            ->assertSuccessful()
            ->assertViewIs('bank.delete-bank-modal');
    }

    public function test_user_cant_delete_bank_if_not_have_permission(): void
    {
        $user = $this->createUser('user');
        $bank = $this->createBank();

        $this->actingAs($user);

        Livewire::test(DeleteBankModal::class, ['bankId' => $bank->id])
            ->call('deleteBank')
            ->assertForbidden();

        $this->assertDatabaseHas('banks', ['id' => $bank->id ]);

        $this->assertDatabaseCount('banks', 1);
    }

    public function test_user_can_delete_bank_if_has_permission(): void
    {
        $user = $this->createUser('user', ['delete bank']);
        $bank = $this->createBank();

        $this->actingAs($user);

        Livewire::test(DeleteBankModal::class, ['bankId' => $bank->id])
            ->call('deleteBank')
            ->assertSuccessful();

        $this->assertDatabaseMissing('banks', ['id' => $bank->id ]);
        $this->assertDatabaseCount('banks', 0);
    }
}
