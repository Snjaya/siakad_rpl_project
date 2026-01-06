<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Jadwal Pelajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                {{-- Tampilkan Error Validasi (Misal Bentrok) --}}
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('tu.schedules.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="id_kelas" :value="__('Kelas')" />
                            <select name="id_kelas" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($classrooms as $c)
                                    <option value="{{ $c->id_kelas }}">{{ $c->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="hari" :value="__('Hari')" />
                            <select name="hari" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                    <option value="{{ $hari }}">{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="id_mapel" :value="__('Mata Pelajaran')" />
                        <select name="id_mapel" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach ($subjects as $s)
                                <option value="{{ $s->id_mapel }}">{{ $s->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="nip_teacher" :value="__('Guru Pengampu')" />
                        <select id="nip_teacher" name="nip_teacher"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($teachers as $guru)
                                <option value="{{ $guru->nip }}">{{ $guru->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="jam_mulai" :value="__('Jam Mulai')" />
                            <input type="time" name="jam_mulai"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="jam_selesai" :value="__('Jam Selesai')" />
                            <input type="time" name="jam_selesai"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('tu.schedules.index') }}" class="mr-4 text-gray-600 py-2">Batal</a>
                        <x-primary-button>Simpan Jadwal</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
