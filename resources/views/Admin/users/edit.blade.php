<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-emerald-600"></i>
                {{ __('Edit Data Pengguna') }}
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
            <li class="text-emerald-600">Edit</li>
        </ol>
    </nav>

    <div class="py-6 md:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden relative">

                <div class="px-6 py-6 bg-slate-50 border-b border-gray-100 flex items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($user->username, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $user->username }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <span
                            class="inline-flex items-center rounded-md px-2 py-1 mt-1 text-xs font-medium bg-emerald-100 text-emerald-700">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf @method('PATCH')

                        <div class="space-y-6">

                            <div>
                                <x-input-label for="username" :value="__('Username (NIP/NIS)')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <x-text-input id="username"
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11"
                                        type="text" name="username" :value="old('username', $user->username)" required />
                                </div>
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-envelope text-gray-400"></i>
                                    </div>
                                    <x-text-input id="email"
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11"
                                        type="email" name="email" :value="old('email', $user->email)" required />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="role" :value="__('Peran Pengguna')" class="text-gray-700 font-bold mb-1" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-id-badge text-gray-400"></i>
                                    </div>
                                    <select name="role"
                                        class="pl-10 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm h-11 bg-white">
                                        @foreach (['Admin', 'TU', 'Guru', 'Siswa'] as $role)
                                            <option value="{{ $role }}"
                                                {{ $user->role == $role ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Perhatian: Mengubah role dapat memengaruhi hak akses user ini.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex flex-col-reverse md:flex-row justify-end items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}"
                                class="w-full md:w-auto text-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-sm">
                                Batal
                            </a>
                            <button type="submit"
                                class="w-full md:w-auto px-6 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md flex justify-center items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
