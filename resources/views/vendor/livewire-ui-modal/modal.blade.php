@php use Illuminate\Support\Facades\Log; @endphp
<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
{{--    @isset($cssPath)--}}
{{--        <style>{!! file_get_contents($cssPath) !!}</style>--}}
{{--    @endisset--}}

    <div
        x-data="LivewireUIModal()"
        x-init="init()"
        x-show="show"
        x-on:close.stop="show = false"
        x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
        x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        style="display: none;"
    >

        {{-- Backdrop --}}
        <div
                x-show="show"
                x-on:click="closeModalOnClickAway()"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform translate-y-1/2"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0  transform translate-y-1/2"
                class="fixed inset-0 transition-all transform"
        >
            <div class="absolute inset-0 opacity-75"></div>
        </div>

        <!-- Modal -->
        <div
            x-show="show && showActiveComponent"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 transform translate-y-1/2"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0  transform translate-y-1/2"
            x-bind:class="modalWidth"
            x-on:keydown.escape.window="closeModalOnEscape()"
            class="inline-block px-6 py-4 w-full align-bottom bg-white dark:bg-gray-800 rounded-t-lg text-left overflow-hidden shadow-xl transform transition-all sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog"
            id="modal"
        >
            @forelse($components as $id => $component)
                <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}">
                    @livewire($component['name'], $component['attributes'], key($id))
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
