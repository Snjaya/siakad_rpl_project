<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-id-card text-emerald-600"></i>
            {{ __('Profil Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm"
                    role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-3">

                    {{-- KOLOM KIRI: FOTO PROFIL --}}
                    <div
                        class="p-8 bg-slate-50 text-center border-r border-gray-100 flex flex-col items-center justify-center">
                        <div class="relative inline-block mb-4">
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                                    class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-md">
                            @else
                                <div
                                    class="w-40 h-40 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 border-4 border-white shadow-md">
                                    <i class="fa-solid fa-user-graduate text-6xl"></i>
                                </div>
                            @endif

                            {{-- Tombol Upload --}}
                            <label for="foto"
                                class="absolute bottom-2 right-2 bg-emerald-600 text-white p-2 rounded-full cursor-pointer hover:bg-emerald-700 shadow-lg transition transform hover:scale-110"
                                title="Ganti Foto">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                        </div>
                        <p class="text-sm font-bold text-gray-700">{{ $student->nama_siswa }}</p>
                        <p class="text-xs text-gray-500">{{ $student->nis }}</p>
                    </div>

                    {{-- KOLOM KANAN: FORM DATA --}}
                    <div class="p-8 col-span-2 space-y-6">

                        {{-- BAGIAN 1: DATA AKADEMIK (READ ONLY) --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-gray-400"></i> Data Akademik (Tetap)
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama
                                        Lengkap</label>
                                    <input type="text" value="{{ $student->nama_siswa }}"
                                        class="w-full bg-gray-100 text-gray-600 border-gray-200 rounded-lg cursor-not-allowed"
                                        disabled>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">NIS /
                                        NISN</label>
                                    <input type="text" value="{{ $student->nis }}"
                                        class="w-full bg-gray-100 text-gray-600 border-gray-200 rounded-lg cursor-not-allowed"
                                        disabled>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kelas</label>
                                    {{-- PERBAIKAN: Gunakan $student->kelas --}}
                                    <input type="text" value="{{ $student->kelas->nama_kelas ?? '-' }}"
                                        class="w-full bg-gray-100 text-gray-600 border-gray-200 rounded-lg cursor-not-allowed"
                                        disabled>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jurusan</label>
                                    {{-- PERBAIKAN: Gunakan $student->kelas --}}
                                    <input type="text" value="{{ $student->kelas->jurusan ?? '-' }}"
                                        class="w-full bg-gray-100 text-gray-600 border-gray-200 rounded-lg cursor-not-allowed"
                                        disabled>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 2: DATA PRIBADI (EDITABLE) --}}
                        <div>
                            <h3
                                class="text-lg font-bold text-emerald-600 border-b border-emerald-100 pb-2 mb-4 mt-6 flex items-center gap-2">
                                <i class="fa-solid fa-pen-to-square"></i> Data Pribadi (Dapat Diubah)
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                        Handphone (WhatsApp)</label>
                                    <input type="text" name="no_hp" id="no_hp"
                                        value="{{ old('no_hp', $student->no_hp) }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition"
                                        placeholder="Contoh: 0812xxx">
                                    @error('no_hp')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                        Domisili</label>
                                    <textarea name="alamat" id="alamat" rows="3"
                                        class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition"
                                        placeholder="Alamat lengkap...">{{ old('alamat', $student->alamat) }}</textarea>
                                    @error('alamat')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-save mr-2"></i> Simpan Profil
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
