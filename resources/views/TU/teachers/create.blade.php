<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-user-plus mr-2 text-emerald-600"></i>
            {{ __('Tambah Guru Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">

                    <form action="{{ route('tu.teachers.store') }}" method="POST">
                        @csrf

                        <div class="mb-8">
                            <h3
                                class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                                <span
                                    class="bg-emerald-100 text-emerald-600 rounded-full w-8 h-8 flex items-center justify-center text-sm">1</span>
                                Informasi Akun & Kepegawaian
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP (Nomor Induk
                                        Pegawai)</label>
                                    <input type="number" name="nip" value="{{ old('nip') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                        placeholder="Contoh: 19850101...">
                                    @error('nip')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (dengan
                                        Gelar)</label>
                                    <input type="text" name="nama_guru" value="{{ old('nama_guru') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                        placeholder="Contoh: Drs. H. Asep Sunandar">
                                    @error('nama_guru')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="w-full pl-10 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                            placeholder="guru@smkmarhas.sch.id">
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-1">Digunakan untuk login. Password default:
                                        <b>guru123</b></p>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </span>
                                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                            class="w-full pl-10 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                            placeholder="0812...">
                                    </div>
                                    @error('no_hp')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3
                                class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 pb-2 border-b border-gray-100">
                                <span
                                    class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-sm">2</span>
                                Biodata Pribadi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition">
                                    @error('tempat_lahir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition">
                                    @error('tanggal_lahir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <select name="jenis_kelamin"
                                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition">
                                        <option value="">Pilih...</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                    <textarea name="alamat" rows="3"
                                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                        placeholder="Nama Jalan, No. Rumah, RT/RW, Kecamatan...">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('tu.teachers.index') }}"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-lg hover:shadow-xl transition font-bold flex items-center gap-2">
                                <i class="fa-solid fa-save"></i>
                                Simpan Data Guru
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
