<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reset Password: ') . $user->username }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <p class="mb-4 text-sm text-gray-600">Masukkan password baru untuk user ini.</p>
                <form method="POST" action="{{ route('admin.users.update-password', $user) }}">
                    @csrf @method('PATCH')

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password Baru')" />
                        <x-text-input id="password" type="password" name="password" class="block mt-1 w-full"
                            required />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                            class="block mt-1 w-full" required />
                    </div>

                    <x-primary-button class="w-full justify-center">Simpan Password Baru</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
