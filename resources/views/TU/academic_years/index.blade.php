<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Tahun Ajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    {{ session('info') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}
                </div>
            @endif

            <div class="mb-4 text-right">
                <a href="{{ route('tu.academic_years.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Tambah Tahun Ajaran
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border-collapse w-full">
                        <thead>
                            <tr class="bg-slate-100 text-left uppercase text-sm font-semibold text-slate-600">
                                <th class="p-3">Tahun Ajaran</th>
                                <th class="p-3">Semester</th>
                                <th class="p-3 text-center">Status</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($academicYears as $ay)
                                <tr
                                    class="border-b border-gray-200 hover:bg-slate-50 {{ $ay->status_aktif == 'Aktif' ? 'bg-green-50' : '' }}">
                                    <td class="p-3 font-medium">{{ $ay->tahun_ajaran }}</td>
                                    <td class="p-3">{{ $ay->semester }}</td>
                                    <td class="p-3 text-center">
                                        @if ($ay->status_aktif == 'Aktif')
                                            <span
                                                class="bg-green-200 text-green-800 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                <i class="fa-solid fa-check-circle mr-1"></i> AKTIF
                                            </span>
                                        @else
                                            <form action="{{ route('tu.academic_years.active', $ay->id_tahun) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="bg-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full hover:bg-green-200 hover:text-green-800 transition">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center flex justify-center gap-2">
                                        <a href="{{ route('tu.academic_years.edit', $ay->id_tahun) }}"
                                            class="text-yellow-600 hover:text-yellow-800">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        {{-- Tombol Hapus hanya jika TIDAK AKTIF --}}
                                        @if ($ay->status_aktif == 'Tidak Aktif')
                                            <form action="{{ route('tu.academic_years.destroy', $ay->id_tahun) }}"
                                                method="POST" onsubmit="return confirm('Hapus Tahun Ajaran ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-300 cursor-not-allowed" title="Sedang Aktif"><i
                                                    class="fa-solid fa-trash"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400">Belum ada data tahun
                                        ajaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
