@php use App\Enums\AcceptancePaymentForCategory;use App\Enums\BankPaymentMethod;use App\Enums\PaymentMethod;use App\Enums\ReceiptCategory;use App\Enums\ReceiptType; @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        .container {
            width: 100%;
        }

        .mt-10 {
            margin-top: 2.5rem;
        }

        .mb-16 {
            margin-bottom: 4rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .flex {
            display: flex;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-center {
            text-align: center;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .text-right {
            text-align: right;
        }
        .font-semibold {
            font-weight: 600;
        }

        .content-wrapper {
            width: 70rem;
        }

        .line {
            border-top: 1px solid black;
        }
        .key {
            width: 200px;
            float: left;
            text-align: left;
            padding-right: 2px;
        }

        td:empty::after{
            content: "\00a0";
        }
    </style>
</head>
<body>
<!-- Content -->
<div class="container">
    <!-- Header -->
    <header class="flex justify-between items-center">
        <!-- Logo dan Informasi Perusahaan -->
        <div class="flex items-center" style="gap:10px">
            <table>
                <tr>
                    <td>
                        <!-- Logo Perusahaan -->
                        @env('production')
                            <img src="{{ asset(config('receipt.logo')) }}" alt="Logo Perusahaan" style="width: 11rem; height: 4rem; object-fit: cover;margin-right: 10px">
                        @endenv
                        @env(['local', 'staging'])
                            <img src="https://cdn.pixabay.com/photo/2023/09/15/12/47/uaz-8254778_1280.jpg" alt="Logo Perusahaan" style="width: 11rem; height: 4rem; object-fit: cover;margin-right: 10px">
                        @endenv
                    </td>
                    <td>
                        <!-- Nama dan Alamat Perusahaan -->
                        <div>
                            <h1 class="font-bold text-lg">{{ config('receipt.company_name') }}</h1>
                            <p>{{ config('receipt.company_address') }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <!-- Judul Konten -->
    <h1 class="text-2xl font-bold mb-6 text-center">Kwitansi {{ ReceiptType::getDescription($receipt->type) }}</h1>

    <!-- Nomor Kwitansi -->
    <p class="text-right mb-6">NO. <span class="font-bold">{{ $receipt->code }}</span></p>

    <!-- Konten Dibungkus dengan Element <div> -->
    <div class="content-wrapper">
        <div>
        <table style="width: 90%; border-spacing: 0;">
            <tr>
                <td class="key">Telah Terima dari</td>
                <td>:</td>
                <td>{{ $receipt->customer_name }}</span></td>
            </tr>
            <tr>
                <td class="key" style="padding-top: 0px; vertical-align: top">Uang Sejumlah</td>
                <td style="padding-top: 0px; vertical-align: top">:</td>
                <td style="padding-top: 0px">#{{ strtoupper($receipt->nominal_text) }}#</td>
            </tr>
            <tr>
                <td class="key">Untuk Pembayaran</td>
                <td>:</td>
                <td>
                    @php
                        if($receipt->type == ReceiptType::ACCEPTANCE->value) {
                            $paymentFor = $receipt->acceptanceReceiptPayment->payment_for;
                            if($paymentFor != AcceptancePaymentForCategory::BOOKING_FEE) {
                                $paymentFor = $paymentFor . ' ' . $receipt->acceptanceReceiptPayment->payment_for_description;
                            }
                        } else {
                            $paymentFor = $receipt->payment_for;
                        }
                    @endphp

                   {{ $paymentFor }}
                </td>
            </tr>
            @if($receipt->category_id == ReceiptCategory::CONSUMER->value)
                <tr>
                    <td class="key"><p></p></td>
                    <td><p></p></td>
                    <td>
                        Tipe : {{ $receipt->project->type }} | Blok : {{ $receipt->project->block }} |  No : {{ $receipt->project->number }} |  Proyek : {{ $receipt->project->name }}
                    </td>
                </tr>
            @endif
            <tr>
                <td class="key">Jumlah</td>
                <td>:</td>
                <td>Rp. {{ $receipt->amount }}</td>
            </tr>
            @if($receipt->category_id == ReceiptCategory::NON_CONSUMER->value)
                <tr>
                    <td class="key">Proyek</td>
                    <td>:</td>
                    <td>{{ $receipt->project->name }}</td>
                </tr>
            @endif
            @if($receipt->type == ReceiptType::ACCEPTANCE->value)
                <tr>
                    <td class="key">Metode Pembayaran</td>
                    <td>:</td>
                    <td>
                        @php
                            $paymentMethod = $receipt->acceptanceReceiptPayment->payment_method;
                            $paymetMethodDescription =  PaymentMethod::getDescription($paymentMethod);
                            
                            if($paymentMethod == PaymentMethod::BANK->value) {
                                $bankMethod = $receipt->acceptanceReceiptPayment->bank_method;
                                $bankMethodDescription = BankPaymentMethod::getDescription($bankMethod);
                            }
                        @endphp
                        {{ $paymetMethodDescription }}
                        @if($paymentMethod == PaymentMethod::BANK->value)
                            {{ $receipt->acceptanceReceiptPayment->bank->name }}
                            -
                            {{ $bankMethodDescription }}
                            @if($bankMethod != BankPaymentMethod::TRANSFER->value)
                                No. {{ $receipt->acceptanceReceiptPayment->cek_or_giro_number }}
                            @endif
                        @endif
                    </td>
                </tr>
            @endif
        </table>
        </div>

    </div>

    <footer class="flex justify-between mt-10">
        <table style="width: 100%">
            <tr>
                <td style="width: 20%">
                    <!-- Tanda Tangan Kiri -->
                    <div style="margin-top:30px">
                        <div class="font-semibold mt-2 mb-16">DISERAHKAN OLEH :</div>
                        <div class="font-semibold">
                            {{ $receipt->type == ReceiptType::ACCEPTANCE->value ? $receipt->customer_name : $receipt->createdBy->name }}
                        </div>
                        <div class="line"></div>
                        <div class="font-semibold">{{ $receipt->type == ReceiptType::PAYMENT->value ? '(' . $receipt->createdBy->getStringRoleNames() . ')' : '' }}</div>
                    </div>
                </td>
                <td></td>
                <td style="width: 20%">
                    <!-- Tanda Tangan Kanan -->
                    <div class="text-right">
                        <span class="block font-semibold mb-2">Batam, {{ $receipt->created_at->isoFormat('D MMMM Y') }}</span>
                        <div class="font-semibold mt-2 mb-16">DI TERIMA OLEH :</div>
                        <div class="font-semibold">
                            {{ $receipt->type == ReceiptType::ACCEPTANCE->value ? $receipt->createdBy->name : $receipt->customer_name }}
                        </div>
                        <div class="line"></div>
                        <div class="font-semibold">{{ $receipt->type == ReceiptType::ACCEPTANCE->value ? '(' . $receipt->createdBy->getStringRoleNames() . ')' : '' }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </footer>
</div>
</body>
</html>
