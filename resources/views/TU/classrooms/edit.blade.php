<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pen-to-square mr-2 text-emerald-600"></i>
            Edit Kelas: {{ $classroom->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">

                    <form action="{{ route('tu.classrooms.update', $classroom->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                                <input type="text" name="nama_kelas"
                                    value="{{ old('nama_kelas', $classroom->nama_kelas) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                    placeholder="Contoh: X TKI 1">
                                @error('nama_kelas')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                                <select name="tingkat"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition">
                                    <option value="10"
                                        {{ old('tingkat', $classroom->tingkat) == '10' ? 'selected' : '' }}>Kelas 10
                                    </option>
                                    <option value="11"
                                        {{ old('tingkat', $classroom->tingkat) == '11' ? 'selected' : '' }}>Kelas 11
                                    </option>
                                    <option value="12"
                                        {{ old('tingkat', $classroom->tingkat) == '12' ? 'selected' : '' }}>Kelas 12
                                    </option>
                                </select>
                                @error('tingkat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan / Kompetensi</label>
                                <input type="text" name="jurusan" value="{{ old('jurusan', $classroom->jurusan) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                    placeholder="Contoh: Teknik Pemesinan">
                                @error('jurusan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                                <select name="nip_teacher"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition">
                                    <option value="">-- Pilih Guru Wali Kelas --</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->nip }}"
                                            {{ old('nip_teacher', $classroom->nip_teacher) == $teacher->nip ? 'selected' : '' }}>
                                            {{ $teacher->nama_guru }} (NIP: {{ $teacher->nip }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-400 mt-1">Ubah jika ada pergantian wali kelas.</p>
                                @error('nip_teacher')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                            <a href="{{ route('tu.classrooms.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-md hover:shadow-lg transition font-bold flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Update Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
