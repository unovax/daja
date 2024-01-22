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
        <hr>
        <ul>
            @foreach ($links as $link)
                <x-link-component name="{{ $link['name'] }}" icon="{{ $link['icon'] }}" href="{{ $link['href'] }}" />
            @endforeach
        </ul>
    </nav>
</aside>
