<div>
    <div class="md:grid md:grid-cols-3 md:gap-6 px-4">
        <x-section-title>
            <x-slot name="title">{{ __('Profile Information') }}</x-slot>
            <x-slot name="description"> {{ __('Update your account\'s profile information and email address.') }}</x-slot>
        </x-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form>
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md dark:bg-gray-800">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-inputs.text id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name"/>
                            @error('name')
                                <x-message.error>{{ $message }}</x-message.error>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-inputs.text id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="username" />
                            @error('email')
                                <x-message.error>{{ $message }}</x-message.error>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md dark:bg-gray-700">
                    <x-buttons.submit>
                        {{ __('Save') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </div>
</div>
