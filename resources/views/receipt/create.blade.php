@php use App\Enums\AcceptancePaymentForCategory;use App\Enums\ReceiptCategory; @endphp
<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Create Receipt
    </h2>

    <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
        <button onclick="showCreateReceiptForm('acceptance-receipt')" type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            Acceptance Receipt
        </button>
        <button onclick="showCreateReceiptForm('payment-receipt')" type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
            Payment Receipt
        </button>
    </div>

    <div id="acceptance-receipt-wrapper" class="hidden">
        @include('receipt.create-form.acceptance-receipt-form')
    </div>
    <div id="payment-receipt-wrapper" class="hidden">
        @include('receipt.create-form.payment-receipt-form')
    </div>

    <x-slot name="scripts">
        <script>
            if (localStorage.getItem('receipt_type') === 'acceptance-receipt') {
                showCreateReceiptForm('acceptance-receipt');
            } else if (localStorage.getItem('receipt_type') === 'payment-receipt') {
                showCreateReceiptForm('payment-receipt');
            }

            function showCreateReceiptForm(name) {
                if (name === 'acceptance-receipt') {
                    $('#acceptance-receipt-wrapper').show();
                    $('#payment-receipt-wrapper').hide();

                    localStorage.setItem('receipt_type', 'acceptance-receipt');
                } else if (name === 'payment-receipt') {
                    $('#acceptance-receipt-wrapper').hide();
                    $('#payment-receipt-wrapper').show();

                    localStorage.setItem('receipt_type', 'payment-receipt');
                } else {
                    $('#acceptance-receipt-wrapper').hide();
                    $('#payment-receipt-wrapper').hide();
                    localStorage.removeItem("receipt_type");
                }
            }

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

                $('#payment_for_non_consumer').val('').hide();
                $('input[name="payment_for_non_consumer"]').attr('required', false).attr('disabled', true);
            }

            function nonConsumer() {
                $('#payment_for_label').show();
                $('#payment_for_consumer').val('').hide();
                $('select[name="payment_for_consumer"]').attr('required', false).attr('disabled', true);

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
                    $('input[name="payment_for_consumer_description"]').val('').attr('required', false).attr('disabled', true);
                }
            }
        </script>
    </x-slot>
</x-app-layout>

