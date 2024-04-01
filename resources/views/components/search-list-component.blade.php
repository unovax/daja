@props(['items' => [], 'for' => '', 'placeholder' => '', 'event' => 'addItem'])

<div
    x-data="{
        index: 0,
        show: false,
        changeIndex(length){
            this.show = event.target.value.length > 0;
            if(event.key === 'ArrowDown' && this.index < length - 1){
                this.index++
            }
            else if(event.key === 'ArrowUp' && this.index > 0){
                this.index--
            }
            else if(event.key === 'Enter' && length > 0){
                this.emitEvent(this.index);
            }
            else{
                this.index = 0
            }
            document.querySelector('.items-container').scrollTo(0, this.index * 36);
        },
        emitEvent(index){
            $wire.emit('{{ $event }}', index)
            this.show = false;
        }
    }"
    class="relative w-full"
    >
    <x-input x-on:click="show = true" x-on:keyup="changeIndex({{ count($items) }})" {{ $attributes->merge(['class' => '']) }} placeholder="{{ $placeholder }}" />
    <div x-show="show" x-on:click.away="show = false" class="bg-gray-900 w-full rounded-b-md max-h-[400px] overflow-auto absolute shadow-md z-[100] items-container">
        @foreach ($items as $key => $item)
            <div x-on:click="emitEvent({{ $key }})" :class="index == {{ $key }} ? 'bg-gray-700' : 'bg-gray-800'" class="px-4 py-2 w-full text-white hover:bg-gray-700 cursor-pointer">{{ $item->name }}</div>
        @endforeach
    </div>
    <x-input-error for="{{ $for }}"></x-input-error>
</div>
