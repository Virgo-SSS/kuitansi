<?php

namespace Tests\Feature\Bank;

use App\Http\Livewire\BankData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankPageTest extends TestCase
{
    public function test_guest_cant_see_bank_page(): void
    {
        $response =  $this->get('/bank');

        $response->assertRedirect('/login')
            ->assertStatus(302);
    }

    public function test_user_cant_see_bank_page_if_has_not_permission(): void
    {
        $response = $this->actingAs($user = $this->createUser('user'))->get('/bank');

        $response->assertStatus(403);
    }

    public function test_user_can_see_bank_page_if_has_permission(): void
    {
        $this->actingAs($user = $this->createUser('admin'));
        $response = $this->get('/bank');

        $response->assertSeeLivewire(BankData::class)
            ->assertStatus(200);
    }
}
