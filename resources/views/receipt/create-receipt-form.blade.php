<x-form-default submit="store">
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm">
                    <x-label-span>Received From</x-label-span>
                    <x-input-error for="state.received_from" />
                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                        <x-input id="received_from" type="text" wire:model="state.received_from" placeholder="Received From" required class="pl-10 text-black "/>
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
                    <x-label-span>Amount</x-label-span>
                    <x-input-error for="state.amount" />
                    <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                        <x-input id="amount" type="text" wire:model="state.amount"
                        placeholder="Input The Amount" required class="pl-10 text-black"/>
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
                    <x-label-span>In Payment Of</x-label-span>
                    <x-input-error for="state.in_payment_for" />
                    <x-text-area wire:model="state.in_payment_for" placeholder="Enter description of payment" required></x-text-area>
                </label>
            </div>
        </div>
    </div>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-default>

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
