<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Pelajaran - SMK Marhas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11pt;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .hari-row {
            background: #e0e0e0;
            font-weight: bold;
            text-transform: uppercase;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align:center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding:10px 20px; background:emerald; color:white; cursor:pointer;">Cetak
            Jadwal</button>
        <a href="{{ route('tu.schedules.index') }}">Kembali</a>
    </div>

    <div class="header">
        <h2>JADWAL PELAJARAN SMK MARHAS</h2>
        <h3>{{ $namaKelas }}</h3>
    </div>

    @foreach ($schedules as $hari => $items)
        <table>
            <thead>
                <tr>
                    <th colspan="4" class="hari-row">{{ $hari }}</th>
                </tr>
                <tr>
                    <th width="20%">Jam</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru</th>
                    <th width="15%">Kelas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $s)
                    <tr>
                        <td>{{ substr($s->jam_mulai, 0, 5) }} - {{ substr($s->jam_selesai, 0, 5) }}</td>
                        <td>{{ $s->subject->nama_mapel }}</td>
                        <td>{{ $s->teacher->nama_guru }}</td>
                        <td>{{ $s->kelas->nama_kelas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
