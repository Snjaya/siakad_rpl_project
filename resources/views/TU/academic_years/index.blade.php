<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-calendar-days mr-2 text-emerald-600"></i>
                {{ __('Data Tahun Ajaran') }}
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
                    <div class="text-gray-500 text-sm font-medium">
                        Total Periode: <span
                            class="text-emerald-600 font-bold text-lg">{{ $academicYears->total() }}</span>
                    </div>

                    <a href="{{ route('tu.academic_years.create') }}"
                        class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-sm"></i>
                        <span>Tambah Periode</span>
                    </a>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                                <th class="p-4 w-16 text-center">#</th>
                                <th class="p-4">Tahun Ajaran</th>
                                <th class="p-4">Semester</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($academicYears as $index => $year)
                                <tr
                                    class="hover:bg-emerald-50/30 transition duration-150 {{ $year->status == 'Aktif' ? 'bg-emerald-50/40' : '' }}">
                                    <td class="p-4 text-center text-gray-400 font-medium">
                                        {{ $academicYears->firstItem() + $index }}</td>
                                    <td class="p-4 font-bold text-gray-800 text-lg">{{ $year->tahun_ajaran }}</td>
                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $year->semester == 'Ganjil' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ $year->semester }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if ($year->status == 'Aktif')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm animate-pulse">
                                                <i class="fa-solid fa-circle-check"></i> AKTIF
                                            </span>
                                        @else
                                            <form action="{{ route('tu.academic_years.active', $year->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-emerald-600 text-xs font-medium border border-gray-300 hover:border-emerald-500 px-3 py-1 rounded-full transition"
                                                    title="Klik untuk mengaktifkan">
                                                    Set Aktif
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('tu.academic_years.edit', $year->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            @if ($year->status != 'Aktif')
                                                <form action="{{ route('tu.academic_years.destroy', $year->id) }}"
                                                    method="POST" onsubmit="return confirm('Hapus periode ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden grid grid-cols-1 gap-4 p-4 bg-slate-50">
                    @foreach ($academicYears as $year)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <div
                                class="absolute left-0 top-0 bottom-0 w-1.5 {{ $year->status == 'Aktif' ? 'bg-green-500' : 'bg-gray-300' }} rounded-l-xl">
                            </div>

                            <div class="flex justify-between items-start mb-2 pl-2">
                                <h3 class="font-bold text-gray-800 text-xl">{{ $year->tahun_ajaran }}</h3>
                                @if ($year->status == 'Aktif')
                                    <span
                                        class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded">AKTIF</span>
                                @else
                                    <form action="{{ route('tu.academic_years.active', $year->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button
                                            class="text-xs border border-gray-300 px-2 py-1 rounded hover:bg-emerald-50 hover:text-emerald-600 transition">Aktifkan</button>
                                    </form>
                                @endif
                            </div>

                            <div class="pl-2 text-sm text-gray-600 mb-4">
                                Semester: <span class="font-medium">{{ $year->semester }}</span>
                            </div>

                            <div class="flex gap-2 pl-2">
                                <a href="{{ route('tu.academic_years.edit', $year->id) }}"
                                    class="flex-1 py-2 text-center rounded-lg bg-yellow-50 text-yellow-700 text-sm font-semibold border border-yellow-200">Edit</a>
                                @if ($year->status != 'Aktif')
                                    <form action="{{ route('tu.academic_years.destroy', $year->id) }}" method="POST"
                                        class="flex-1" onsubmit="return confirm('Hapus?');">
                                        @csrf @method('DELETE')
                                        <button
                                            class="w-full py-2 text-center rounded-lg bg-red-50 text-red-700 text-sm font-semibold border border-red-200">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
