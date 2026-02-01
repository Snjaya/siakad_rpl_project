<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-emerald-600"></i>
            {{ __('Jadwal Mengajar Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Info --}}
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-emerald-700">
                            Berikut adalah jadwal pelajaran aktif Anda untuk semester ini.
                            Untuk <strong>Input Nilai</strong>, silakan akses menu <a
                                href="{{ route('guru.grades.index') }}"
                                class="font-bold underline hover:text-emerald-900">Input Nilai</a> di sidebar.
                        </p>
                    </div>
                </div>
            </div>

            @if ($schedules->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                        <i class="fa-regular fa-calendar-xmark text-2xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Tidak Ada Jadwal</h3>
                    <p class="text-gray-500 text-sm mt-1">Anda belum memiliki jadwal mengajar aktif saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($schedules as $schedule)
                        {{-- KARTU JADWAL (STYLE EMERALD) --}}
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 group">

                            {{-- Header Kartu (Hijau) --}}
                            <div class="bg-emerald-600 px-6 py-5 relative overflow-hidden">
                                {{-- Elemen Dekorasi --}}
                                <div
                                    class="absolute right-0 top-0 h-full w-24 bg-white opacity-10 transform skew-x-[-20deg] translate-x-8">
                                </div>

                                <div class="relative z-10 flex justify-between items-start">
                                    <div>
                                        <h3 class="text-white font-bold text-xl tracking-wide uppercase">
                                            {{ $schedule->hari }}</h3>
                                        <div
                                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-800/30 text-emerald-50 border border-emerald-500/30">
                                            <i class="fa-regular fa-clock mr-1.5"></i>
                                            {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="bg-white/20 p-2.5 rounded-lg text-white backdrop-blur-sm">
                                        <i class="fa-solid fa-chalkboard-user text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Body Kartu --}}
                            <div class="p-6">
                                <div class="mb-4">
                                    <h4 class="font-bold text-gray-800 text-lg leading-tight mb-1">
                                        {{ $schedule->subject->nama_mapel }}
                                    </h4>
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <span
                                            class="bg-slate-100 px-2 py-0.5 rounded text-xs font-bold text-slate-600 border border-slate-200">
                                            {{ $schedule->kelas->nama_kelas }}
                                        </span>
                                        <span>•</span>
                                        <span>{{ $schedule->kelas->jurusan }}</span>
                                    </div>
                                </div>

                                {{-- Info Ruangan (Jika ada kolom ruangan di DB) --}}
                                @if (isset($schedule->ruangan))
                                    <div
                                        class="flex items-center gap-2 text-sm text-gray-500 mb-4 bg-slate-50 p-2 rounded border border-slate-100">
                                        <i class="fa-solid fa-location-dot text-emerald-500"></i>
                                        <span>Ruang: <strong>{{ $schedule->ruangan }}</strong></span>
                                    </div>
                                @endif

                                <div class="border-t border-gray-100 my-4"></div>

                                {{-- Status Badge (Tanpa Tombol Input) --}}
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-medium text-gray-400">Status Jadwal</span>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="relative flex h-2 w-2">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
