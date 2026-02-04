<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ... other content ... --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Informasi Jadwal</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Jadwal Hari Ini (Existing Code) --}}
                        <div>
                            <h4 class="font-bold text-gray-700 mb-2">Jadwal Hari Ini</h4>
                            {{-- ... loop jadwal hari ini ... --}}
                        </div>

                        {{-- AREA UNTUK KODE BARU ANDA (NEXT SCHEDULE) --}}
                        <div>
                            {{-- PASTE KODE ANDA DI SINI --}}
                            @if($nextSchedule)
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-bold text-blue-800">Jadwal Berikutnya</h4>
                                    <p class="text-gray-700">
                                        {{ $nextSchedule->subject->nama_mapel }}

                                        @if(isset($nextSchedule->day_name))
                                            <span class="text-xs bg-blue-200 px-2 py-1 rounded ml-2">
                                                {{ $nextSchedule->day_name }}
                                            </span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">Jam: {{ $nextSchedule->jam_mulai }}</p>
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-500">Tidak ada jadwal berikutnya.</p>
                                </div>
                            @endif
                            {{-- END PASTE KODE --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ... other content ... --}}
        </div>
    </div>
</x-app-layout>
