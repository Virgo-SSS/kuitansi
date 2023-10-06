<button {{ $attributes->merge(
    [
        'type' => 'submit',
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
            bg-blue-500
            hover:bg-blue-700
            focus:bg-blue-700
            active:bg-blue-900",
    ],
)}}>

    {{ $slot }}
</button>
