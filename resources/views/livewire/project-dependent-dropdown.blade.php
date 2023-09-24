<div>
    <label  class="block text-sm mt-3">
        <x-span>
            Project
            @error('project_id')
            <x-message.error>{{ $message }}</x-message.error>
            @enderror
        </x-span>

        <div class="grid grid-cols-4 gap-4 mt-3">
            <div>
                <label class="block text-sm">
                    <x-span>Perumahan</x-span>
                    <x-inputs.select-icon-left wire:model="selectedPerumahan" name="project-perumahan">
                        <option value="" selected>Select Perumahan</option>
                        @foreach($perumahans as $perumahan)
                            <option value="{{ $perumahan }}" @selected($selectedPerumahan == $perumahan)>{{ $perumahan }}</option>
                        @endforeach
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </x-slot>
                    </x-inputs.select-icon-left>
                </label>
            </div>

            @if(!is_null($selectedPerumahan))
                <div>
                    <label class="block text-sm">
                        <x-span>Blok</x-span>
                        <x-inputs.select-icon-left wire:model="selectedBlock" name="project-block">
                            <option value="-1" selected>Select Block</option>
                            @foreach($blocks as $block)
                                <option value="{{ $block }}">{{ $block }}</option>
                            @endforeach
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                                </svg>

                            </x-slot>
                        </x-inputs.select-icon-left>
                    </label>
                </div>
            @endif

            @if(!is_null($selectedBlock))
                <div>
                    <label class="block text-sm">
                        <x-span>No</x-span>
                        <x-inputs.select-icon-left wire:model="selectedNumber" name="project-number">
                            <option value="-1" selected>Select Number</option>
                            @foreach($numbers as $number)
                                <option value="{{ $number }}">{{ $number }}</option>
                            @endforeach
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.5 3c.967 2.78 1.5 5.817 1.5 9s-.533 6.22-1.5 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.889m-8.25.75l.213.09a1.687 1.687 0 002.062-.617l4.45-6.676a1.688 1.688 0 012.062-.618l.213.09" />
                                </svg>
                            </x-slot>
                        </x-inputs.select-icon-left>
                    </label>
                </div>
            @endif

            @if(!is_null($selectedNumber))
                <div>
                    <label class="block text-sm">
                        <x-span>Type</x-span>
                        <x-inputs.select-icon-left wire:model="selectedType" name="project-type">
                            <option value="" selected>Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                            <x-slot name="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                </svg>
                            </x-slot>
                        </x-inputs.select-icon-left>
                    </label>
                </div>
            @endif
        </div>
        <input type="hidden" name="project_id" value="{{ $selectedProject ? $selectedProject->id : '' }}">
    </label>
</div>
