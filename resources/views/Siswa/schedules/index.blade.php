<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Pelajaran') }} - Kelas {{ $student->classroom->nama_kelas ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Tombol Kembali --}}
                <div class="mb-6">
                    <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>

                @if ($schedules->isEmpty())
                    <div class="text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                        <i class="fa-regular fa-calendar-xmark text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">Belum ada jadwal pelajaran untuk kelas Anda.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Looping Jadwal per Kartu --}}
                        @foreach ($schedules as $s)
                            <div
                                class="bg-white border rounded-xl shadow-sm hover:shadow-md transition-shadow p-5 border-l-4 border-l-blue-500">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded">
                                        {{ $s->hari }}
                                    </span>
                                    <span class="text-sm font-semibold text-gray-500">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        {{ substr($s->jam_mulai, 0, 5) }} - {{ substr($s->jam_selesai, 0, 5) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 mt-2">{{ $s->subject->nama_mapel }}</h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    <i class="fa-solid fa-chalkboard-user mr-1 text-blue-400"></i>
                                    {{ $s->teacher->nama_guru }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
