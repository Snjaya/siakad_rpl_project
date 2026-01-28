<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Guru - SMK Marhas</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
        }

        /* KOP SURAT */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double black;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14pt;
        }

        .header p {
            margin: 0;
            font-style: italic;
            font-size: 10pt;
        }

        /* TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        /* TOMBOL CETAK */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
            font-family: sans-serif;
        }

        .btn {
            padding: 8px 15px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }

        .btn-back {
            background: #555;
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
        <button onclick="window.print()" class="btn">🖨️ Cetak Dokumen</button>
        <a href="{{ route('tu.teachers.index') }}" class="btn btn-back">Kembali</a>
    </div>

    <div class="container">
        <div class="header">
            <h1>SMK MARHAS MARGAHAYU</h1>
            <h2>Laporan Data Guru Aktif</h2>
            <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">NIP</th>
                    <th>Nama Lengkap</th>
                    <th width="15%">No. Telepon</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $index => $guru)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $guru->nip }}</td>
                        <td>
                            <strong>{{ $guru->nama_guru }}</strong><br>
                            <span style="font-size: 9pt; color: #555;">{{ $guru->email }}</span>
                        </td>
                        <td>{{ $guru->no_hp ?? '-' }}</td>
                        <td style="text-align: center;">{{ $guru->status_kepegawaian ?? 'Aktif' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 40px; float: right; width: 250px; text-align: center;">
            Bandung, {{ date('d F Y') }} <br>
            Kepala Tata Usaha,
            <br><br><br><br>
            _______________________
        </div>
    </div>
</body>

</html>
