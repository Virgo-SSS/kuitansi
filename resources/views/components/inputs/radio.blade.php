@props(['checked' => false])

<input type="radio"  {{ $checked ? 'checked' : '' }} {{ $attributes->merge([
    'class' => "text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray",
]) }}>
