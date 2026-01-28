<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-calendar-days mr-2 text-emerald-600"></i>
            {{ __('Manajemen Jadwal & Nilai') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-700">Jadwal Mengajar Mingguan</h3>
                <p class="text-sm text-gray-500">Berikut adalah seluruh jadwal Anda dari Senin s.d Sabtu.</p>
            </div>

            @forelse($schedules as $hari => $listJadwal)
                {{-- Loop Per Hari --}}
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span
                            class="px-4 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-sm uppercase">
                            {{ $hari }}
                        </span>
                        <div class="h-px bg-gray-300 flex-1"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($listJadwal as $jadwal)
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden group">
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4
                                                class="font-bold text-gray-800 text-lg group-hover:text-emerald-600 transition">
                                                {{ $jadwal->subject->nama_mapel }}
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $jadwal->kelas->nama_kelas }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="block text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">
                                                {{ substr($jadwal->jam_mulai, 0, 5) }} -
                                                {{ substr($jadwal->jam_selesai, 0, 5) }}
                                            </span>
                                            <span class="block text-xs text-gray-400 mt-1">R.
                                                {{ $jadwal->ruangan }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-gray-50 flex gap-2">
                                        <a href="{{ route('guru.grades.create', $jadwal->id) }}"
                                            class="flex-1 text-center py-2 bg-emerald-600 text-white rounded text-sm font-bold hover:bg-emerald-700 transition">
                                            Input Nilai
                                        </a>
                                        <a href="{{ route('guru.grades.edit', $jadwal->id) }}"
                                            class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded text-sm hover:bg-yellow-200 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada jadwal yang ditentukan.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
