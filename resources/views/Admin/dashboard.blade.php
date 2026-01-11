<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class=" text-emerald-600"></i>
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6 border-l-4 border-emerald-500 relative">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->username }}! 👋
                            </h3>
                            <p class="text-gray-600 mt-1">
                                Anda login sebagai <span
                                    class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Superuser
                                    Override</span>.
                                Anda memiliki kontrol penuh atas sistem SIAKAD SMK Marhas.
                            </p>
                        </div>
                        <div class="text-right hidden md:block">
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Terakhir Login</p>
                            <p class="text-sm font-medium text-gray-700">{{ now()->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-100 rounded-full opacity-50 blur-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

                <div
                    class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Total Akun</p>
                        {{-- Angka ini sebaiknya dinamis dari Controller, sementara kita hardcode --}}
                        <h4 class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() ?? '0' }}</h4>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div
                        class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 text-xl">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Data Guru</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ \App\Models\Teacher::count() ?? '0' }}</h4>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div
                        class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 text-xl">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Data Siswa</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ \App\Models\Student::count() ?? '0' }}</h4>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 transition-transform hover:-translate-y-1 duration-300">
                    <div
                        class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 text-xl">
                        <i class="fa-solid fa-school"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Total Kelas</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ \App\Models\Classroom::count() ?? '0' }}</h4>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-4 px-1">Akses Cepat Pengontrol</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <a href="{{ route('admin.users.index') }}"
                    class="group bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-emerald-500 hover:shadow-md transition-all duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2 py-1 rounded">Prioritas</span>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700">Manajemen Akun</h4>
                    <p class="text-sm text-gray-500 mt-2">
                        Tambah, edit, atau hapus akun pengguna (Guru, TU, Siswa) dan reset password.
                    </p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
