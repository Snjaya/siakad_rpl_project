<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-key mr-2 text-emerald-600"></i>
            {{ __('Reset Password User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">

                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded text-blue-700 text-sm">
                        Anda sedang mereset password untuk akun: <br>
                        <strong>Username:</strong> {{ $user->username }} <br>
                        <strong>Email:</strong> {{ $user->email }}
                    </div>

                    <form action="{{ route('admin.users.password.update', $user->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="password"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition"
                                    placeholder="Masukkan password baru...">
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 transition"
                                    placeholder="Ulangi password baru...">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Batal</a>
                            <button type="submit"
                                class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition shadow-md">
                                <i class="fa-solid fa-save mr-1"></i> Simpan Password Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
