<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 rounded inline-flex items-center border border-transparent bg-green-500 hover:bg-green-700 text-gray-100 font-semibold transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
