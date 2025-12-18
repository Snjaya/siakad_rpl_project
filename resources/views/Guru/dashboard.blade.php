<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru - Pengelola Nilai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Bapak/Ibu Guru!</h3>
                    <p>Tanggung Jawab: Input dan Edit Nilai Mata Pelajaran. </p>
                    <ul class="list-disc ml-5 mt-2">
                        <li>Lihat Kelas & Mata Pelajaran yang diampu </li>
                        <li>Input & Edit Nilai Siswa </li>
                        <li>Cetak Rekap Nilai per Kelas </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
