<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Data Kelas') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi Flash Message --}}
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
                <a href="{{ route('tu.classrooms.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Tambah Kelas
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border-collapse w-full">
                        <thead>
                            <tr class="bg-slate-100 text-left uppercase text-sm font-semibold text-slate-600">
                                <th class="p-3">Tingkat</th>
                                <th class="p-3">Nama Kelas</th>
                                <th class="p-3">Wali Kelas</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($classrooms as $class)
                                <tr class="border-b border-gray-200 hover:bg-slate-50">
                                    <td class="p-3">
                                        <span
                                            class="bg-gray-200 px-2 py-1 rounded text-xs font-bold">{{ $class->tingkat }}</span>
                                    </td>
                                    <td class="p-3 font-medium">{{ $class->nama_kelas }}</td>
                                    <td class="p-3">
                                        {{ $class->teacher->nama_guru ?? 'Belum ada Wali Kelas' }}
                                        <span class="text-xs text-gray-400 block">{{ $class->nip_teacher }}</span>
                                    </td>
                                    <td class="p-3 text-center flex justify-center gap-2">
                                        <a href="{{ route('tu.classrooms.edit', $class->id_kelas) }}"
                                            class="text-yellow-600 hover:text-yellow-800">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('tu.classrooms.destroy', $class->id_kelas) }}"
                                            method="POST" onsubmit="return confirm('Hapus kelas ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400">Belum ada data kelas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
