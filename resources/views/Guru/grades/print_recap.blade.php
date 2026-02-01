<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai - {{ $schedule->subject->nama_mapel }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            .no-print {
                display: none;
            }
        }

        body {
            font-family: 'Times New Roman', serif;
        }

        .table-print th,
        .table-print td {
            border: 1px solid black;
            padding: 6px;
            font-size: 11pt;
        }

        .table-print th {
            background-color: #f3f4f6;
            -webkit-print-color-adjust: exact;
        }
    </style>
</head>

<body class="p-8 bg-white text-black">

    <div class="no-print fixed top-5 right-5 flex gap-2">
        <button onclick="window.print()"
            class="bg-blue-600 text-white px-4 py-2 rounded font-sans text-sm font-bold shadow hover:bg-blue-700">Cetak</button>
    </div>

    {{-- KOP SURAT --}}
    <div class="text-center border-b-2 border-black pb-4 mb-6">
        <h1 class="text-2xl font-bold uppercase tracking-widest">SMK MARHAS BANDUNG</h1>
        <p class="text-sm">Laporan Rekapitulasi Nilai Kolektif Siswa</p>
    </div>

    {{-- INFO KELAS --}}
    <div class="flex justify-between mb-4 font-bold text-sm uppercase">
        <div>
            <p>Mapel : {{ $schedule->subject->nama_mapel }}</p>
            <p>Guru : {{ $teacher->nama_guru }}</p>
        </div>
        <div class="text-right">
            <p>Kelas : {{ $schedule->kelas->nama_kelas }}</p>
            <p>Tahun Ajaran : {{ now()->year }}/{{ now()->year + 1 }}</p>
        </div>
    </div>

    {{-- TABEL NILAI --}}
    <table class="w-full border-collapse table-print text-center">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th class="text-left">Nama Siswa</th>
                <th width="10%">Tugas</th>
                <th width="10%">UTS</th>
                <th width="10%">UAS</th>
                <th width="10%">Akhir</th>
                <th width="10%">Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
                @php
                    // Ambil data nilai dari properti manual yang kita inject di Controller
                    $g = $student->grade;

                    $na = $g->nilai_akhir ?? 0;
                    if ($na >= 85) {
                        $p = 'A';
                    } elseif ($na >= 75) {
                        $p = 'B';
                    } elseif ($na >= 60) {
                        $p = 'C';
                    } elseif ($na >= 50) {
                        $p = 'D';
                    } else {
                        $p = 'E';
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->nis }}</td>
                    <td class="text-left">{{ $student->nama_siswa }}</td>
                    {{-- Akses data nilai dengan aman --}}
                    <td>{{ $g->tugas ?? '-' }}</td>
                    <td>{{ $g->uts ?? '-' }}</td>
                    <td>{{ $g->uas ?? '-' }}</td>
                    <td class="font-bold">{{ $g->nilai_akhir ?? '-' }}</td>
                    <td>
                        @if ($g)
                            {{ $p }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-4 italic">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="mt-12 flex justify-end">
        <div class="text-center w-64">
            <p class="text-sm">Bandung, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p class="text-sm font-bold mb-16">Guru Mata Pelajaran,</p>
            <p class="font-bold underline">{{ $teacher->nama_guru }}</p>
            <p class="text-xs">NIP. {{ $teacher->nip ?? '-' }}</p>
        </div>
    </div>
</body>

</html>
