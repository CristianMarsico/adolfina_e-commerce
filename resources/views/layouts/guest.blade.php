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
    </head>
    <body data-turbo="false" class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-sky-50 via-white to-blue-50">
            <div class="mb-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2">
                    <img src="{{ asset('images/logo.jpg') }}" alt="{{ $configuracion->nombre_negocio ?? 'Pañalera' }}" class="h-24 w-24 rounded-full object-cover ring-4 ring-sky-100 shadow">
                    <span class="text-2xl font-bold text-sky-600">{{ $configuracion->nombre_negocio ?? 'Pañalera' }}</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-6 bg-white rounded-xl shadow-sm border border-gray-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
