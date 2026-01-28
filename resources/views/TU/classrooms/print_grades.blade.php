<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Kelas {{ $classroom->nama_kelas }}</title>
    <style>
        @page {
            size: landscape;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2,
        .header h3 {
            margin: 0;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
            font-size: 8pt;
        }

        .text-left {
            text-align: left;
            padding-left: 8px;
        }

        .no-print {
            text-align: center;
            margin: 20px;
        }

        .btn-print {
            padding: 10px 20px;
            background: #059669;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-back {
            padding: 10px 20px;
            background: #6b7280;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">🖨️ Cetak Laporan Nilai Kelas</button>
        <a href="{{ route('tu.classrooms.index') }}" class="btn-back">Kembali</a>
    </div>

    <div class="container">
        <div class="header">
            <h2>REKAPITULASI NILAI SISWA - SMK MARHAS</h2>
            <h3>KELAS: {{ $classroom->nama_kelas }} | TAHUN AJARAN: {{ date('Y') }}</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" width="30px">No</th>
                    <th rowspan="2" width="80px">NIS</th>
                    <th rowspan="2" width="200px">Nama Siswa</th>
                    {{-- Judul Mata Pelajaran --}}
                    <th colspan="{{ $subjects->count() }}">Mata Pelajaran</th>
                    <th rowspan="2" width="60px">Rata-rata</th>
                </tr>
                <tr>
                    @foreach ($subjects as $idMapel => $namaMapel)
                        <th title="{{ $namaMapel }}">{{ Str::limit($namaMapel, 10) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{-- MENGGUNAKAN $itemSiswa AGAR TIDAK BENTROK --}}
                @forelse($students as $index => $itemSiswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $itemSiswa->nis }}</td>
                        <td class="text-left">{{ $itemSiswa->nama_siswa }}</td>

                        @php
                            $totalNilai = 0;
                            $countMapelNilai = 0;
                        @endphp

                        @foreach ($subjects as $idMapel => $namaMapel)
                            @php
                                // PASTIKAN DISINI MENGGUNAKAN $itemSiswa->id
                                $gradeRecord = $grades
                                    ->where('id_siswa', $itemSiswa->id)
                                    ->filter(function ($g) use ($idMapel) {
                                        return $g->schedule->id_mapel == $idMapel;
                                    })
                                    ->first();

                                $nilai = $gradeRecord ? $gradeRecord->nilai_akhir : 0;

                                if ($nilai > 0) {
                                    $totalNilai += $nilai;
                                    $countMapelNilai++;
                                }
                            @endphp
                            <td style="{{ $nilai < 75 && $nilai > 0 ? 'color: red; font-weight: bold;' : '' }}">
                                {{ $nilai > 0 ? $nilai : '-' }}
                            </td>
                        @endforeach

                        <td style="font-weight: bold; background-color: #f9fafb;">
                            {{ $countMapelNilai > 0 ? round($totalNilai / $countMapelNilai, 1) : '0' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $subjects->count() + 4 }}">Belum ada data siswa di kelas ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
            <div style="width: 300px; text-align: center;">
                Bandung, {{ date('d F Y') }} <br>
                Kepala Tata Usaha,
                <br><br><br><br><br>
                <strong>_______________________</strong><br>
                NIP. ...........................
            </div>
        </div>
    </div>

</body>

</html>
