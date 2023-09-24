<?php

namespace App\Actions\Receipt;

use App\Actions\Receipt\Interfaces\EditAcceptanceReceiptActionInterface;
use App\Enums\BankPaymentMethod;
use App\Enums\PaymentMethod;
use App\Enums\ReceiptCategory;
use App\Models\AcceptanceReceipt;
use Illuminate\Support\Facades\DB;

class EditAcceptanceReceipt implements EditAcceptanceReceiptActionInterface
{
    public function handle(AcceptanceReceipt $receipt, array $request): void
    {
        DB::transaction(function () use ($request, $receipt) {
            $receipt->update([
                'customer_name' =>  $request['customer_name'],
                'amount' => $request['amount'],
                'project_id' => $request['project_id'],
                'category_id' => $request['category'],
            ]);

            if($receipt->category_id == ReceiptCategory::CONSUMER->value) {
                $this->consumer($receipt, $request);
            }

            if($receipt->category_id == ReceiptCategory::NON_CONSUMER->value) {
                $this->nonConsumer($receipt, $request);
            }
        });
    }

    private function consumer(AcceptanceReceipt $receipt, array $request): void
    {
        $data = [
            'acceptance_receipt_id' => $receipt->id,
            'payment_for' => $request['payment_for_consumer'],
            'payment_for_description' => $request['payment_for_consumer_description'],
            'payment_method' => $request['payment_method'],
        ];

        $data = $this->bank($data, $request);

        $receipt->acceptanceReceiptPayment->update($data);
    }

    private function nonConsumer(AcceptanceReceipt $receipt, array $request): void
    {
        $data = [
            'acceptance_receipt_id' => $receipt->id,
            'payment_for' => $request['payment_for_non_consumer'],
            'payment_method' => $request['payment_method'],
        ];

        $data['payment_for_description'] = null;

        $data = $this->bank($data, $request);

        $receipt->acceptanceReceiptPayment->update($data);
    }

    private function bank(array $data, array $request): array
    {
        if($data['payment_method'] == PaymentMethod::BANK->value) {
            $data['bank_id'] = $request['bank_id'];
            $data['bank_method'] = $request['bank_method'];
            $data['cek_or_giro_number'] = $data['bank_method'] != BankPaymentMethod::TRANSFER-> value ? $request['cek_or_giro_number'] : null;
        } else {
            $data['bank_id'] = null;
            $data['bank_method'] = null;
            $data['cek_or_giro_number'] = null;
        }

        return $data;
    }
}
