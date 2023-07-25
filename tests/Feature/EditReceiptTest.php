<?php

namespace Tests\Feature;

use App\Models\Receipt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            ->assertSeeLivewire('receipt.edit-receipt-form');
    }
}
