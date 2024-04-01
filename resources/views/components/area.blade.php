@props(['input_id'=> '', 'disabled_input' => false ,'label' => '', 'for' => '', 'class' => '', 'type' => 'text', 'atributes' => [], 'label_class' => ''])
<div class="w-full text-gray-100">
    @if ($label)
        <label class="block mt-2 {{ $label_class }}">{{$label}}</label>
    @endif
    <div class="flex__container space-x-2">
        <textarea autocomplete="off" id="{{ $input_id }}" type="{{ $type }}" {{ $attributes->merge(['class' => 'w-full rounded-md bg-gray-700 ' . $class]) }}></textarea>
        @isset($buttonSlot)
            {{ $buttonSlot }}
        @endisset
    </div>
    <x-input-error for="{{$for}}" />
</div>
