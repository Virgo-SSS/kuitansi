<?php

namespace Tests\Feature;

use App\Http\Livewire\DashboardData;
use App\Models\Receipt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteReceiptTest extends TestCase
{
    public function test_delete_receipt(): void
    {
        $receipt = Receipt::factory()->create();

        Livewire::test(DashboardData::class)
            ->call('setModelToDelete', $receipt->id)
            ->call('deleteReceipt');

        $this->assertNull($receipt->fresh());
    }
}
