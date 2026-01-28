<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tu.students.index') }}" class="text-gray-400 hover:text-emerald-600 transition">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-user-plus mr-2 text-emerald-600"></i>
                {{ __('Pendaftaran Siswa Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Error jika Validasi Gagal --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                        <span class="font-bold">Terdapat kesalahan input:</span>
                    </div>
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form method="POST" action="{{ route('tu.students.store') }}" id="formCreate">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            {{-- NIS --}}
                            <div>
                                <x-input-label for="nis" :value="__('NIS (Nomor Induk Siswa)')" class="font-semibold text-gray-700" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-id-card"></i>
                                    </span>
                                    <x-text-input id="nis"
                                        class="block pl-10 w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl"
                                        type="number" name="nis" :value="old('nis')" required autofocus
                                        placeholder="Contoh: 24001" />
                                </div>
                                <p class="text-[10px] text-emerald-600 mt-1 font-medium italic">*NIS akan digunakan
                                    sebagai Username login</p>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div>
                                <x-input-label for="nama_siswa" :value="__('Nama Lengkap')" class="font-semibold text-gray-700" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-user text-sm"></i>
                                    </span>
                                    <x-text-input id="nama_siswa"
                                        class="block pl-10 w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl"
                                        type="text" name="nama_siswa" :value="old('nama_siswa')" required
                                        placeholder="Nama Lengkap Siswa" />
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email (Akun Login)')" class="font-semibold text-gray-700" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-envelope text-sm"></i>
                                    </span>
                                    <x-text-input id="email"
                                        class="block pl-10 w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl"
                                        type="email" name="email" :value="old('email')" required
                                        placeholder="siswa@smkmarhas.sch.id" />
                                </div>
                            </div>

                            {{-- Pilih Kelas --}}
                            <div>
                                <x-input-label for="id_kelas" :value="__('Penempatan Kelas')" class="font-semibold text-gray-700" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-solid fa-school text-sm"></i>
                                    </span>
                                    <select id="id_kelas" name="id_kelas"
                                        class="block pl-10 w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm transition"
                                        required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($classrooms as $kelas)
                                            <option value="{{ $kelas->id }}"
                                                {{ old('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                                {{ $kelas->nama_kelas }} ({{ $kelas->jurusan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" class="font-semibold text-gray-700" />
                                <div class="grid grid-cols-2 gap-4 mt-1">
                                    <label
                                        class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition">
                                        <input type="radio" name="gender" value="L"
                                            {{ old('gender') == 'L' ? 'checked' : '' }}
                                            class="text-blue-600 focus:ring-blue-500" required>
                                        <span class="ml-2 text-sm text-gray-700 font-medium">Laki-laki</span>
                                    </label>
                                    <label
                                        class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-pink-50 hover:border-pink-200 transition">
                                        <input type="radio" name="gender" value="P"
                                            {{ old('gender') == 'P' ? 'checked' : '' }}
                                            class="text-pink-600 focus:ring-pink-500">
                                        <span class="ml-2 text-sm text-gray-700 font-medium">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Nomor HP --}}
                            <div>
                                <x-input-label for="no_hp" :value="__('Nomor HP (WhatsApp)')" class="font-semibold text-gray-700" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fa-brands fa-whatsapp text-lg"></i>
                                    </span>
                                    <x-text-input id="no_hp"
                                        class="block pl-10 w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl"
                                        type="text" name="no_hp" :value="old('no_hp')" placeholder="08xxxxxxxx" />
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat Domisili')" class="font-semibold text-gray-700" />
                                <div class="relative mt-1">
                                    <span class="absolute top-3 left-3 text-gray-400">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </span>
                                    <textarea id="alamat" name="alamat"
                                        class="block pl-10 pt-2 w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm h-28"
                                        placeholder="Masukkan alamat lengkap siswa...">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-4 border-t border-gray-100 pt-8">
                            <a href="{{ route('tu.students.index') }}"
                                class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 transition uppercase tracking-wider">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 transition-all duration-300 transform active:scale-95 flex items-center gap-2 uppercase tracking-widest text-xs">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Loading state saat tombol simpan ditekan
            document.getElementById('formCreate').addEventListener('submit', function() {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Harap tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
