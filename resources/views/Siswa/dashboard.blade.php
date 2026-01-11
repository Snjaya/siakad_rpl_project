<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Error jika data belum ada --}}
            @if (session('error') || (isset($student) && !$student))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Perhatian!</p>
                    <p>{{ session('error') ?? 'Data diri Anda belum lengkap. Silakan hubungi TU.' }}</p>
                </div>
            @endif

            @if ($student)
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-8 mb-8 text-white flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>

                    <div class="z-10 flex items-center gap-6">
                        <div class="bg-white p-1 rounded-full shadow-lg">
                            <div
                                class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold">
                                {{ substr($student->nama_siswa, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold">Halo, {{ explode(' ', $student->nama_siswa)[0] }}! 👋</h3>
                            <p class="text-blue-100 mt-1 text-lg">Selamat datang di Sistem Informasi Akademik.</p>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <span
                                    class="bg-blue-500 bg-opacity-50 px-3 py-1 rounded-full text-sm border border-blue-400">
                                    <i class="fa-solid fa-id-card mr-2"></i>{{ $student->nis }}
                                </span>
                                <span
                                    class="bg-blue-500 bg-opacity-50 px-3 py-1 rounded-full text-sm border border-blue-400">
                                    <i
                                        class="fa-solid fa-school mr-2"></i>{{ $student->classroom->nama_kelas ?? 'Tanpa Kelas' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <a href="{{ route('siswa.schedules.index') }}"
                        class="group bg-white overflow-hidden shadow-sm rounded-xl border hover:border-blue-400 transition-all duration-300 hover:shadow-md">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition">Jadwal
                                    Pelajaran</h4>
                                <p class="text-gray-500 text-sm mt-1">Lihat jadwal kelas Anda minggu ini.</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 text-xl group-hover:scale-110 transition">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('siswa.grades.index') }}"
                        class="group bg-white overflow-hidden shadow-sm rounded-xl border hover:border-green-400 transition-all duration-300 hover:shadow-md">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition">
                                    Transkrip Nilai</h4>
                                <p class="text-gray-500 text-sm mt-1">Cek hasil belajar dan nilai rapor.</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600 text-xl group-hover:scale-110 transition">
                                <i class="fa-solid fa-chart-simple"></i>
                            </div>
                        </div>
                    </a>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
