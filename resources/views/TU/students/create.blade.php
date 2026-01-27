<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pendaftaran Siswa Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tu.students.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bagian NIS, Nama, Email, Kelas, Tanggal Lahir (SAMA SEPERTI SEBELUMNYA) --}}
                        <div>
                            <x-input-label for="nis" :value="__('NIS (Nomor Induk Siswa)')" />
                            <x-text-input id="nis" class="block mt-1 w-full" type="number" name="nis"
                                :value="old('nis')" required autofocus />
                            <p class="text-xs text-gray-500 mt-1">*Jadi Username Login</p>
                            <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_siswa" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_siswa" class="block mt-1 w-full" type="text" name="nama_siswa"
                                :value="old('nama_siswa')" required />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email (Untuk Login)')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_kelas" :value="__('Pilih Kelas')" />
                            <select id="id_kelas" name="id_kelas"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($classrooms as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ old('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }} (Tk. {{ $kelas->tingkat }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_kelas')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date"
                                name="tanggal_lahir" :value="old('tanggal_lahir')" required />
                        </div>

                        {{-- PERUBAHAN DI SINI: NOMOR HP --}}
                        <div>
                            {{-- Tambahkan teks (Opsional) --}}
                            <x-input-label for="no_hp" :value="__('Nomor HP (Opsional)')" />

                            {{-- HAPUS atribut 'required' di bawah ini --}}
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                                :value="old('no_hp')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm h-24">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('tu.students.index') }}" class="mr-4 text-gray-600">Batal</a>
                        <x-primary-button>Simpan Siswa</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
