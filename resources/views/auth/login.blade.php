<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - SMK Marhas Margahayu</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden flex flex-col lg:flex-row border border-gray-100">

        <div class="hidden lg:flex w-full lg:w-1/2 bg-white flex-col justify-between p-10 relative border-r border-gray-100">
            <div class="flex items-center gap-3 z-10">
                <img src="{{ asset('logo.png') }}" alt="Logo SMK" class="w-12 h-12 object-contain">
                <div>
                    <h1 class="text-xl font-bold tracking-wider text-blue-900">SMK MARHAS</h1>
                    <p class="text-xs opacity-70 uppercase tracking-widest text-gray-600">Margahayu Bandung</p>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center text-center z-10 mt-8 mb-4">
                <h2 class="text-2xl font-bold mb-2 leading-tight text-gray-800">
                    Selamat Datang di <br>
                    <span class="text-blue-700">Sistem Informasi Akademik</span>
                </h2>
                <p class="text-gray-500 text-sm mb-6 px-4">
                    Platform digital untuk memantau nilai, jadwal, dan aktivitas akademik siswa.
                </p>

                <div class="relative w-full max-w-xs">
                    <img src="{{ asset('login-illustration.png') }}"
                         alt="Ilustrasi Sekolah"
                         class="w-full h-auto object-contain drop-shadow-lg rounded-lg">
                </div>
            </div>

            <div class="text-center">
                <p class="text-[10px] text-gray-400">Education Management System V1.0</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center p-8 lg:p-12 relative">

            <div class="w-full">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Silakan Masuk</h3>
                    <p class="text-gray-500 text-sm mt-1">Masukkan data akun Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="username" :value="__('Username / Email / NIP / NIS')" class="text-gray-700 font-bold text-xs uppercase" />

                        <x-text-input id="username"
                                      class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2.5 px-3 bg-gray-50"
                                      type="text"
                                      name="username"
                                      :value="old('username')"
                                      required autofocus autocomplete="username"
                                      placeholder="Masukan Username atau Email..." />

                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="mb-4" x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold text-xs uppercase" />

                        <div class="relative">
                            <input id="password"
                                   x-bind:type="show ? 'text' : 'password'"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2.5 px-3 bg-gray-50 pr-10" />

                            <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none cursor-pointer"
                                    style="z-index: 10;" tabindex="-1">

                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800 font-semibold hover:underline" href="{{ route('password.request') }}">
                                {{ __('Lupa kata sandi?') }}
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                            {{ __('Masuk ke Portal') }}
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-xs text-gray-400">
                    &copy; 2026 SMK Marhas Margahayu Bandung.<br>All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
