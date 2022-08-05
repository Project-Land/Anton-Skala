<!DOCTYPE html>
<html x-data="data()" :class="{ 'dark': dark }" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GA-TE') }} {{ $title ?? "" }}</title>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-touch-icon.png') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('js/focus-trap.js') }}"></script>
    <script src="{{ asset('js/init-alpine.js') }}"></script>

    @livewireStyles



    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/f94836499c.js" crossorigin="anonymous"></script>

    @stack('css')
</head>

<body class="font-sans antialiased">

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

        @include('components.desktop-sidebar')

        @include('components.mobile-sidebar')

        <div class="flex flex-col flex-1 w-full">
            @include('components.header')

            <main class="h-full overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

</body>

</html>
