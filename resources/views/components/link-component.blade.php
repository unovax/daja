@props(['href'=> "#", 'icon'=> "", 'name'=> "", 'href'=> "#"])
<li class="w-full flex items-center space-x-2 px-4 py-2 cursor-pointer hover:bg-gray-700 {{ Route::currentRouteName() == $name ? 'bg-gray-700 ' : '' }}">
    @component('components.'.$icon)@endcomponent
    <a x-on:click="sidebar = false" href="{{ $href }}" class="text-lg">{{ $name }}</a>
</li>
