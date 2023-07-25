<x-app-layout>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Edit Receipt
    </h2>

    <form action="{{ route('receipt.store') }}" method="POST">
        @csrf
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm">
                        <x-span>Received From</x-span>
                        <x-errors.default for="state.received_from" />
                        <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                            <x-inputs.default id="received_from" name="received_model" type="text" placeholder="Received From" required class="pl-10 text-black"/>
                            <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                        </div>
                    </label>
                </div>
                <div>
                    <label class="block text-sm">
                        <x-span>Amount</x-span>
                        <x-errors.default for="state.amount" />
                        <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                            <x-inputs.default id="amount" type="text" wire:model="state.amount" placeholder="Input The Amount" required class="pl-10 text-black"/>
                            <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                Rp.
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block mt-4 text-sm">
                        <x-span>Payment Method</x-span>
                        <x-errors.default for="state.payment_method" />
                        <span class="mr-3">
                            <x-inputs.radio wire:model="state.payment_method" id="cash" value="CASH"  wire:click="setGiroBankDiv(false)"/>
                            <label for="cash" class="ml-2 dark:text-gray-400">Cash</label>
                        </span>
                        <span class="mr-3">
                            <x-inputs.radio wire:model="state.payment_method" id="transfer" value="TRANSFER"  wire:click="setGiroBankDiv(false)"/>
                            <label for="transfer" class="ml-2 dark:text-gray-400">Via Transfer</label>
                        </span>
                        <span class="mr-3">
                            <x-inputs.radio wire:model="state.payment_method" id="giro" value="GIRO"  wire:click="setGiroBankDiv(true)"/>
                            <label for="giro" class="ml-2 dark:text-gray-400">Giro</label>
                        </span>
                    </label>
                </div>
            </div>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block mt-4 text-sm">
                            <x-span>Giro Bank</x-span>
                            <x-errors.default for="state.giro_bank" />
                            <x-inputs.default wire:model="state.giro_bank" type="text" id="giro_bank" placeholder="Enter Giro/Bilyet Bank" required/>
                        </label>
                    </div>
                </div>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block mt-4 text-sm">
                        <x-span>In Payment Of</x-span>
                        <x-errors.default for="state.in_payment_for" />
                        <x-text-area wire:model="state.in_payment_for" placeholder="Enter description of payment" required></x-text-area>
                    </label>
                </div>
            </div>
        </div>

        <x-slot name="actions">
            <x-buttons.submit>
                {{ __('Save') }}
            </x-buttons.submit>
        </x-slot>
    </form>


    <x-slot name="scripts">
        <script>
            $('#amount').on('input', function() {
                $(this).val(formatRupiah($(this).val()))
            })

            /* Fungsi */
            function formatRupiah(angka)
            {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split    = number_string.split(','),
                    sisa     = split[0].length % 3,
                    rupiah     = split[0].substr(0, sisa),
                    ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }
        </script>
    </x-slot>
</x-app-layout>
