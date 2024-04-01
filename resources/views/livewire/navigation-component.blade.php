<aside
    class="w-full max-w-[300px] h-screen bg-gray-800 shadow-2xl fixed transition-transform duration-500 z-[100]"
    style="display: none;"
    x-show="sidebar"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="-translate-x-0"
    x-transition:leave="transition ease-out duration-300"
    x-transition:leave-start="-translate-x-0"
    x-transition:leave-end="-translate-x-full"
    >
    <nav
        class="h-full"
        x-on:click.away="sidebar = false"
        >
        <section class="w-full flex space-x-2 justify-between px-4 py-2 items-center">
            <h1 class="text-3xl">{{ env('APP_NAME') }}</h1>
            <x-icons.menu x-on:click="sidebar = false" class="w-6 h-6 icon__pointer"/>
        </section>
        <ul class="flex flex-col items-center gap-y-1">
            @foreach ($links as $link)
                <h2 class="py-2 border-b border-gray-700 w-[95%]">{{ $link['name'] }}</h2>
                @foreach ($link['submenu'] as $l)
                    <x-link-component name="{{ $l['name'] }}" icon="{{ $l['icon'] }}" href="{{ $l['href'] }}" />
                @endforeach
            @endforeach
        </ul>
    </nav>
</aside>
