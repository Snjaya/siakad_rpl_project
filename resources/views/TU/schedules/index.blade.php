<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-regular fa-calendar-days mr-2 text-emerald-600"></i>
                {{ __('Jadwal Pelajaran') }}
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
                        Total Jadwal: <span class="text-emerald-600 font-bold text-lg">{{ $schedules->total() }}</span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
                        <a href="{{ route('tu.schedules.create') }}"
                            class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span>Buat Jadwal</span>
                        </a>
                    </div>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-bold border-b border-gray-200">
                                <th class="p-4 w-16 text-center">Hari</th>
                                <th class="p-4">Jam</th>
                                <th class="p-4">Kelas</th>
                                <th class="p-4">Mata Pelajaran</th>
                                <th class="p-4">Guru Pengampu</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($schedules as $schedule)
                                <tr class="hover:bg-emerald-50/30 transition duration-150 group">
                                    <td class="p-4 text-center">
                                        @php
                                            $colors = [
                                                'Senin' => 'bg-red-100 text-red-700',
                                                'Selasa' => 'bg-orange-100 text-orange-700',
                                                'Rabu' => 'bg-yellow-100 text-yellow-700',
                                                'Kamis' => 'bg-green-100 text-green-700',
                                                'Jumat' => 'bg-blue-100 text-blue-700',
                                                'Sabtu' => 'bg-purple-100 text-purple-700',
                                            ];
                                            $colorClass = $colors[$schedule->hari] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-2 py-1 rounded-md text-xs font-bold {{ $colorClass }}">
                                            {{ $schedule->hari }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-mono text-gray-600 text-xs">
                                        {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="font-bold text-gray-800">{{ $schedule->kelas->nama_kelas ?? '-' }}</span>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-emerald-700">
                                            {{ $schedule->subject->nama_mapel ?? '-' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2 text-gray-600 text-xs">
                                            <i class="fa-solid fa-user-tie text-gray-400"></i>
                                            {{ $schedule->teacher->nama_guru ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('tu.schedules.edit', $schedule->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 border border-yellow-200 transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('tu.schedules.destroy', $schedule->id) }}"
                                                method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 border border-red-200 transition">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 bg-slate-50">
                                        Belum ada jadwal pelajaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden grid grid-cols-1 gap-4 p-4 bg-slate-50">
                    @foreach ($schedules as $schedule)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500 rounded-l-xl"></div>

                            <div class="flex justify-between items-start mb-2 pl-2">
                                <span
                                    class="px-2 py-1 rounded bg-slate-100 text-slate-700 text-xs font-bold">{{ $schedule->hari }}</span>
                                <span class="font-mono text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                </span>
                            </div>

                            <div class="pl-2 mb-3">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $schedule->subject->nama_mapel ?? '-' }}
                                </h3>
                                <div class="text-sm text-emerald-600 font-medium">
                                    {{ $schedule->kelas->nama_kelas ?? '-' }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                    {{ $schedule->teacher->nama_guru ?? '-' }}
                                </div>
                            </div>

                            <div class="flex gap-2 pl-2 border-t border-gray-50 pt-3">
                                <a href="{{ route('tu.schedules.edit', $schedule->id) }}"
                                    class="flex-1 py-2 text-center rounded-lg bg-yellow-50 text-yellow-700 text-sm font-semibold border border-yellow-200">Edit</a>
                                <form action="{{ route('tu.schedules.destroy', $schedule->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('Hapus?');">
                                    @csrf @method('DELETE')
                                    <button
                                        class="w-full py-2 text-center rounded-lg bg-red-50 text-red-700 text-sm font-semibold border border-red-200">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 border-t border-gray-100 bg-white">
                    {{ $schedules->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
