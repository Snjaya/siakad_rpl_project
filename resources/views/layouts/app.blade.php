<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIAKAD SMK Marhas') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="min-h-screen flex">

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'">

            <header
                class="bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 shadow-sm">

                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-blue-600 focus:outline-none transition-colors">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>

                    <div class="hidden md:block">
                        <h2 class="font-bold text-gray-700 text-lg leading-tight">
                            @if (isset($header))
                                {{ $header }}
                            @else
                                Dashboard
                            @endif
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-end text-right">
                        <span class="text-xs font-bold text-gray-600">{{ now()->format('l, d F Y') }}</span>
                        <span
                            class="text-[10px] text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">
                            Semester Ganjil 2025/2026
                        </span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 overflow-x-hidden">
                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center md:text-right">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} <span class="font-bold text-blue-800">SMK Marhas Margahayu</span>. All
                    rights reserved.
                </p>
            </footer>
        </div>
    </div>
</body>

</html>
