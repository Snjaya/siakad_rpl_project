<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fa-solid fa-key text-amber-500"></i>
                {{ __('Reset Password Pengguna') }}
            </h2>
        </div>
    </x-slot>
    <nav class="text-sm font-medium text-gray-500">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
            </li>
            <li class="flex items-center">
                <a href="{{ route('admin.users.index') }}" class="hover:text-amber-600 transition">Users</a>
                <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
            </li>
            <li class="text-amber-600">Reset</li>
        </ol>
    </nav>

    <div class="py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg sm:rounded-xl border-t-4 border-amber-500 overflow-hidden">

                <div class="p-6 text-center border-b border-gray-100 bg-amber-50/30">
                    <div
                        class="w-16 h-16 mx-auto bg-amber-100 rounded-full flex items-center justify-center text-amber-600 mb-3">
                        <i class="fa-solid fa-lock-open text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Reset Password: {{ $user->username }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Masukkan password baru untuk pengguna ini. <br>
                        Pastikan password kuat dan unik.
                    </p>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('admin.users.update-password', $user) }}">
                        @csrf @method('PATCH')

                        <div class="space-y-4">

                            <div x-data="{ show: false }">
                                <x-input-label for="password" :value="__('Password Baru')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-lock text-gray-400"></i>
                                    </div>

                                    <input id="password" x-bind:type="show ? 'text' : 'password'" name="password"
                                        class="pl-10 pr-10 block w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm h-11 transition-colors"
                                        required autofocus placeholder="••••••••" />

                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-amber-600 focus:outline-none transition-colors"
                                        tabindex="-1">
                                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>

                            <div x-data="{ show: false }">
                                <x-input-label for="password_confirmation" :value="__('Ulangi Password')"
                                    class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-check-double text-gray-400"></i>
                                    </div>

                                    <input id="password_confirmation" x-bind:type="show ? 'text' : 'password'"
                                        name="password_confirmation"
                                        class="pl-10 pr-10 block w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm h-11 transition-colors"
                                        required placeholder="••••••••" />

                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-amber-600 focus:outline-none transition-colors"
                                        tabindex="-1">
                                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex flex-col gap-3">
                            <button type="submit"
                                class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg shadow-md transition transform active:scale-95 flex justify-center items-center gap-2">
                                <i class="fa-solid fa-check-circle"></i> Simpan Password Baru
                            </button>

                            <a href="{{ route('admin.users.index') }}"
                                class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-center transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
