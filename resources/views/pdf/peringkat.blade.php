<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peringkat Siswa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #555;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>

    <h2>Laporan Peringkat Siswa</h2>
    <div class="info">
        <p><strong>Nama Pengguna:</strong> {{ $user->name }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>Rata-rata Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peringkat as $index => $siswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $siswa['nama'] }}</td>
                    <td>{{ $siswa['nis'] }}</td>
                    <td>{{ $siswa['total_nilai'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data siswa tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
