<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-print text-emerald-600"></i>
            {{ __('Cetak Rekap Nilai Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Info Banner --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-info text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Pilih kelas di bawah ini untuk mencetak <strong>Rekapitulasi Nilai Kolektif</strong>.
                        </p>
                    </div>
                </div>
            </div>

            @if ($schedules->isEmpty())
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <i class="fa-solid fa-folder-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">Belum ada kelas yang diajar.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($schedules as $schedule)
                        {{-- KARTU EMERALD (Style Baru) --}}
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300 group relative">

                            {{-- Header Hijau --}}
                            <div class="bg-emerald-600 px-6 py-5 relative overflow-hidden">
                                <div
                                    class="absolute right-0 top-0 h-full w-24 bg-white opacity-10 transform skew-x-[-20deg] translate-x-8">
                                </div>

                                <div class="relative z-10 flex justify-between items-start">
                                    <div>
                                        <h3 class="text-white font-bold text-xl tracking-wide">{{ $schedule->hari }}
                                        </h3>
                                        <div
                                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-800/30 text-emerald-50">
                                            <i class="fa-regular fa-clock mr-1.5"></i>
                                            {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="bg-white/20 p-2 rounded-lg text-white">
                                        <i class="fa-solid fa-users-rectangle text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Isi Kartu --}}
                            <div class="p-6">
                                <h4
                                    class="font-bold text-gray-800 text-lg mb-1 group-hover:text-emerald-600 transition">
                                    {{ $schedule->subject->nama_mapel }}
                                </h4>
                                <p class="text-sm text-gray-500 mb-4">{{ $schedule->kelas->nama_kelas }} •
                                    {{ $schedule->kelas->jurusan }}</p>

                                <hr class="border-gray-100 mb-4">

                                {{-- Tombol Cetak --}}
                                <a href="{{ route('guru.grades.print_recap', $schedule->id) }}" target="_blank"
                                    class="w-full flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200 hover:border-emerald-600 py-3 rounded-lg text-sm font-bold transition-all duration-200">
                                    <i class="fa-solid fa-print"></i>
                                    Cetak Rekap PDF
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
