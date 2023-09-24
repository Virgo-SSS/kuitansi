<div>
    <div class="md:grid md:grid-cols-3 md:gap-6 px-4">
        <x-section-title>
            <x-slot name="title">{{ __('Update Password') }}</x-slot>
            <x-slot name="description">  {{ __('Ensure your account is using a long, random password to stay secure.') }}</x-slot>
        </x-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form>
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md dark:bg-gray-800">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="current_password" value="{{ __('Current Password') }}" />
                            <x-inputs.text id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
                            @error('current_password')
                            <x-message.error>{{ $message }}</x-message.error>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="password" value="{{ __('New Password') }}" />
                            <x-inputs.text id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                            @error('password')
                            <x-message.error>{{ $message }}</x-message.error>
                            @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-inputs.text id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                            @error('password_confirmation')
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
