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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4 py-8">
            <!-- Logo / Home -->
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center">
                    <x-application-logo class="w-20 h-20 fill-current text-blue-600" />
                    <span class="mt-2 text-2xl font-bold text-blue-600">
                        Wedding Halls
                    </span>
                    <span class="text-sm text-gray-500">
                        Book your perfect wedding hall
                    </span>        
                </a>
            </div>
            <!-- Authentication Card -->
            <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 pt-6 text-center">
                    <h1 class="text-2xl font-bold text-gray-800"> 
                        Welcome
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Create your account and start booking 
                    </p>
                </div>
                <!-- Page Content -->
                <div class="px-6 py-6">
                    {{ $slot }}
                </div>
            </div>
            <!-- Footer -->
            <p class="mt-6 text-sm text-gray-500">
                © {{ date('Y') }} Wedding Halls. All rights reserved.
            </p>
        </div>
    </body>
</html>
