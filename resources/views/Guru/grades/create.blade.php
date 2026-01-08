<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Nilai: {{ $schedule->subject->nama_mapel }} - {{ $schedule->classroom->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- NOTIFIKASI SUKSES (HIJAU) --}}
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 shadow-sm transition-all duration-500"
                        x-data="{ show: true }" x-show="show">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-bold"><i class="fa-solid fa-check-circle mr-2"></i>Berhasil!</p>
                                <p>{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-green-700 hover:text-green-900"><i
                                    class="fa-solid fa-times"></i></button>
                        </div>
                    </div>
                @endif

                <div class="mb-6 bg-blue-50 p-4 rounded border-l-4 border-blue-500 flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-blue-500 mt-1"></i>
                    <p class="text-sm text-gray-600">
                        Silakan input nilai siswa di bawah ini. Tekan tombol <strong>Simpan Perubahan</strong> untuk
                        menyimpan data ke sistem.
                        <br>Nilai Akhir akan dihitung otomatis dari rata-rata (Tugas + UTS + UAS) / 3.
                    </p>
                </div>

                <form action="{{ route('guru.grades.store', $schedule->id_jadwal) }}" method="POST">
                    @csrf

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-slate-600 w-10">No</th>
                                    <th class="px-4 py-3 text-left font-bold text-slate-600">Nama Siswa</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 w-32">Nilai Tugas</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 w-32">Nilai UTS</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 w-32">Nilai UAS</th>
                                    <th class="px-4 py-3 text-center font-bold text-slate-600 w-32">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($students as $index => $student)
                                    @php
                                        $nilai = $existingGrades[$student->nis] ?? null;
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ $student->nama_siswa }}
                                            <div class="text-xs text-gray-400 font-normal">{{ $student->nis }}</div>
                                        </td>

                                        <td class="px-4 py-3">
                                            <input type="number" name="grades[{{ $student->nis }}][tugas]"
                                                value="{{ $nilai->tugas ?? 0 }}" min="0" max="100"
                                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center transition">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="grades[{{ $student->nis }}][uts]"
                                                value="{{ $nilai->uts ?? 0 }}" min="0" max="100"
                                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center transition">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="grades[{{ $student->nis }}][uas]"
                                                value="{{ $nilai->uas ?? 0 }}" min="0" max="100"
                                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center transition">
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span
                                                class="font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded border border-blue-100">
                                                {{ $nilai ? number_format($nilai->nilai_akhir, 1) : '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fa-solid fa-user-slash text-4xl mb-2"></i>
                                                <p>Tidak ada data siswa di kelas ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div
                        class="mt-6 flex justify-end gap-3 sticky bottom-0 bg-white p-4 border-t shadow-inner -mx-6 -mb-6">
                        <a href="{{ route('guru.dashboard') }}"
                            class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
