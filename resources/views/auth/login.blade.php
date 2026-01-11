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

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                class="block mt-1 w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500" type="password"
                name="password" required autocomplete="current-password" placeholder="••••••••" />
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
