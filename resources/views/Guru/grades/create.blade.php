<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <span>Input Nilai Siswa</span>
            </h2>
            <div class="text-sm font-medium text-emerald-700 bg-emerald-100 px-4 py-2 rounded-full">
                {{ $schedule->subject->nama_mapel }} - {{ $schedule->kelas->nama_kelas }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('guru.grades.store', $schedule->id) }}" method="POST">
                @csrf

                <div
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Form Penilaian Semester</h3>
                        <p class="text-gray-500 text-sm">Silakan input nilai Tugas, UTS, dan UAS. Nilai Akhir dihitung
                            otomatis (30% Tugas + 30% UTS + 40% UAS).</p>
                    </div>
                    <button type="submit"
                        class="w-full md:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan Semua Nilai
                    </button>
                </div>

                <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-100 text-slate-600 text-xs uppercase font-bold">
                            <tr>
                                <th class="p-4 w-10 text-center">No</th>
                                <th class="p-4">Nama Siswa</th>
                                <th class="p-4 w-32 text-center">Tugas (30%)</th>
                                <th class="p-4 w-32 text-center">UTS (30%)</th>
                                <th class="p-4 w-32 text-center">UAS (40%)</th>
                                <th class="p-4 w-24 text-center">Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($students as $index => $student)
                                @php
                                    // Ambil nilai jika ada
                                    $grade = $student->grades->first();
                                @endphp
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 text-center text-gray-400">{{ $index + 1 }}</td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800">{{ $student->nama_siswa }}</div>
                                        <div class="text-xs text-gray-400">{{ $student->nis }}</div>
                                        <input type="hidden" name="grades[{{ $student->id }}][nis]"
                                            value="{{ $student->nis }}">
                                    </td>
                                    <td class="p-4">
                                        <input type="number" name="grades[{{ $student->id }}][tugas]"
                                            value="{{ $grade->tugas ?? 0 }}" min="0" max="100"
                                            class="w-full text-center border-gray-300 rounded focus:border-emerald-500 focus:ring-emerald-200 input-nilai"
                                            data-id="{{ $student->id }}">
                                    </td>
                                    <td class="p-4">
                                        <input type="number" name="grades[{{ $student->id }}][uts]"
                                            value="{{ $grade->uts ?? 0 }}" min="0" max="100"
                                            class="w-full text-center border-gray-300 rounded focus:border-emerald-500 focus:ring-emerald-200 input-nilai"
                                            data-id="{{ $student->id }}">
                                    </td>
                                    <td class="p-4">
                                        <input type="number" name="grades[{{ $student->id }}][uas]"
                                            value="{{ $grade->uas ?? 0 }}" min="0" max="100"
                                            class="w-full text-center border-gray-300 rounded focus:border-emerald-500 focus:ring-emerald-200 input-nilai"
                                            data-id="{{ $student->id }}">
                                    </td>
                                    <td class="p-4 text-center">
                                        <span id="akhir-desktop-{{ $student->id }}"
                                            class="font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded">
                                            {{ $grade->nilai_akhir ?? 0 }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden grid grid-cols-1 gap-4">
                    @foreach ($students as $student)
                        @php $grade = $student->grades->first(); @endphp
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 relative">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $student->nama_siswa }}</h4>
                                    <p class="text-xs text-gray-400">{{ $student->nis }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-gray-400 block">Nilai Akhir</span>
                                    <span id="akhir-mobile-{{ $student->id }}"
                                        class="text-lg font-bold text-emerald-600">
                                        {{ $grade->nilai_akhir ?? 0 }}
                                    </span>
                                </div>
                            </div>

                            <input type="hidden" name="grades[{{ $student->id }}][nis]" value="{{ $student->nis }}">

                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 mb-1">TUGAS</label>
                                    <input type="number" name="grades[{{ $student->id }}][tugas]"
                                        value="{{ $grade->tugas ?? 0 }}"
                                        class="w-full text-center border-gray-300 rounded-lg focus:border-emerald-500 input-nilai-mobile"
                                        data-id="{{ $student->id }}">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 mb-1">UTS</label>
                                    <input type="number" name="grades[{{ $student->id }}][uts]"
                                        value="{{ $grade->uts ?? 0 }}"
                                        class="w-full text-center border-gray-300 rounded-lg focus:border-emerald-500 input-nilai-mobile"
                                        data-id="{{ $student->id }}">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 mb-1">UAS</label>
                                    <input type="number" name="grades[{{ $student->id }}][uas]"
                                        value="{{ $grade->uas ?? 0 }}"
                                        class="w-full text-center border-gray-300 rounded-lg focus:border-emerald-500 input-nilai-mobile"
                                        data-id="{{ $student->id }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="md:hidden fixed bottom-4 left-4 right-4 z-50">
                    <button type="submit"
                        class="w-full py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-2xl hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i> SIMPAN SEMUA NILAI
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function hitungNilai(rowInputs, displayId) {}

            const inputs = document.querySelectorAll('.input-nilai, .input-nilai-mobile');

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const studentId = this.getAttribute('data-id');

                    // Cari semua input milik siswa ini (baik desktop/mobile punya name pattern sama)
                    // Kita cari elemen input berdasarkan attribut name yang spesifik
                    const nameBase = `grades[${studentId}]`;
                    const tugas = parseFloat(document.querySelector(
                        `input[name="${nameBase}[tugas]"]`).value) || 0;
                    const uts = parseFloat(document.querySelector(`input[name="${nameBase}[uts]"]`)
                        .value) || 0;
                    const uas = parseFloat(document.querySelector(`input[name="${nameBase}[uas]"]`)
                        .value) || 0;

                    // Rumus: 30% Tugas + 30% UTS + 40% UAS
                    const akhir = (tugas * 0.3) + (uts * 0.3) + (uas * 0.4);

                    // Update tampilan Desktop
                    const displayDesktop = document.getElementById(`akhir-desktop-${studentId}`);
                    if (displayDesktop) displayDesktop.innerText = akhir.toFixed(1);

                    // Update tampilan Mobile
                    const displayMobile = document.getElementById(`akhir-mobile-${studentId}`);
                    if (displayMobile) displayMobile.innerText = akhir.toFixed(1);
                });
            });
        });
    </script>
</x-app-layout>
