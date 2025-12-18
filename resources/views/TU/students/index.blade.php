<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Data Siswa') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @foreach (['success', 'info', 'error'] as $msg)
                @if (session($msg))
                    <div
                        class="mb-4 px-4 py-3 rounded relative {{ $msg == 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ session($msg) }}
                    </div>
                @endif
            @endforeach

            <div class="mb-4 text-right">
                <a href="{{ route('tu.students.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Daftar Siswa Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border-collapse w-full">
                        <thead>
                            <tr class="bg-slate-100 text-left uppercase text-sm font-semibold text-slate-600">
                                <th class="p-3">NIS</th>
                                <th class="p-3">Nama Siswa</th>
                                <th class="p-3">Kelas</th>
                                <th class="p-3">Akun Email</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($students as $student)
                                <tr class="border-b border-gray-200 hover:bg-slate-50">
                                    <td class="p-3 font-medium">{{ $student->nis }}</td>
                                    <td class="p-3">{{ $student->nama_siswa }}</td>
                                    <td class="p-3">
                                        <span
                                            class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-bold">
                                            {{ $student->classroom->nama_kelas ?? 'Tanpa Kelas' }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ $student->user->email ?? '-' }}</td>
                                    <td class="p-3 text-center flex justify-center gap-2">
                                        <a href="{{ route('tu.students.edit', $student->nis) }}"
                                            class="text-yellow-600 hover:text-yellow-800">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('tu.students.destroy', $student->nis) }}" method="POST"
                                            onsubmit="return confirm('Hapus siswa ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
