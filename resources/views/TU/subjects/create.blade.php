<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Mata Pelajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('tu.subjects.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="nama_mapel" :value="__('Nama Mata Pelajaran')" />
                        <x-text-input id="nama_mapel" class="block mt-1 w-full" type="text" name="nama_mapel" required
                            autofocus />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="kkm" :value="__('Nilai KKM (0-100)')" />
                        <x-text-input id="kkm" class="block mt-1 w-full" type="number" name="kkm" required
                            min="0" max="100" />
                    </div>
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('tu.subjects.index') }}" class="mr-4 text-gray-600 py-2">Batal</a>
                        <x-primary-button>Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
