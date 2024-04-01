<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full sm:w-auto px-2 py-1 text-sm sm:text-md sm:px-4 sm:py-2 rounded flex items-center space-x-1 border border-transparent bg-green-500 hover:bg-green-700 text-gray-100 font-semibold transition ease-in-out duration-150 justify-center']) }}>
    {{ $slot }}
</button>
