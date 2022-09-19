<!DOCTYPE html>
<html x-data="data()" :class="{ 'dark': dark }" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GA-TE') }}</title>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-touch-icon.png') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('js/init-alpine.js') }}"></script>
</head>

<body class="font-sans antialiased">
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        {{ $slot }}
    </div>
</body>

</html>
