<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReceiptController extends Controller
{
    public function create(): View
    {
        return view('receipt.create');
    }
}
