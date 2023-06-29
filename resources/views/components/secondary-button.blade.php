<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple']) }}>
    {{ $slot }}
</button>
