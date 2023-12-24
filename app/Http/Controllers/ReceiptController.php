<?php

namespace App\Http\Controllers;

use App\Actions\Receipt\Interfaces\CreateAcceptanceReceiptActionInterface;
use App\Actions\Receipt\Interfaces\CreatePaymentReceiptActionInterface;
use App\Actions\Receipt\Interfaces\EditAcceptanceReceiptActionInterface;
use App\Actions\Receipt\Interfaces\EditPaymentReceiptActionInterface;
use App\Enums\AcceptancePaymentForCategory;
use App\Enums\ReceiptCategory;
use App\Enums\ReceiptType;
use App\Http\Requests\Receipt\CreateAcceptanceReceiptRequest;
use App\Http\Requests\Receipt\CreatePaymentReceiptRequest;
use App\Http\Requests\Receipt\EditAcceptanceReceiptRequest;
use App\Http\Requests\Receipt\EditPaymentReceiptRequest;
use App\Models\AcceptanceReceipt;
use App\Models\PaymentReceipt;
use App\Repository\interfaces\AcceptanceReceiptRepositoryInterface;
use App\Repository\interfaces\PaymentReceiptRepositoryInterface;
use App\Services\ReceiptService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReceiptController extends Controller
{
    public function create(): View
    {
        $this->authorize('create receipt');

        $receiptCategories = ReceiptCategory::cases();
        $acceptancePaymentForCategories = AcceptancePaymentForCategory::cases();

        return view('receipt.create', compact(
            'receiptCategories',
            'acceptancePaymentForCategories',
        ));
    }

    public function storePaymentReceipt(CreatePaymentReceiptRequest $request, CreatePaymentReceiptActionInterface $action): RedirectResponse
    {
        $action->handle($request->validated());

        return redirect()->route('dashboard')->with('success', 'Receipt created successfully');
    }

    public function storeAcceptanceReceipt(CreateAcceptanceReceiptRequest $request, CreateAcceptanceReceiptActionInterface $action): RedirectResponse
    {
        $action->handle($request->validated());

        return redirect()->route('dashboard')->with('success', 'Receipt created successfully');
    }

    public function edit(int $type, int $receipt): View
    {
        $this->authorize('edit receipt');

        $receiptCategories = ReceiptCategory::cases();
        $acceptancePaymentForCategories = AcceptancePaymentForCategory::cases();

        if(!in_array($type, [ReceiptType::ACCEPTANCE->value, ReceiptType::PAYMENT->value])) {
            abort(404);
        }

        if($type == ReceiptType::ACCEPTANCE->value) {
            $receipt = app(AcceptanceReceiptRepositoryInterface::class)->findOrFail($receipt);
        } else {
            $receipt = app(PaymentReceiptRepositoryInterface::class)->findOrFail($receipt);
        }

        return view('receipt.edit', compact(
            'receiptCategories',
            'acceptancePaymentForCategories',
            'type',
            'receipt'));
    }

    public function updateAcceptanceReceipt(EditAcceptanceReceiptRequest $request, EditAcceptanceReceiptActionInterface $action, AcceptanceReceipt $receipt): RedirectResponse
    {
        $action->handle($receipt, $request->validated());

        return redirect()->route('dashboard')->with('success', 'Receipt updated successfully');
    }

    public function updatePaymentReceipt(EditPaymentReceiptRequest $request, EditPaymentReceiptActionInterface $action, PaymentReceipt $receipt): RedirectResponse
    {
        $action->handle($receipt, $request->validated());

        return redirect()->route('dashboard')->with('success', 'Receipt updated successfully');
    }

    public function print(int $type, int $receipt)
    {
        $this->authorize('print receipt');

        if(!in_array($type, [ReceiptType::ACCEPTANCE->value, ReceiptType::PAYMENT->value])) {
            abort(404);
        }

        if($type == ReceiptType::ACCEPTANCE->value) {
            $receipt = app(AcceptanceReceiptRepositoryInterface::class)->findOrFail($receipt);
        } else {
            $receipt = app(PaymentReceiptRepositoryInterface::class)->findOrFail($receipt);
        }

        $service = app(ReceiptService::class);

        $receipt->code = $service->setReceiptCode($receipt, '.');
        $receipt->nominal_text = $service->setAmountText($receipt->amount);
        $receipt->amount = number_format($receipt->amount,0,',','.');
        $receipt->type = $type;

        $pdf = Pdf::loadView('receipt.pdf', [
            'receipt' => $receipt,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($receipt->code . '.pdf');
    }
}
