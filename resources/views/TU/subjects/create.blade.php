<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-plus-circle mr-2 text-emerald-600"></i>
            {{ __('Tambah Mata Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">

                    <form action="{{ route('tu.subjects.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran</label>
                                <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                                    placeholder="Contoh: Pemrograman Web">
                                @error('nama_mapel')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nilai KKM (Kriteria
                                    Ketuntasan Minimal)</label>
                                <div class="relative w-32">
                                    <input type="number" name="kkm" value="{{ old('kkm', 75) }}" min="0"
                                        max="100"
                                        class="w-full text-center rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition">
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Range nilai: 0 - 100</p>
                                @error('kkm')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                            <a href="{{ route('tu.subjects.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-md hover:shadow-lg transition font-bold flex items-center gap-2">
                                <i class="fa-solid fa-save"></i>
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
