<button {{ $attributes->merge(
    [
        "class" => "
            px-3
            py-1
            text-sm
            font-medium
            leading-5
            text-white
            transition-colors
            duration-150
            border
            border-transparent
            rounded-md
            focus:outline-none
            focus:shadow-outline-purple
            bg-purple-600
            active:bg-purple-600
            hover:bg-purple-700",

        'type' => 'button',
    ],
)}}>

    {{ $slot }}
</button>
