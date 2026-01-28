<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Siswa - {{ $namaKelas }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
        }

        /* KOP */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 12pt;
        }

        /* INFO KELAS */
        .info {
            margin-bottom: 15px;
        }

        /* TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: middle;
        }

        th {
            background-color: #eee;
            text-align: center;
            font-weight: bold;
            height: 30px;
        }

        .center {
            text-align: center;
        }

        /* ABSENSI MANUAL (KOLOM KOSONG) */
        .absen-box {
            width: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="text-align: center; margin-bottom: 20px; font-family: sans-serif;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #10b981; color: white; border: none; cursor: pointer; font-weight: bold;">
            🖨️ Cetak / Simpan PDF
        </button>
        <a href="{{ route('tu.students.index') }}" style="margin-left: 10px; color: #555;">Kembali</a>
    </div>

    <div class="container">
        <div class="header">
            <h1>SMK MARHAS MARGAHAYU</h1>
            <h3>Daftar Siswa & Absensi</h3>
        </div>

        <div class="info">
            <strong>Kelas :</strong> {{ $namaKelas }} <br>
            <strong>Total Siswa :</strong> {{ $students->count() }} Orang
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" width="5%">No</th>
                    <th rowspan="2" width="15%">NIS</th>
                    <th rowspan="2">Nama Siswa</th>
                    <th rowspan="2" width="5%">L/P</th>
                    <th colspan="4">Keterangan Absensi (Paraf)</th>
                </tr>
                <tr>
                    <th class="absen-box">H</th>
                    <th class="absen-box">S</th>
                    <th class="absen-box">I</th>
                    <th class="absen-box">A</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $siswa)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="center">{{ $siswa->nis }}</td>
                        <td style="padding-left: 8px;">{{ $siswa->nama_siswa }}</td>
                        <td class="center">{{ $siswa->gender == 'L' ? 'L' : 'P' }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right; font-size: 10pt;">
            Dicetak pada: {{ date('d-m-Y H:i') }}
        </div>
    </div>
</body>

</html>
