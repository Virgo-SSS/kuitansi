<?php

namespace App\Actions;

use App\Models\Receipt;

class UpdateReceipt
{
    public function handle(array $data,  Receipt $receipt): void
    {
        $receipt->update($data);
    }
}
