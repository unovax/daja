@props(['inputId' => 'image', 'image' => null, 'imageSlot' => null])

<label for="{{ $inputId }}" class="font-bold flex justify-center items-center p-2 border border-dashed border-gray-300 rounded-md hover:scale-[98%] cursor-pointer" >
    @if ($image)
        {{ $imageSlot }}
    @else
        <span class="cursor-pointer">Subir imagen</span>
    @endif
    <input type="file" id="{{ $inputId }}" {{ $attributes->merge(['class' => 'hidden ']) }}>
</label>
