@props(['label' => '', 'input_id' => '', 'for' => '', 'items' => [], 'value' => 'id', 'text' => 'name', 'buttonSlot' => '', 'label_class' => ''])
<div class="w-full flex flex-col">
    <label class="block mt-2 {{ $label_class }}">{{$label}}</label>
    <div class="flex gap-2 w-full items-center">
        <select id="{{ $input_id }}" for="{{ $for }}" {{ $attributes->merge(['class'=> 'flex-1 bg-gray-700 text-gray-100 rounded-md']) }} >
            <option value="{{ null }}" disabled>Seleccione una opción</option>
            @foreach ($items as $item)
                <option value="{{ $item[$value] }}">{{ $item[$text] }}</option>
            @endforeach
        </select>
        {{ $buttonSlot }}
    </div>
    <x-input-error for="{{$for}}" />
</div>
