@php use App\Enums\AcceptancePaymentForCategory;use App\Enums\ReceiptCategory;use App\Enums\ReceiptType; @endphp
<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Edit Receipt
    </h2>

    @if($type == ReceiptType::ACCEPTANCE->value)
        <div id="acceptance-receipt-wrapper">
            @include('receipt.edit-form.acceptance-receipt-form')
        </div>
    @endif

    @if($type == ReceiptType::PAYMENT->value)
        <div id="payment-receipt-wrapper">
            @include('receipt.edit-form.payment-receipt-form')
        </div>
    @endif

    <x-slot name="scripts">
        <script>
            let category_value = "{{ old('category') }}";
            if (category_value) {
                if (category_value == {{ ReceiptCategory::CONSUMER->value }}) {
                    consumer();
                }

                if (category_value == {{ ReceiptCategory::NON_CONSUMER->value }}) {
                    nonConsumer();
                }
            }

            function selectedCategory(e) {
                var value = $(e).find(':selected').val();

                if (value == {{ ReceiptCategory::CONSUMER->value }}) {
                    consumer();
                }

                if (value == {{ ReceiptCategory::NON_CONSUMER->value }}) {
                    nonConsumer();
                }
            }

            function consumer() {
                $('#payment_for_label').show();
                $('#payment_for_consumer').show();
                $('select[name="payment_for_consumer"]').attr('required', true).attr('disabled', false);

                $('#payment_for_non_consumer').hide();
                $('input[name="payment_for_non_consumer"]').attr('required', false).attr('disabled', true);
            }

            function nonConsumer() {
                $('#payment_for_label').show();
                $('#payment_for_consumer').val('').hide();
                $('select[name="payment_for_consumer"]').attr('required', false).attr('disabled', true);
                $('#deskripsi').hide();
                $('input[name="payment_for_consumer_description"]').attr('required', false).attr('disabled', true);

                $('#payment_for_non_consumer').show();
                $('input[name="payment_for_non_consumer"]').attr('required', true).attr('disabled', false);
            }

            let payment_for_consumer = "{{ old('payment_for_consumer') }}";
            if (payment_for_consumer) {
                paymentForConsumer(payment_for_consumer);
            }

            function selectedPaymentFor(e) {
                var value = $(e).find(':selected').val();
                paymentForConsumer(value);
            }

            function paymentForConsumer(value) {
                if (value != '{{ AcceptancePaymentForCategory::BOOKING_FEE->value }}') {
                    $('#deskripsi').show();
                    $('input[name="payment_for_consumer_description"]').attr('required', true).attr('disabled', false);
                } else {
                    $('#deskripsi').hide();
                    $('input[name="payment_for_consumer_description"]').attr('required', false).attr('disabled', true);
                }
            }
        </script>
    </x-slot>
</x-app-layout>

