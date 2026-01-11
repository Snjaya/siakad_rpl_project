<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-emerald-600"></i>
                {{ __('Tambah Akun Baru') }}
            </h2>
        </div>
    </x-slot>
    <nav class="text-sm font-medium text-gray-500">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
            </li>
            <li class="flex items-center">
                <a href="{{ route('admin.users.index') }}" class="hover:text-emerald-600 transition">Users</a>
                <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
            </li>
            <li class="text-emerald-600">Create</li>
        </ol>
    </nav>

    <div class="py-6 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">

                    <div class="px-6 py-4 bg-slate-50 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">Informasi Akun</h3>
                        <p class="text-sm text-gray-500">Lengkapi data di bawah ini untuk membuat pengguna baru.</p>
                    </div>

                    <div class="p-6 md:p-8 space-y-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="col-span-1">
                                <x-input-label for="username" :value="__('Username (NIP/NIS)')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <x-text-input id="username"
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11"
                                        type="text" name="username" :value="old('username')" required autofocus
                                        placeholder="Contoh: 19850101..." />
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Gunakan NIP untuk Guru/TU atau NIS untuk Siswa.
                                </p>
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="role" :value="__('Peran Pengguna')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-id-badge text-gray-400"></i>
                                    </div>
                                    <select id="role" name="role"
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11 bg-white">
                                        <option value="" disabled selected>Pilih Role...</option>
                                        <option value="Admin" class="font-bold text-red-600">Administrator (Superuser)
                                        </option>
                                        <option value="TU">Tata Usaha (TU)</option>
                                        <option value="Guru">Guru Pengajar</option>
                                        <option value="Siswa">Siswa</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-envelope text-gray-400"></i>
                                    </div>
                                    <x-text-input id="email"
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11"
                                        type="email" name="email" :value="old('email')" required
                                        placeholder="email@sekolah.sch.id" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div>
                            <h4
                                class="text-sm font-bold text-emerald-700 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-lock"></i> Keamanan Akun
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="password" :value="__('Password')"
                                        class="text-gray-700 font-bold mb-1" />
                                    <div class="relative">
                                        <x-text-input id="password"
                                            class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11"
                                            type="password" name="password" required autocomplete="new-password"
                                            placeholder="Minimal 8 karakter" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Ulangi Password')"
                                        class="text-gray-700 font-bold mb-1" />
                                    <div class="relative">
                                        <x-text-input id="password_confirmation"
                                            class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11"
                                            type="password" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="Ketik ulang password" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div
                        class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col-reverse md:flex-row justify-end items-center gap-3">
                        <a href="{{ route('admin.users.index') }}"
                            class="w-full md:w-auto text-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-sm">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit"
                            class="w-full md:w-auto px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fa-solid fa-save mr-1"></i> Simpan Data
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
