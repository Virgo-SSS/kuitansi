<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Receipt Number</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Payment for</th>
                    <th class="px-4 py-3">Project</th>
                    <th class="px-4 py-3">Blok</th>
                    <th class="px-4 py-3">NO</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Payment Method</th>
                    <th class="px-4 py-3">Created By</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach($receipts as $receipt)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->code }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->customer_name }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->amount }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->payment_for ?? $receipt->acceptanceReceiptPayment->payment_for }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->project->name }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->project->block }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->project->number }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->project->type }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->payment_method }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->createdBy->name }}
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ $receipt->type }}
                        </td>
                        <td>
                            <div>
                                <a href="{{ route('receipt.edit', ['type' => $receipt->type_id, 'receipt' => $receipt->id]) }}">
                                    <x-buttons.small-button>
                                        <svg
                                            class="w-5 h-5"
                                            aria-hidden="true"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            ></path>
                                        </svg>
                                    </x-buttons.small-button>
                                </a>

                                <x-buttons.small-button wire:click="{{ $receipt->type == 'Acceptance Receipt' ? 'setAcceptanceReceiptModel('. $receipt->id .')' : 'setPaymentReceiptModel('. $receipt->id .')' }}"  @click="openModal"  class="!bg-red-500 !hover:bg-red-700 !focus:bg-red-700 !active:bg-red-900">
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </x-buttons.small-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div
            wire:ignore.self
            x-cloak
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
            >
            <!-- Modal -->
            <div
                x-show="isModalOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform translate-y-1/2"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0  transform translate-y-1/2"
                @click.away="closeModal"
                @keydown.escape="closeModal"
                class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                role="dialog"
                id="modal"
            >
                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                <header class="flex justify-end">
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                        aria-label="close"
                        @click="closeModal"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            role="img"
                            aria-hidden="true"
                        >
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                </header>
                <!-- Modal body -->
                <div class="mt-4 mb-6">
                    <!-- Modal title -->
                    <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="mt-3 sm:ml-4 sm:mt-0 sm:text-left">
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Delete Receipt
                    </p>
                    <!-- Modal description -->
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Are you sure you want to delete this receipt? All of your data will be permanently removed from our servers forever. This action cannot be undone.
                    </p>
                    </div>
                    </div>
                </div>
                <footer
                    class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
                >
                    <button
                        @click="closeModal"
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                    >
                        Cancel
                    </button>
                    <button
                        wire:click.prevent="deleteReceipt()"
                        @click="closeModal"
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red"
                    >
                        Delete
                    </button>
                </footer>
            </div>
        </div>
    </div>
</div>

