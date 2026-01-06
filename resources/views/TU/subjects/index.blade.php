<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Mata Pelajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div class="mb-4 bg-blue-100 text-blue-700 p-3 rounded">{{ session('info') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="mb-4 text-right">
                <a href="{{ route('tu.subjects.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">+ Tambah
                    Mapel</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full border-collapse w-full">
                    <thead>
                        <tr class="bg-slate-100 text-left text-sm font-semibold text-slate-600">
                            <th class="p-3">Nama Mata Pelajaran</th>
                            <th class="p-3">KKM</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($subjects as $subject)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="p-3 font-medium">{{ $subject->nama_mapel }}</td>
                                <td class="p-3">{{ $subject->kkm }}</td>
                                <td class="p-3 text-center flex justify-center gap-2">
                                    <a href="{{ route('tu.subjects.edit', $subject->id_mapel) }}"
                                        class="text-yellow-600"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('tu.subjects.destroy', $subject->id_mapel) }}" method="POST"
                                        onsubmit="return confirm('Hapus mapel ini?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center">Belum ada mata pelajaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
