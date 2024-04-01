<div class="relative w-full md:w-auto md:min-w-[500px] flex items-center">
    <input {{ $attributes->merge([
        'type'=>"text",
        'class'=>"rounded-md bg-gray-800 text-gray-100 w-full"
    ]) }}>
    <x-icons.search class="right-0 mr-2 absolute" />
</div>
