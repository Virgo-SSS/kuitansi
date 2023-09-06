@props(['isChecked' => false])


<input type="checkbox" {{ $isChecked ? 'checked' : '' }}
    {{ $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) }}>
