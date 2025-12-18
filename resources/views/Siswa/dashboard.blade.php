<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa - Pengguna Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang di Portal Siswa!</h3>
                    <p>Akses informasi akademik Anda di sini. </p>
                    <div class="mt-4 border-l-4 border-blue-500 pl-4">
                        <p><strong>Cek Jadwal:</strong> Lihat jadwal pelajaran per semester. </p>
                        <p><strong>Cek Nilai:</strong> Lihat transkrip nilai akademik. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
