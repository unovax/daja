@props(['href'=> "#", 'icon'=> "", 'name'=> "", 'href'=> "#"])
<a x-on:click="sidebar = false" href="{{ $href }}" class="flex w-[90%] rounded-md items-center space-x-2 px-4 py-2 cursor-pointer hover:bg-gray-700 {{ Route::currentRouteName() == $name ? 'bg-gray-700 ' : '' }}">
    @component('components.'.$icon)@endcomponent
    <span  class="text-sm">{{ $name }}</span>
</a>
