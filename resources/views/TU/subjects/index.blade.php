<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-book-open mr-2 text-emerald-600"></i>
                {{ __('Data Mata Pelajaran') }}
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
                        Total Mapel: <span class="text-emerald-600 font-bold text-lg">{{ $subjects->total() }}</span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
                        <a href="{{ route('tu.subjects.create') }}"
                            class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span>Tambah Mapel</span>
                        </a>
                    </div>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                                <th class="p-4 w-16 text-center">#</th>
                                <th class="p-4">Nama Mata Pelajaran</th>
                                <th class="p-4 w-32 text-center">KKM</th>
                                <th class="p-4 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($subjects as $index => $subject)
                                <tr class="hover:bg-emerald-50/30 transition duration-150 group">
                                    <td class="p-4 text-center text-gray-400 font-medium">
                                        {{ $subjects->firstItem() + $index }}
                                    </td>
                                    <td class="p-4 font-bold text-gray-800 text-base">
                                        {{ $subject->nama_mapel }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-full font-bold text-sm bg-blue-50 text-blue-600 border border-blue-100">
                                            {{ $subject->kkm }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('tu.subjects.edit', $subject->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 border border-yellow-200 transition"
                                                title="Edit Mapel">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('tu.subjects.destroy', $subject->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus Mata Pelajaran {{ $subject->nama_mapel }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 border border-red-200 transition"
                                                    title="Hapus Mapel">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-400 bg-slate-50">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-book text-4xl mb-3 text-gray-300"></i>
                                            <p>Belum ada data mata pelajaran.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden grid grid-cols-1 gap-4 p-4 bg-slate-50">
                    @forelse($subjects as $subject)
                        <div
                            class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden flex justify-between items-center">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-xl"></div>

                            <div class="pl-2">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $subject->nama_mapel }}</h3>
                                <p class="text-xs text-gray-500 mt-1">Standar KKM: <span
                                        class="font-bold text-blue-600">{{ $subject->kkm }}</span></p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('tu.subjects.edit', $subject->id) }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-50 text-yellow-600 border border-yellow-200 shadow-sm">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('tu.subjects.destroy', $subject->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus mapel ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-red-50 text-red-600 border border-red-200 shadow-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-6 text-gray-500">
                            Belum ada data mapel.
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-gray-100 bg-white">
                    {{ $subjects->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
