@props([
    'input_id'=> '',
    'disabled_input' => false ,
    'label_class' => '',
    'label' => '',
    'for' => '',
    'class' => '',
    'atributes' => [],
])
<div class="w-full text-gray-100 mt-2">
    <div class="flex space-x-2 items-center">
        <input autocomplete="off" id="{{ $input_id }}" type="checkbox" {{ $attributes->merge(['class' => 'rounded-md bg-gray-700 ' . $class]) }}>
        <label for="{{ $input_id }}" class="{{ $label_class }}">{{$label}}</label>
    </div>
    <x-input-error for="{{$for}}" />
</div>
