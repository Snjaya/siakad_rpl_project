<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Tahun Ajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('tu.academic_years.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="tahun_ajaran" :value="__('Tahun Ajaran (Contoh: 2024/2025)')" />
                        <x-text-input id="tahun_ajaran" class="block mt-1 w-full" type="text" name="tahun_ajaran"
                            required placeholder="2024/2025" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="semester" :value="__('Semester')" />
                        <select name="semester" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="flex justify-end mt-6">
                        <x-primary-button>Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
