<div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
    <input
        {{ $attributes->merge(['class' => 'block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input']) }}
    />

    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
        {!! $icon ?? '
        <svg
            class="w-5 h-5"
            aria-hidden="true"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
            ></path>
        </svg>'  !!}
    </div>
</div>
