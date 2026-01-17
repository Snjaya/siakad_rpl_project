<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-chalkboard-user mr-2 text-emerald-600"></i>
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6 border-l-4 border-emerald-500">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Selamat Datang, {{ $teacherName }}! 👋</h3>
                        <p class="text-sm text-gray-500 mt-1">Berikut adalah jadwal mengajar Anda semester ini.</p>
                    </div>
                    <div class="hidden md:block text-emerald-100">
                        <i class="fa-solid fa-person-chalkboard text-6xl"></i>
                    </div>
                </div>
            </div>

            <h3 class="font-bold text-lg text-gray-700 mb-4 px-2 flex items-center">
                <i class="fa-regular fa-calendar-check mr-2 text-emerald-600"></i>
                Jadwal Mengajar
            </h3>

            @if ($schedules->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($schedules as $schedule)
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200 overflow-hidden group">
                            <div class="bg-slate-50 p-4 border-b border-gray-100 flex justify-between items-center">
                                @php
                                    $hariColor = match ($schedule->hari) {
                                        'Senin' => 'bg-red-100 text-red-700',
                                        'Selasa' => 'bg-orange-100 text-orange-700',
                                        'Rabu' => 'bg-yellow-100 text-yellow-700',
                                        'Kamis' => 'bg-green-100 text-green-700',
                                        'Jumat' => 'bg-blue-100 text-blue-700',
                                        'Sabtu' => 'bg-purple-100 text-purple-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $hariColor }}">
                                    {{ $schedule->hari }}
                                </span>
                                <span class="text-sm font-mono text-gray-500 font-semibold">
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                </span>
                            </div>

                            <div class="p-5">
                                <h4
                                    class="font-bold text-gray-800 text-lg mb-1 group-hover:text-emerald-600 transition">
                                    {{-- SAFE GUARD: Pakai tanda ?? agar tidak error jika mapel dihapus --}}
                                    {{ $schedule->subject->nama_mapel ?? 'Mapel Dihapus' }}
                                </h4>

                                <div class="flex items-center gap-2 mb-4">
                                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-0.5 rounded">
                                        {{-- PERBAIKAN UTAMA DI SINI (Line 72-74) --}}
                                        {{ $schedule->kelas->nama_kelas ?? 'Kelas Tidak Ditemukan' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $schedule->kelas->jurusan ?? '-' }}
                                    </span>
                                </div>

                                <a href="{{ route('guru.grades.create', $schedule->id) }}"
                                    class="block w-full text-center py-2.5 rounded-lg bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 transition shadow-md hover:shadow-lg transform active:scale-95">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Input Nilai
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-dashed border-gray-300">
                    <div class="text-gray-300 mb-4">
                        <i class="fa-solid fa-mug-hot text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada jadwal mengajar</h3>
                    <p class="text-gray-500 text-sm mt-1">Anda belum memiliki jadwal kelas di semester ini. Hubungi TU.
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
