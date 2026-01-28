<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transkrip Nilai - {{ $student->nama_siswa }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            text-transform: uppercase;
            font-size: 16pt;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 2px;
            font-size: 11pt;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table.data-table td.left {
            text-align: left;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .footer table {
            width: 100%;
        }

        .footer-sign {
            text-align: center;
            width: 40%;
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

    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f4f4f4;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            🖨️ Cetak Transkrip Nilai
        </button>
        <a href="{{ route('tu.students.index') }}"
            style="margin-left: 10px; text-decoration: none; color: #666;">Kembali</a>
    </div>

    <div class="container">
        <div class="header">
            <h1>SMK MARHAS MARGAHAYU</h1>
            <p>Jl. Terusan Kopo No. 385, Margahayu, Kec. Margahayu, Bandung</p>
            <h2 style="margin: 5px 0; font-size: 14pt;">TRANSKRIP NILAI SISWA</h2>
        </div>

        <table class="info-table">
            <tr>
                <td width="15%">Nama Siswa</td>
                <td width="2%">:</td>
                <td width="40%"><strong>{{ $student->nama_siswa }}</strong></td>
                <td width="15%">Kelas</td>
                <td width="2%">:</td>
                <td>{{ $student->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>{{ $student->nis }}</td>
                <td>Jurusan</td>
                <td>:</td>
                <td>{{ $student->kelas->jurusan ?? '-' }}</td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="10%">KKM</th>
                    <th width="15%">Nilai Akhir</th>
                    <th width="20%">Predikat</th>
                    <th width="20%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $index => $grade)
                    @php
                        $nilai = $grade->nilai_akhir;
                        $kkm = $grade->schedule->subject->kkm ?? 75;
                        $status = $nilai >= $kkm ? 'KOMPETEN' : 'BELUM KOMPETEN';

                        // Logika Predikat Sederhana
                        if ($nilai >= 90) {
                            $predikat = 'A (Sangat Baik)';
                        } elseif ($nilai >= 80) {
                            $predikat = 'B (Baik)';
                        } elseif ($nilai >= 75) {
                            $predikat = 'C (Cukup)';
                        } else {
                            $predikat = 'D (Kurang)';
                        }
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="left">{{ $grade->schedule->subject->nama_mapel }}</td>
                        <td>{{ $kkm }}</td>
                        <td style="font-weight: bold;">{{ $nilai }}</td>
                        <td>{{ $predikat }}</td>
                        <td style="color: {{ $nilai >= $kkm ? 'black' : 'red' }}; font-size: 10pt;">
                            {{ $status }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data nilai yang diinput.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <table>
                <tr>
                    <td class="footer-sign">
                        Mengetahui,<br>Orang Tua/Wali
                        <br><br><br><br>
                        ( ................................ )
                    </td>
                    <td></td>
                    <td class="footer-sign">
                        Bandung, {{ date('d F Y') }}<br>Kepala Tata Usaha,
                        <br><br><br><br>
                        <strong>_______________________</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
