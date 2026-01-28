<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-file-contract mr-2 text-emerald-600"></i>
            {{ __('Kartu Hasil Studi (KHS)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Informasi Siswa --}}
            <div
                class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $student->nama_siswa }}</h3>
                    <div class="flex gap-3 text-sm text-gray-500 mt-1">
                        <span>NIS: <b>{{ $student->nis }}</b></span>
                        <span>•</span>
                        <span>Kelas: <b>{{ $student->kelas->nama_kelas ?? 'Tanpa Kelas' }}</b></span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg font-bold text-sm">
                    Total Mapel Dinilai: {{ $grades->count() }}
                </div>
            </div>

            {{-- Tabel Nilai --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-xs uppercase font-bold border-b border-gray-200">
                                <th class="p-4 w-10 text-center">#</th>
                                <th class="p-4">Mata Pelajaran</th>
                                <th class="p-4">Guru Pengampu</th>
                                <th class="p-4 text-center w-24">Tugas</th>
                                <th class="p-4 text-center w-24">UTS</th>
                                <th class="p-4 text-center w-24">UAS</th>
                                <th class="p-4 text-center w-24">Akhir</th>
                                <th class="p-4 text-center w-24">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($grades as $index => $grade)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 text-center text-gray-400">{{ $index + 1 }}</td>
                                    <td class="p-4 font-bold text-gray-800">
                                        {{-- Mengambil Nama Mapel via relasi jadwal -> subject --}}
                                        {{ $grade->jadwal->subject->nama_mapel ?? 'Mata Pelajaran Tidak Ditemukan' }}
                                    </td>
                                    <td class="p-4 text-gray-500 text-xs">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-user-tie"></i>
                                            {{ $grade->jadwal->teacher->nama_guru ?? 'Guru Tidak Ditemukan' }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center text-gray-600">{{ $grade->tugas }}</td>
                                    <td class="p-4 text-center text-gray-600">{{ $grade->uts }}</td>
                                    <td class="p-4 text-center text-gray-600">{{ $grade->uas }}</td>
                                    <td class="p-4 text-center font-bold text-emerald-700 bg-emerald-50/50">
                                        {{ $grade->nilai_akhir }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @php
                                            $na = $grade->nilai_akhir;
                                            if ($na >= 85) {
                                                $huruf = 'A';
                                                $badge = 'bg-green-100 text-green-700';
                                            } elseif ($na >= 75) {
                                                $huruf = 'B';
                                                $badge = 'bg-blue-100 text-blue-700';
                                            } elseif ($na >= 60) {
                                                $huruf = 'C';
                                                $badge = 'bg-yellow-100 text-yellow-700';
                                            } elseif ($na >= 50) {
                                                $huruf = 'D';
                                                $badge = 'bg-orange-100 text-orange-700';
                                            } else {
                                                $huruf = 'E';
                                                $badge = 'bg-red-100 text-red-700';
                                            }
                                        @endphp
                                        <span class="px-2 py-1 rounded font-bold text-xs {{ $badge }}">
                                            {{ $huruf }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <i class="fa-solid fa-file-circle-xmark text-5xl mb-3 text-gray-200"></i>
                                            <p class="text-lg font-medium">Belum ada nilai yang diinput oleh guru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
