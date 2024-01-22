<nav class="bg-gray-300 dark:bg-gray-900 h-[52px] border-b border-gray-400 dark:border-gray-800 p-2 flex justify-between items-center">
    <div class="flex space-x-2 items-center">
        <x-icons.menu x-on:click="sidebar = true" class="w-6 h-6 icon__pointer"/>
        <h1 class="text-xl font-bold">{{ Route::currentRouteName() }}</h1>
    </div>
</nav>
