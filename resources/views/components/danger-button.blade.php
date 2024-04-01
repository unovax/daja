<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full sm:w-auto px-2 py-1 text-sm sm:text-md sm:px-4 sm:py-2 rounded inline-flex items-center border border-transparent bg-red-500 hover:bg-red-700 text-gray-100 font-semibold transition ease-in-out duration-150 justify-center']) }}>
    {{ $slot }}
</button>
