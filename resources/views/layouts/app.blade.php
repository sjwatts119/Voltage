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
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    </head>
    {{--get the dark mode setting from the user's settings and set it on load--}}
    {{--also listen for the dark-mode and light-mode events to change the dark mode setting dynamically--}}
    <body x-data="{ darkMode: {{ auth()->user()->settings->dark_mode ? 'true' : 'false' }} }"
          :class="{ 'dark': darkMode }"
          @dark-mode.window="darkMode = true"
          @light-mode.window="darkMode = false"
          class="font-sans antialiased">

        <div class="min-h-[100dvh] bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewire('wire-elements-modal')
    </body>
</html>
