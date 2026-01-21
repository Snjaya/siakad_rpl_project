<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-gauge-high mr-2 text-emerald-600"></i>
            {{ __('Dashboard Tata Usaha') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl shadow-lg p-8 mb-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->username }}! 👋</h3>
                    <p class="text-emerald-50 text-lg opacity-90">Sistem Informasi Akademik SMK Marhas Margahayu.</p>
                    <p class="text-sm mt-4 bg-white/20 inline-block px-4 py-1 rounded-full backdrop-blur-sm">
                        <i class="fa-solid fa-calendar-check mr-2"></i>
                        Tahun Ajaran Aktif:
                        <span class="font-bold text-yellow-300">
                            {{ $activeYear->tahun_ajaran ?? '-' }} ({{ $activeYear->semester ?? '-' }})
                        </span>
                    </p>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 transform skew-x-[-20deg] translate-x-20">
                </div>
                <i class="fa-solid fa-school absolute -bottom-6 right-10 text-9xl text-white/10 rotate-12"></i>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Siswa</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSiswa }}</h4>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('tu.students.index') }}"
                        class="text-xs text-blue-600 font-bold mt-4 inline-block hover:underline">
                        Lihat Data Siswa <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-emerald-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Guru</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalGuru }}</h4>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600">
                            <i class="fa-solid fa-chalkboard-user text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('tu.teachers.index') }}"
                        class="text-xs text-emerald-600 font-bold mt-4 inline-block hover:underline">
                        Lihat Data Guru <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Kelas</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKelas }}</h4>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                            <i class="fa-solid fa-door-open text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('tu.classrooms.index') }}"
                        class="text-xs text-orange-600 font-bold mt-4 inline-block hover:underline">
                        Lihat Data Kelas <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Mata Pelajaran</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalMapel }}</h4>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                            <i class="fa-solid fa-book-open text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('tu.subjects.index') }}"
                        class="text-xs text-purple-600 font-bold mt-4 inline-block hover:underline">
                        Lihat Mapel <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-bolt text-yellow-500 mr-2"></i> Akses Cepat
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('tu.students.create') }}"
                            class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-emerald-500 hover:bg-emerald-50 transition group cursor-pointer">
                            <div
                                class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-emerald-700">Tambah
                                Siswa</span>
                        </a>

                        <a href="{{ route('tu.teachers.create') }}"
                            class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-blue-500 hover:bg-blue-50 transition group cursor-pointer">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-blue-700">Tambah Guru</span>
                        </a>

                        <a href="{{ route('tu.schedules.create') }}"
                            class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-purple-500 hover:bg-purple-50 transition group cursor-pointer">
                            <div
                                class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                                <i class="fa-solid fa-calendar-plus"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 group-hover:text-purple-700">Set
                                Jadwal</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-bold text-gray-800 mb-4">
                        <i class="fa-solid fa-circle-info text-gray-400 mr-2"></i> Status Sistem
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Status Server</span>
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-bold">Online</span>
                        </li>
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Versi Aplikasi</span>
                            <span class="font-mono text-gray-700">v1.0.0</span>
                        </li>
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Database</span>
                            <span class="font-mono text-gray-700">Connected</span>
                        </li>
                        <li class="pt-4 border-t border-gray-100 text-center">
                            <p class="text-xs text-gray-400">SMK Marhas Margahayu &copy; {{ date('Y') }}</p>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
