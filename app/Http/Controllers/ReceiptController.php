<?php

namespace App\Http\Controllers;

use App\Actions\CreateReceipt;
use App\Http\Requests\CreateReceiptRequest;
use App\Models\Receipt;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReceiptController extends Controller
{
    public function create(): View
    {
        return view('receipt.create');
    }

    public function store(CreateReceiptRequest $request, CreateReceipt $actions): RedirectResponse
    {
        $actions->handle($request->validated());

        return redirect()->back()->with('success', 'Receipt created successfully');
    }

    public function edit(Receipt $receipt): View
    {
        return view('receipt.edit', compact('receipt'));
    }
}
