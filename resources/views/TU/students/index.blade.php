<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-users-viewfinder mr-2 text-emerald-600"></i>
                {{ __('Kelola Data Siswa') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @foreach (['success', 'info', 'error'] as $msg)
                @if (session($msg))
                    <div x-data="{ show: true }" x-show="show"
                        class="mb-6 px-4 py-4 rounded-lg shadow-sm border-l-4 flex justify-between items-center
                         {{ $msg == 'error' ? 'bg-red-50 text-red-700 border-red-500' : ($msg == 'info' ? 'bg-blue-50 text-blue-700 border-blue-500' : 'bg-emerald-50 text-emerald-700 border-emerald-500') }}">
                        <div class="flex items-center gap-3">
                            <i
                                class="fa-solid {{ $msg == 'error' ? 'fa-circle-exclamation' : 'fa-circle-check' }} text-lg"></i>
                            <span class="font-medium">{{ session($msg) }}</span>
                        </div>
                        <button @click="show = false" class="text-sm opacity-50 hover:opacity-100 transition"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
            @endforeach

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">

                <div
                    class="p-6 border-b border-gray-100 bg-white flex flex-col md:flex-row justify-between items-center gap-4">

                    <div class="text-gray-500 text-sm font-medium w-full md:w-auto">
                        Total Siswa: <span class="text-emerald-600 font-bold text-lg">{{ $students->total() }}</span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">

                        <div class="relative w-full md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text"
                                class="w-full py-2 pl-10 pr-4 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
                                placeholder="Cari nama atau NIS...">
                        </div>

                        <a href="{{ route('tu.students.create') }}"
                            class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span>Daftar Siswa</span>
                        </a>

                    </div>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                                <th class="p-4 w-20 text-center">#</th>
                                <th class="p-4">Identitas Siswa</th>
                                <th class="p-4">Kelas & Jurusan</th>
                                <th class="p-4">Kontak / Akun</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($students as $index => $student)
                                <tr class="hover:bg-emerald-50/30 transition duration-150 group">
                                    <td class="p-4 text-center text-gray-400 font-medium">
                                        {{ $students->firstItem() + $index }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-gray-800 text-base group-hover:text-emerald-600 transition">{{ $student->nama_siswa }}</span>
                                            <span class="text-xs text-gray-400">NIS: {{ $student->nis }}</span>
                                            @if ($student->jenis_kelamin)
                                                <span class="text-[10px] mt-1 text-gray-400">
                                                    <i
                                                        class="fa-solid {{ $student->jenis_kelamin == 'L' ? 'fa-mars text-blue-400' : 'fa-venus text-pink-400' }}"></i>
                                                    {{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        @if ($student->kelas)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-chalkboard-user"></i>
                                                {{ $student->kelas->nama_kelas }}
                                            </span>
                                            <div class="text-[10px] text-gray-400 mt-1 ml-1 truncate max-w-[150px]">
                                                {{ $student->kelas->jurusan }}
                                            </div>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                                Belum Masuk Kelas
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="text-gray-600 flex items-center gap-2">
                                                <i class="fa-regular fa-envelope text-gray-400 text-xs"></i>
                                                <span>{{ $student->user->email ?? 'Email tidak ada' }}</span>
                                            </div>
                                            <div class="text-gray-600 flex items-center gap-2">
                                                <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                                                <span>{{ $student->no_hp ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('tu.students.edit', $student->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 border border-yellow-200 transition"
                                                title="Edit Data">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('tu.students.destroy', $student->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa {{ $student->nama_siswa }}? Akun login juga akan terhapus.');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 border border-red-200 transition"
                                                    title="Hapus Siswa">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 bg-slate-50">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                            <p>Belum ada data siswa yang terdaftar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden grid grid-cols-1 gap-4 p-4 bg-slate-50">
                    @forelse($students as $student)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-xl"></div>

                            <div class="flex justify-between items-start mb-3 pl-2">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $student->nama_siswa }}</h3>
                                    <p class="text-xs text-gray-400 font-mono tracking-wide">NIS: {{ $student->nis }}
                                    </p>
                                </div>
                                @if ($student->kelas)
                                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded">
                                        {{ $student->kelas->nama_kelas }}
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded">
                                        No Class
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2 mb-4 pl-2 text-sm text-gray-600 border-t border-gray-50 pt-3">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-envelope text-gray-400 w-4"></i>
                                    <span class="truncate">{{ $student->user->email ?? '-' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-gray-400 w-4"></i>
                                    <span>{{ $student->no_hp ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="flex gap-2 pl-2">
                                <a href="{{ route('tu.students.edit', $student->id) }}"
                                    class="flex-1 py-2 text-center rounded-lg bg-yellow-50 text-yellow-700 text-sm font-semibold hover:bg-yellow-100 border border-yellow-200 transition">
                                    <i class="fa-solid fa-pen mr-1"></i> Edit
                                </a>
                                <form action="{{ route('tu.students.destroy', $student->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('Hapus siswa ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-2 text-center rounded-lg bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 border border-red-200 transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-6 text-gray-500">
                            Belum ada data siswa.
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-gray-100 bg-white">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
