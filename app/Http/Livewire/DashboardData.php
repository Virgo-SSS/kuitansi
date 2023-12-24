<?php

namespace App\Http\Livewire;

use App\Enums\PaymentMethod;
use App\Enums\ReceiptType;
use App\Models\AcceptanceReceipt;
use App\Models\PaymentReceipt;
use App\Repository\interfaces\AcceptanceReceiptRepositoryInterface;
use App\Repository\interfaces\PaymentReceiptRepositoryInterface;
use App\Services\PaginatorService;
use App\Services\ReceiptService;
use App\Trait\ToastTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardData extends Component
{
    use WithPagination, ToastTrait;

    public AcceptanceReceipt|PaymentReceipt $receipt;

    public function render(): View
    {
        $service = app(ReceiptService::class);
        $acceptanceReceipt = app(AcceptanceReceiptRepositoryInterface::class)->paginate(15); // 20
        $paymentReceipt = app(PaymentReceiptRepositoryInterface::class)->paginate(15); // 20
        // total data is 40 (20 + 20)
        $receipts = app(PaginatorService::class)->merge([$acceptanceReceipt, $paymentReceipt])->get();
//        dd($receipts);
        $receipts->each(function (AcceptanceReceipt|PaymentReceipt $receipt) use ($service) {
            $receipt->code = $service->setReceiptCode($receipt);
            $receipt->amount = number_format($receipt->amount);
            $payment_method = $receipt->acceptanceReceiptPayment ? $receipt->acceptanceReceiptPayment->payment_method : null;
            $receipt->payment_method = !is_null($payment_method) ? PaymentMethod::getDescription($payment_method) :  '-' ;

            $receipt->type = $receipt instanceof AcceptanceReceipt ? ReceiptType::ACCEPTANCE->name : ReceiptType::PAYMENT->name;
            $receipt->type_id = $receipt instanceof AcceptanceReceipt ? ReceiptType::ACCEPTANCE->value : ReceiptType::PAYMENT->value;
        });

        return view('dashboard.dashboard-data',[
            'receipts' => $receipts,
        ]);
    }

    public function setAcceptanceReceiptModel(AcceptanceReceipt $receipt): void
    {
        $this->receipt = $receipt;
    }

    public function setPaymentReceiptModel(PaymentReceipt $receipt): void
    {
        $this->receipt = $receipt;
    }

    public function deleteReceipt(): void
    {
        $this->receipt->delete();

        $this->toastSuccess('Receipt deleted successfully');
    }
}
