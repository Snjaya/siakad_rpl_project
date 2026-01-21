<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Data Siswa') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- PERHATIKAN: Action mengarah ke route update dengan menyertakan ID siswa --}}
                <form method="POST" action="{{ route('tu.students.update', $student->id) }}">
                    @csrf
                    {{-- FIX UTAMA: Tambahkan @method('PUT') agar dikenali sebagai request update --}}
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- NIS (Readonly: Karena NIS terhubung ke username login, sebaiknya tidak diubah sembarangan) --}}
                        <div>
                            <x-input-label for="nis" :value="__('NIS')" />
                            <x-text-input id="nis" class="block mt-1 w-full bg-gray-100 cursor-not-allowed"
                                type="number" name="nis" :value="old('nis', $student->nis)" readonly />
                            <p class="text-xs text-gray-500 mt-1">*NIS tidak dapat diubah</p>
                        </div>

                        <div>
                            <x-input-label for="nama_siswa" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_siswa" class="block mt-1 w-full" type="text" name="nama_siswa"
                                :value="old('nama_siswa', $student->nama_siswa)" required />
                        </div>

                        {{-- Email saya buat readonly karena Controller update Anda belum menangani perubahan email di tabel User --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            {{-- Ambil email dari relasi user jika ada --}}
                            <x-text-input id="email" class="block mt-1 w-full bg-gray-100" type="email"
                                name="email" :value="$student->user->email ?? '-'" readonly disabled />
                            <p class="text-xs text-gray-500 mt-1">*Email login dikelola terpisah</p>
                        </div>

                        <div>
                            <x-input-label for="id_kelas" :value="__('Kelas')" />
                            <select id="id_kelas" name="id_kelas"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($classrooms as $kelas)
                                    {{-- Logika Selected: Jika ID kelas sama dengan data siswa, maka pilih --}}
                                    <option value="{{ $kelas->id }}"
                                        {{ old('id_kelas', $student->id_kelas) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }} (Tk. {{ $kelas->tingkat }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_kelas')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date"
                                name="tanggal_lahir" :value="old('tanggal_lahir', $student->tanggal_lahir)" required />
                        </div>

                        <div>
                            <x-input-label for="no_hp" :value="__('Nomor HP (Opsional)')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                :value="old('no_hp', $student->no_hp)" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm h-24">{{ old('alamat', $student->alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('tu.students.index') }}" class="mr-4 text-gray-600">Batal</a>
                        <x-primary-button>Perbarui Data</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
