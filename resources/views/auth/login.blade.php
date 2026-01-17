<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-blue-900 tracking-wide uppercase">
            SMK Marhas Margahayu
        </h1>
        <h2 class="text-sm font-semibold text-gray-500 mt-1">
            Sistem Informasi Akademik (SIAKAD)
        </h2>
        <p class="text-xs text-gray-400 mt-2 px-4">
            Jl. Terusan Kopo No.385/299, Margahayu Sel., Kec. Margahayu, <br>
            Kabupaten Bandung, Jawa Barat 40226
        </p>

        <div class="flex justify-center gap-2 mt-4">
            <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-1 rounded border border-blue-200">
                Teknik Komputer & Informatika
            </span>
            <span class="bg-orange-100 text-orange-800 text-[10px] font-bold px-2 py-1 rounded border border-orange-200">
                Teknik Pemesinan
            </span>
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="username" :value="__('Username / Email / NIP / NIS')" />
            <x-text-input id="username"
                class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500" type="text"
                name="username" :value="old('username')" required autofocus autocomplete="username"
                placeholder="Masukan Username atau Email..." />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <input id="password" x-bind:type="show ? 'text' : 'password'" name="password" required
                    autocomplete="current-password" placeholder="••••••••"
                    class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm pr-10" />

                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none cursor-pointer"
                    style="z-index: 10;" tabindex="-1">

                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-blue-800 shadow-sm focus:ring-blue-800" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button
                class="ml-3 w-full justify-center bg-blue-800 hover:bg-blue-900 py-3 shadow-lg transition-all duration-200">
                {{ __('Masuk ke Portal') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} SMK Marhas Margahayu Bandung
        </div>
    </form>
</x-guest-layout>
