<?php

namespace App\Services;

use App\Models\AcceptanceReceipt;
use App\Models\PaymentReceipt;

class ReceiptService
{
    public function setReceiptCode(AcceptanceReceipt|PaymentReceipt $receipt, string $pemisah = '/'): string
    {
        if($receipt instanceof AcceptanceReceipt) {
            $receiptCode = config('receipt.acceptance_receipt_code');
        }

        if($receipt instanceof PaymentReceipt) {
            $receiptCode = config('receipt.payment_receipt_code');
        }

        $romanService = app(RomanService::class);
        $id = sprintf("%03s", $receipt->id);
        $code = $id . $pemisah . $receiptCode . $pemisah . $romanService->integerToRoman($receipt->created_at->format('m')) . $pemisah . $receipt->created_at->format('Y');

        return $code;
    }

    public function setAmountText(int $amount): string
    {
        $amount = abs($amount);
        $text = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

        $temp = "";
        if ($amount < 12) {
            $temp =  " " . $text[$amount];
        } else if ($amount < 20) {
            $temp =  $this->setAmountText($amount - 10) . " belas";
        } else if ($amount < 100) {
            $temp =  $this->setAmountText($amount / 10) . " puluh" . $this->setAmountText($amount % 10);
        } else if ($amount < 200) {
            $temp =  " seratus" . $this->setAmountText($amount - 100);
        } else if ($amount < 1000) {
            $temp =  $this->setAmountText($amount / 100) . " ratus" . $this->setAmountText($amount % 100);
        } else if ($amount < 2000) {
            $temp =  " seribu" . $this->setAmountText($amount - 1000);
        } else if ($amount < 1000000) {
            $temp =  $this->setAmountText($amount / 1000) . " ribu" . $this->setAmountText($amount % 1000);
        } else if ($amount < 1000000000) {
            $temp =  $this->setAmountText($amount / 1000000) . " juta" . $this->setAmountText($amount % 1000000);
        } else if ($amount < 1000000000000) {
            $temp =  $this->setAmountText($amount / 1000000000) . " milyar" . $this->setAmountText($amount % 1000000000);
        } else if ($amount < 1000000000000000) {
            $temp =  $this->setAmountText($amount / 1000000000000) . " triliun" . $this->setAmountText($amount % 1000000000000);
        } else {
            $temp =  "Angka terlalu besar";
        }

        return $temp;
    }
}
