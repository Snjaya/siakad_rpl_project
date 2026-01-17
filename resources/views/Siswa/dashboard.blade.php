<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-user-graduate mr-2 text-emerald-600"></i>
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (!$student)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Data Siswa Tidak Ditemukan</p>
                    <p>Akun Anda belum terhubung dengan data siswa. Harap hubungi Tata Usaha.</p>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6 relative overflow-hidden">
                    <div
                        class="absolute right-0 top-0 h-full w-1/3 bg-emerald-600 transform skew-x-[-20deg] translate-x-10 opacity-10">
                    </div>
                    <div class="p-6 relative z-10 flex flex-col md:flex-row items-center gap-6">
                        <div
                            class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-3xl shadow-inner">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-center md:text-left">
                            <h3 class="text-2xl font-bold text-gray-800">Hai, {{ $student->nama_siswa }}! 👋</h3>
                            <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $student->nis }}
                                </span>
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $student->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                                </span>
                                <span class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $student->kelas->jurusan ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="space-y-6">
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Rata-rata Nilai</p>
                                <h4 class="text-3xl font-bold text-gray-800 mt-1">
                                    {{ number_format($averageGrade ?? 0, 1) }}
                                </h4>
                            </div>
                            <div
                                class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-600 text-xl">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h4 class="font-bold text-gray-800 mb-4">Menu Akses</h4>
                            <div class="space-y-3">
                                <a href="{{ route('siswa.schedules.index') }}"
                                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-50 text-gray-600 hover:text-emerald-700 transition border border-gray-100 hover:border-emerald-200">
                                    <div
                                        class="w-8 h-8 rounded bg-emerald-100 flex items-center justify-center text-emerald-600">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </div>
                                    <span class="font-medium">Lihat Jadwal Lengkap</span>
                                    <i class="fa-solid fa-chevron-right ml-auto text-xs opacity-50"></i>
                                </a>
                                <a href="{{ route('siswa.grades.index') }}"
                                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-700 transition border border-gray-100 hover:border-blue-200">
                                    <div
                                        class="w-8 h-8 rounded bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fa-solid fa-file-contract"></i>
                                    </div>
                                    <span class="font-medium">Lihat KHS / Raport</span>
                                    <i class="fa-solid fa-chevron-right ml-auto text-xs opacity-50"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                                <i class="fa-solid fa-calendar-day text-emerald-500"></i>
                                Jadwal Hari Ini
                            </h4>
                            <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded">
                                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>

                        @if ($nextSchedule->count() > 0)
                            <div class="space-y-4">
                                @foreach ($nextSchedule as $jadwal)
                                    <div
                                        class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-gray-100">
                                        <div class="text-center min-w-[60px]">
                                            <span class="block text-sm font-bold text-gray-800">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                            </span>
                                            <span class="block text-xs text-gray-400">
                                                s/d {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="w-px bg-gray-200 h-10"></div>
                                        <div>
                                            <h5 class="font-bold text-emerald-700">{{ $jadwal->subject->nama_mapel }}
                                            </h5>
                                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                <i class="fa-solid fa-chalkboard-user"></i>
                                                {{ $jadwal->teacher->nama_guru }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div class="inline-block p-4 rounded-full bg-slate-50 text-slate-300 mb-3">
                                    <i class="fa-solid fa-mug-hot text-4xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Tidak ada jadwal pelajaran hari ini.</p>
                                <p class="text-xs text-gray-400">Selamat beristirahat atau belajar mandiri!</p>
                            </div>
                        @endif
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
