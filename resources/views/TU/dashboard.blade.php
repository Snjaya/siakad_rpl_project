<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Tata Usaha - Administrator Akademik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Petugas TU!</h3>
                    <p>Tugas Utama: Kelola Data Master & Struktural. </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="border p-4 rounded bg-blue-50">
                            <strong>Kelola Data Master:</strong> Siswa, Guru, Mata Pelajaran.
                        </div>
                        <div class="border p-4 rounded bg-green-50">
                            <strong>Kelola Struktural:</strong> Kelas, Jadwal, & Tahun Ajaran Aktif.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
