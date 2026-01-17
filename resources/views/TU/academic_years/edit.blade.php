<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pen-to-square mr-2 text-emerald-600"></i>
            Edit Tahun Ajaran
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('tu.academic_years.update', $academicYear->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran"
                                value="{{ old('tahun_ajaran', $academicYear->tahun_ajaran) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                            @error('tahun_ajaran')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                            <select name="semester"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                                <option value="Ganjil" {{ $academicYear->semester == 'Ganjil' ? 'selected' : '' }}>
                                    Ganjil</option>
                                <option value="Genap" {{ $academicYear->semester == 'Genap' ? 'selected' : '' }}>Genap
                                </option>
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                                <option value="Tidak Aktif"
                                    {{ $academicYear->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="Aktif" {{ $academicYear->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                </option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('tu.academic_years.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Batal</a>
                            <button type="submit"
                                class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
