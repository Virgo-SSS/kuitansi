<?php

namespace Tests\Feature\Bank;

use App\Http\Livewire\BankData;
use App\Models\Bank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_user_cant_delete_bank_if_not_have_permission(): void
    {
        $user = $this->createUser('user', ['view bank page']);
        $bank = $this->createBank();

        $this->actingAs($user);

        Livewire::test(BankData::class)
            ->call('deleteBank', $bank->id)
            ->assertForbidden();

        $this->assertDatabaseHas('banks', ['name' => $bank->name]);

        $this->assertDatabaseCount('banks', 1);
    }

    public function test_user_can_delete_bank_if_has_permission(): void
    {
        $user = $this->createUser('user', ['view bank page', 'delete bank']);
        $bank = $this->createBank();

        $this->actingAs($user);

        Livewire::test(BankData::class)
            ->call('deleteBank', $bank->id)
            ->assertSuccessful();

        $this->assertDatabaseMissing('banks', ['name' => $bank->name]);
        $this->assertDatabaseCount('banks', 0);
    }
}
