<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transkrip Nilai (KHS)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Tombol Kembali --}}
                <div class="mb-6 flex justify-between items-center">
                    <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>

                    <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-100 text-sm text-blue-800">
                        <span class="font-bold">Nama:</span> {{ $student->nama_siswa }} |
                        <span class="font-bold">NIS:</span> {{ $student->nis }}
                    </div>
                </div>

                @if ($grades->isEmpty())
                    <div class="text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                        <i class="fa-solid fa-file-circle-xmark text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">Belum ada nilai yang diterbitkan Guru.</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-slate-600">Mata Pelajaran</th>
                                    <th class="px-4 py-3 text-left font-bold text-slate-600">Guru Pengampu</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600">Tugas</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600">UTS</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600">UAS</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 bg-blue-50">Nilai Akhir
                                    </th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600">Predikat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($grades as $grade)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3 font-bold text-gray-800">
                                            {{ $grade->schedule->subject->nama_mapel }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $grade->schedule->teacher->nama_guru }}
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $grade->tugas }}</td>
                                        <td class="px-4 py-3 text-center">{{ $grade->uts }}</td>
                                        <td class="px-4 py-3 text-center">{{ $grade->uas }}</td>
                                        <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50">
                                            {{ number_format($grade->nilai_akhir, 1) }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $na = $grade->nilai_akhir;
                                                $predikat = 'E';
                                                $warna = 'text-red-600 bg-red-100';

                                                if ($na >= 90) {
                                                    $predikat = 'A';
                                                    $warna = 'text-green-600 bg-green-100';
                                                } elseif ($na >= 80) {
                                                    $predikat = 'B';
                                                    $warna = 'text-blue-600 bg-blue-100';
                                                } elseif ($na >= 70) {
                                                    $predikat = 'C';
                                                    $warna = 'text-yellow-600 bg-yellow-100';
                                                } elseif ($na >= 60) {
                                                    $predikat = 'D';
                                                    $warna = 'text-orange-600 bg-orange-100';
                                                }
                                            @endphp
                                            <span class="px-2 py-1 rounded font-bold text-xs {{ $warna }}">
                                                {{ $predikat }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
