<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Kelas Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tu.classrooms.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="tingkat" :value="__('Tingkat Kelas')" />
                        <select id="tingkat" name="tingkat"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="10">Kelas 10 (X)</option>
                            <option value="11">Kelas 11 (XI)</option>
                            <option value="12">Kelas 12 (XII)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="nama_kelas" :value="__('Nama Kelas (Contoh: X RPL 1)')" />
                        <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas"
                            required placeholder="e.g. X RPL 1" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="nip_teacher" :value="__('Pilih Wali Kelas')" />
                        <select id="nip_teacher" name="nip_teacher"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($teachers as $guru)
                                <option value="{{ $guru->nip }}">{{ $guru->nama_guru }} ({{ $guru->nip }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Data diambil dari Menu Data Guru.</p>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('tu.classrooms.index') }}"
                            class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                        <x-primary-button>Simpan Kelas</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
