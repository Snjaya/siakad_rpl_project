<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Data Siswa') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tu.students.update', $student->nis) }}">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="nis" :value="__('NIS')" />
                            <x-text-input id="nis" class="block mt-1 w-full bg-gray-100 text-gray-500"
                                type="text" :value="$student->nis" readonly />
                        </div>

                        <div>
                            <x-input-label for="nama_siswa" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_siswa" class="block mt-1 w-full" type="text" name="nama_siswa"
                                :value="old('nama_siswa', $student->nama_siswa)" required />
                        </div>

                        <div>
                            <x-input-label for="id_kelas" :value="__('Pilih Kelas')" />
                            <select id="id_kelas" name="id_kelas"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($classrooms as $kelas)
                                    <option value="{{ $kelas->id_kelas }}"
                                        {{ $student->id_kelas == $kelas->id_kelas ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date"
                                name="tanggal_lahir" :value="old('tanggal_lahir', $student->tanggal_lahir)" required />
                        </div>
                        <div>
                            <x-input-label for="no_hp" :value="__('Nomor HP')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                :value="old('no_hp', $student->no_hp)" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm h-24">{{ old('alamat', $student->alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('tu.students.index') }}" class="mr-4 text-gray-600">Batal</a>
                        <x-primary-button>Update Data</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
