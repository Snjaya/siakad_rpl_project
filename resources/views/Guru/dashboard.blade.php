<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-gauge-high mr-2 text-emerald-600"></i>
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- BAGIAN 1: WELCOME BANNER --}}
            <div
                class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-lg p-8 mb-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold">Selamat Datang, {{ $guru->nama_guru ?? 'Bapak/Ibu Guru' }}! 👋</h3>
                    <p class="text-emerald-100 mt-2 text-lg">
                        Semoga harimu menyenangkan. Hari ini adalah <span
                            class="font-bold text-white bg-white/20 px-2 py-0.5 rounded">{{ $hariIni }},
                            {{ $tanggalIni }}</span>.
                    </p>
                </div>
                {{-- Dekorasi Icon Background --}}
                <i class="fa-solid fa-chalkboard-user absolute -bottom-6 -right-6 text-9xl text-white/10 rotate-12"></i>
            </div>

            {{-- BAGIAN 2: STATISTIK RINGKAS (STATS CARDS) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
                    <div class="p-4 rounded-full bg-blue-50 text-blue-600 mr-4">
                        <i class="fa-solid fa-school text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Kelas Ajar</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $totalKelas ?? 0 }} Kelas</h4>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
                    <div class="p-4 rounded-full bg-orange-50 text-orange-600 mr-4">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Siswa Diampu</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $totalSiswa ?? 0 }} Siswa</h4>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition">
                    <div class="p-4 rounded-full bg-purple-50 text-purple-600 mr-4">
                        <i class="fa-regular fa-clock text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Beban Mengajar</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $totalJam ?? 0 }} Sesi / Minggu</h4>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 3: AGENDA HARI INI --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fa-solid fa-calendar-day mr-2 text-emerald-600"></i>
                    Agenda Mengajar Hari Ini
                </h3>

                {{-- Shortcut ke Jadwal Lengkap --}}
                {{-- Pastikan route ini ada, jika belum ada route khusus jadwal, bisa dikosongkan dulu --}}
                <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border shadow-sm">
                    {{ $hariIni }}
                </span>
            </div>

            @if (isset($jadwalHariIni) && $jadwalHariIni->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($jadwalHariIni as $jadwal)
                        <div
                            class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-emerald-500 flex flex-col md:flex-row justify-between items-center hover:shadow-md transition group">

                            {{-- Info Kiri: Jam & Mapel --}}
                            <div class="flex items-start gap-4 mb-4 md:mb-0 w-full md:w-auto">
                                <div class="bg-slate-100 p-3 rounded-lg text-center min-w-[80px]">
                                    <span class="block text-xs text-gray-500 font-bold uppercase">Mulai</span>
                                    <span class="block text-lg font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-600 transition">
                                        {{ $jadwal->subject->nama_mapel }}
                                    </h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span
                                            class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-0.5 rounded">
                                            {{ $jadwal->kelas->nama_kelas }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="fa-solid fa-location-dot mr-1 text-gray-400"></i>
                                            Ruang {{ $jadwal->ruangan ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Info Kanan: Tombol Aksi Cepat --}}
                            <div class="flex gap-2 w-full md:w-auto">
                                {{-- Tombol Lihat Siswa --}}
                                <a href="{{ route('guru.students.index', ['id_kelas' => $jadwal->id_kelas]) }}"
                                    class="flex-1 md:flex-none px-4 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-50 transition flex items-center justify-center">
                                    <i class="fa-solid fa-users mr-2"></i> Absen
                                </a>

                                {{-- Tombol Input Nilai --}}
                                <a href="{{ route('guru.grades.create', $jadwal->id) }}"
                                    class="flex-1 md:flex-none px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-bold hover:bg-emerald-700 shadow-sm hover:shadow transition flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square mr-2"></i> Nilai
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- State Kosong (Jika Libur/Tidak Ada Jadwal) --}}
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-dashed border-gray-300">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 rounded-full mb-4">
                        <i class="fa-solid fa-mug-hot text-4xl text-emerald-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Tidak ada jadwal hari ini!</h3>
                    <p class="text-gray-500 mt-2">
                        Nikmati waktu luang Anda atau persiapkan materi untuk pertemuan berikutnya.
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
