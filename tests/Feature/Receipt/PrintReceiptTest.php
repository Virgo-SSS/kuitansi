<?php

namespace Tests\Feature\Receipt;

use App\Enums\ReceiptType;
use App\Models\PaymentReceipt;
use App\Services\ReceiptService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PrintReceiptTest extends TestCase
{
    public function test_guest_cant_download_receipt(): void
    {
        $receipt = PaymentReceipt::factory()->create();

        $this->get(route('receipt.print', ['type' => 'payment', 'receipt' => $receipt->id]))
            ->assertRedirect(route('login'));
    }

    public function test_user_cant_download_receipt_if_dont_have_permission(): void
    {
        $receipt = PaymentReceipt::factory()->create();

        $this->actingAs($user = $this->createUser('user'))
            ->get(route('receipt.print', ['type' => ReceiptType::PAYMENT->value, 'receipt' => $receipt->id]))
            ->assertForbidden();
    }

    public function test_user_can_download_receipt_if_have_permission(): void
    {
        $receipt = PaymentReceipt::factory()->create();
        $this->actingAs($user = $this->createUser('user', ['print receipt']));

        $response = $this->get(route('receipt.print', ['type' => ReceiptType::PAYMENT->value, 'receipt' => $receipt->id]));
        $response->assertOk();
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));

        $filename = app(ReceiptService::class)->setReceiptCode($receipt, '.');
        $this->assertEquals('attachment; filename="' . $filename . '.pdf'.'"', $response->headers->get('Content-Disposition'));
    }
}
