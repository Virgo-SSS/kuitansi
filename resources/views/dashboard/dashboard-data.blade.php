<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Receipt Number</th>
                    <th class="px-4 py-3">Received From</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">In Payment for</th>
                    <th class="px-4 py-3">Payment Method</th>
                    <th class="px-4 py-3">Created By</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach($receipts as $receipt)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-2">
                            <x-inputs.checkbox />
                        </td>
                        <td class="px-2 py-2 text-sm">
                            #{{ $receipt->id }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->received_from }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            Rp. {{ $receipt->amount }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->in_payment_for }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->payment_method }} {{ $receipt->giro_bank ? ' - ' . $receipt->giro_bank : '' }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->created_by_user->name }}
                        </td>
                        <td>
                            <div>
                                <x-buttons.small-button>Edit</x-buttons.small-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $receipts->onEachSide(1)->links() }}
</div>
