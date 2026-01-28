<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai - {{ $schedule->kelas->nama_kelas }} - {{ $schedule->subject->nama_mapel }}</title>
    <style>
        /* CSS Khusus Cetak A4 */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
        }

        /* Kop Surat Sederhana */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }

        /* Info Kelas */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 2px;
            vertical-align: top;
        }

        .label {
            width: 150px;
            font-weight: bold;
        }

        /* Tabel Nilai */
        .grade-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .grade-table th,
        .grade-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .grade-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .text-left {
            text-align: left !important;
        }

        /* Tanda Tangan */
        .footer {
            width: 100%;
            margin-top: 50px;
        }

        .signature {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature p {
            margin-bottom: 60px;
        }

        /* Tombol Cetak (Hilang saat diprint) */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-print {
            background: #10b981;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">🖨️ Cetak / Simpan PDF</button>
        <a href="{{ route('guru.grades.edit', $schedule->id) }}"
            style="margin-left: 10px; color: #555; text-decoration: none; font-family: sans-serif;">Kembali</a>
    </div>

    <div class="container">
        <div class="header">
            <h1>SMK MARHAS MARGAHAYU</h1>
            <h2>Laporan Rekapitulasi Nilai Siswa</h2>
            <p>Jl. Amanah No. 123, Margahayu, Bandung, Jawa Barat</p>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Mata Pelajaran</td>
                <td>: {{ $schedule->subject->nama_mapel }}</td>
                <td class="label">Tahun Ajaran</td>
                <td>: 2025/2026 (Ganjil)</td>
            </tr>
            <tr>
                <td class="label">Kelas / Jurusan</td>
                <td>: {{ $schedule->kelas->nama_kelas }} / {{ $schedule->kelas->jurusan }}</td>
                <td class="label">Guru Pengampu</td>
                <td>: {{ $schedule->teacher->nama_guru }}</td>
            </tr>
        </table>

        <table class="grade-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">NIS</th>
                    <th class="text-left">Nama Siswa</th>
                    <th style="width: 10%;">Tugas (20%)</th>
                    <th style="width: 10%;">UTS (30%)</th>
                    <th style="width: 10%;">UAS (50%)</th>
                    <th style="width: 10%;">Nilai Akhir</th>
                    <th style="width: 10%;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $siswa)
                    @php
                        $nilai = $grades[$siswa->id] ?? null;
                        $akhir = $nilai->nilai_akhir ?? 0;

                        // Hitung Predikat Sederhana
                        $predikat = 'E';
                        if ($akhir >= 90) {
                            $predikat = 'A';
                        } elseif ($akhir >= 80) {
                            $predikat = 'B';
                        } elseif ($akhir >= 70) {
                            $predikat = 'C';
                        } elseif ($akhir >= 60) {
                            $predikat = 'D';
                        }
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td class="text-left">{{ $siswa->nama_siswa }}</td>
                        <td>{{ $nilai->tugas ?? '-' }}</td>
                        <td>{{ $nilai->uts ?? '-' }}</td>
                        <td>{{ $nilai->uas ?? '-' }}</td>
                        <td style="font-weight: bold;">{{ $akhir > 0 ? $akhir : '-' }}</td>
                        <td>{{ $akhir > 0 ? $predikat : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <div class="signature">
                Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                Guru Mata Pelajaran,
                <p></p> <strong><u>{{ $schedule->teacher->nama_guru }}</u></strong><br>
                NIP. {{ $schedule->teacher->nip ?? '-' }}
            </div>
        </div>
    </div>

</body>

</html>
