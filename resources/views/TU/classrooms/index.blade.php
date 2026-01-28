<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-chalkboard-user mr-2 text-emerald-600"></i>
                {{ __('Kelola Data Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
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

                {{-- HEADER TOOLS: Search & Add --}}
                <div class="p-6 border-b border-gray-100 bg-white">
                    <form method="GET" action="{{ route('tu.classrooms.index') }}"
                        class="flex flex-col md:flex-row justify-between items-center gap-4">

                        {{-- Kiri: Total & Search --}}
                        <div class="w-full md:w-auto flex flex-col md:flex-row gap-4 items-center">
                            <div class="text-gray-500 text-sm font-medium whitespace-nowrap">
                                Total Kelas: <span
                                    class="text-emerald-600 font-bold text-lg">{{ $classrooms->count() }}</span>
                            </div>

                            <div class="relative w-full md:w-72">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="w-full py-2 pl-10 pr-4 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
                                    placeholder="Cari nama kelas atau jurusan...">
                            </div>
                        </div>

                        {{-- Kanan: Tombol Aksi --}}
                        <div class="flex flex-row gap-2 w-full md:w-auto">
                            <a href="{{ route('tu.classrooms.create') }}"
                                class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm hover:shadow transition flex items-center justify-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span>Tambah Kelas</span>
                            </a>
                        </div>
                    </form>
                </div>

                {{-- TABLE DESKTOP --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                                <th class="p-4 w-16 text-center">#</th>
                                <th class="p-4">Nama Kelas</th>
                                <th class="p-4">Jurusan</th>
                                <th class="p-4">Tingkat</th>
                                <th class="p-4">Wali Kelas</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($classrooms as $index => $classroom)
                                <tr class="hover:bg-emerald-50/30 transition duration-150 group">
                                    <td class="p-4 text-center text-gray-400 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="font-bold text-gray-800 text-base group-hover:text-emerald-600 transition">
                                            {{ $classroom->nama_kelas }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-600 font-medium">
                                        {{ $classroom->jurusan }}
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                            TK {{ $classroom->tingkat }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if ($classroom->teacher)
                                            <div class="flex items-center gap-2 text-emerald-700 font-semibold">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                                    <i class="fa-solid fa-user-tie text-xs"></i>
                                                </div>
                                                {{ $classroom->teacher->nama_guru }}
                                            </div>
                                        @else
                                            <span
                                                class="text-orange-400 italic text-xs flex items-center gap-1 bg-orange-50 px-2 py-1 rounded-md border border-orange-100 inline-flex">
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                                Belum diset
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('tu.classrooms.edit', $classroom->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 border border-yellow-200 transition"
                                                title="Edit Kelas">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('tu.classrooms.destroy', $classroom->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus kelas {{ $classroom->nama_kelas }}? Perhatian: Siswa di kelas ini akan kehilangan status kelasnya!');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 border border-red-200 transition"
                                                    title="Hapus Kelas">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-gray-400 bg-slate-50">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-school text-5xl mb-3 text-gray-300"></i>
                                            <p class="text-lg font-medium">Belum ada data kelas ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE CARDS --}}
                <div class="md:hidden grid grid-cols-1 gap-4 p-4 bg-slate-50">
                    @forelse($classrooms as $classroom)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-xl"></div>

                            <div class="flex justify-between items-start mb-3 pl-2">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $classroom->nama_kelas }}</h3>
                                    <p class="text-xs text-gray-500 font-semibold">{{ $classroom->jurusan }}</p>
                                </div>
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded border border-blue-200">
                                    Tk. {{ $classroom->tingkat }}
                                </span>
                            </div>

                            <div class="space-y-2 mb-4 pl-2 text-sm text-gray-600 border-t border-gray-50 pt-3">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user-tie text-gray-400 w-4 text-center"></i>
                                    <span
                                        class="{{ $classroom->teacher ? 'text-emerald-700 font-medium' : 'text-orange-500 italic text-xs' }}">
                                        {{ $classroom->teacher->nama_guru ?? 'Wali Kelas Belum Diset' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-2 pl-2">
                                <a href="{{ route('tu.classrooms.edit', $classroom->id) }}"
                                    class="flex-1 py-2 text-center rounded-lg bg-yellow-50 text-yellow-700 text-sm font-semibold hover:bg-yellow-100 border border-yellow-200 transition">
                                    <i class="fa-solid fa-pen mr-1"></i> Edit
                                </a>
                                <form action="{{ route('tu.classrooms.destroy', $classroom->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('Hapus kelas ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-2 text-center rounded-lg bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 border border-red-200 transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-6 text-gray-500 bg-white rounded-xl shadow-sm">
                            Belum ada data kelas.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
