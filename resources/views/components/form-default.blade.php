@props(['submit'])

<form wire:submit.prevent="{{ $submit }}">
    {{ $slot}}

    @if (isset($actions))
        <div class="flex justify-end">
            {{ $actions }}
        </div>
    @endif
</form>
