<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIAKAD') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.navigation')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden transition-all duration-300">
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-500 hover:text-blue-600 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-all">
                            <i class="fa-solid fa-bars-staggered text-xl"></i>
                        </button>
                        @isset($header)
                            <h1 class="font-bold text-xl text-gray-800 tracking-tight">
                                {{ $header }}
                            </h1>
                        @endisset
                    </div>
                </div>
            </header>

            <main class="p-4 md:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
