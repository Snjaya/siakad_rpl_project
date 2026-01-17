<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-regular fa-calendar-days mr-2 text-emerald-600"></i>
            {{ __('Jadwal Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Jadwal Kelas {{ $student->kelas->nama_kelas }}</h3>
                    <p class="text-sm text-gray-500">Tahun Ajaran Aktif</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    // Grouping jadwal berdasarkan hari secara manual agar urut Senin-Sabtu
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $grouped = $schedules->groupBy('hari');
                @endphp

                @foreach ($days as $day)
                    @if (isset($grouped[$day]))
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-emerald-600 px-4 py-3 flex justify-between items-center">
                                <h4 class="font-bold text-white">{{ $day }}</h4>
                                <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $grouped[$day]->count() }} Mapel
                                </span>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @foreach ($grouped[$day] as $jadwal)
                                    <div class="p-4 hover:bg-slate-50 transition">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="font-bold text-gray-800 text-sm">
                                                {{ $jadwal->subject->nama_mapel }}</h5>
                                            <span
                                                class="text-xs font-mono font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fa-solid fa-chalkboard-user text-emerald-500"></i>
                                            {{ $jadwal->teacher->nama_guru }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            @if ($schedules->isEmpty())
                <div class="text-center p-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <p class="text-gray-400">Belum ada jadwal pelajaran untuk kelas ini.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
