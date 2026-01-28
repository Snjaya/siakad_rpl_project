<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-pen-to-square mr-2 text-emerald-600"></i>
            {{ __('Edit Nilai Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fa-solid fa-book-open mr-2 text-emerald-500"></i>
                        {{ $schedule->subject->nama_mapel }}
                    </h3>
                    <p class="text-gray-500 text-sm mt-1">
                        Kelas: <span
                            class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">{{ $schedule->kelas->nama_kelas }}</span>
                        <span class="mx-2">•</span>
                        Total Siswa: <span class="font-bold text-emerald-600">{{ $students->count() }}</span>
                    </p>
                </div>

                <div class="flex gap-2">
                    {{-- TOMBOL CETAK BARU --}}
                    <a href="{{ route('guru.grades.print', $schedule->id) }}" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm flex items-center">
                        <i class="fa-solid fa-print mr-2"></i> Cetak Rekap
                    </a>

                    <a href="{{ route('guru.dashboard') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-200 transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-xl sm:rounded-xl overflow-hidden border border-gray-100">
                <form action="{{ route('guru.grades.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-emerald-600 text-white uppercase text-xs font-bold">
                                <tr>
                                    <th class="p-4 w-12 text-center">No</th>
                                    <th class="p-4">Identitas Siswa</th>
                                    {{-- HEADER PERSENTASE BARU --}}
                                    <th class="p-4 w-32 text-center">Tugas (20%)</th>
                                    <th class="p-4 w-32 text-center">UTS (30%)</th>
                                    <th class="p-4 w-32 text-center">UAS (50%)</th>
                                    <th class="p-4 w-32 text-center bg-emerald-700">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm bg-white">
                                @foreach ($students as $index => $siswa)
                                    @php
                                        $nilai = $grades[$siswa->id] ?? null;
                                        $rowClass = $loop->even ? 'bg-gray-50' : 'bg-white';
                                    @endphp

                                    <tr class="{{ $rowClass }} hover:bg-yellow-50 transition duration-150">
                                        <td class="p-4 text-center text-gray-400 font-medium">{{ $index + 1 }}</td>
                                        <td class="p-4">
                                            <div class="font-bold text-gray-800">{{ $siswa->nama_siswa }}</div>
                                            <div class="text-xs text-gray-500 font-mono">{{ $siswa->nis }}</div>
                                        </td>
                                        <td class="p-4">
                                            <input type="number" name="grades[{{ $siswa->id }}][tugas]"
                                                value="{{ old('grades.' . $siswa->id . '.tugas', $nilai->tugas ?? 0) }}"
                                                class="w-full text-center border-gray-300 rounded focus:border-emerald-500 focus:ring-emerald-500 font-medium"
                                                min="0" max="100" placeholder="0">
                                        </td>
                                        <td class="p-4">
                                            <input type="number" name="grades[{{ $siswa->id }}][uts]"
                                                value="{{ old('grades.' . $siswa->id . '.uts', $nilai->uts ?? 0) }}"
                                                class="w-full text-center border-gray-300 rounded focus:border-emerald-500 focus:ring-emerald-500 font-medium"
                                                min="0" max="100" placeholder="0">
                                        </td>
                                        <td class="p-4">
                                            <input type="number" name="grades[{{ $siswa->id }}][uas]"
                                                value="{{ old('grades.' . $siswa->id . '.uas', $nilai->uas ?? 0) }}"
                                                class="w-full text-center border-gray-300 rounded focus:border-emerald-500 focus:ring-emerald-500 font-medium"
                                                min="0" max="100" placeholder="0">
                                        </td>
                                        <td
                                            class="p-4 text-center font-bold text-emerald-700 bg-emerald-50 border-l border-emerald-100">
                                            {{ $nilai->nilai_akhir ?? 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-xs text-gray-500 italic">
                            * Nilai Akhir akan dihitung ulang otomatis (20% Tugas + 30% UTS + 50% UAS) setelah disimpan.
                        </div>
                        <button type="submit"
                            class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:bg-emerald-700 transition transform hover:-translate-y-0.5 flex items-center">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
