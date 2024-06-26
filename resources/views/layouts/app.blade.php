<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body
        x-data="{
            sidebar: false
        }"
        class="bg-gray-300 dark:bg-gray-900 text-black dark:text-gray-300 overflow-auto flex">
        @livewire('navigation-component')
        <main
            class="h-screen w-full flex flex-col">
            <x-top-bar-component/>
            {{ $slot }}
            @livewire('notification-component')
        </main>
        @stack('modals')
        @livewireScripts
    </body>
</html>
