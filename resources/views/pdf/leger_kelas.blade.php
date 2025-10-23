<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leger Nilai Kelas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <h2>Leger Nilai Kelas</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                @foreach($mapels as $mapel)
                    <th>{{ $mapel->nama_mapel }}</th>
                @endforeach
                <th>Jumlah Nilai</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $i => $siswa)
                @php
                    $totalNilai = 0;
                    $mapelCount = count($mapels);
                @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td class="text-left">{{ $siswa->nama }}</td>
                    @foreach($mapels as $mapel)
                        @php
                            $nilai = $nilaiData[$siswa->id]->firstWhere('mapel_id', $mapel->id) ?? null;
                            $nilaiAkhir = $nilai ? round(($nilai->nilai_harian + $nilai->nilai_uts + $nilai->nilai_uas)/3) : null;
                            $totalNilai += $nilaiAkhir ?? 0;
                        @endphp
                        <td>{{ $nilaiAkhir ?? '-' }}</td>
                    @endforeach
                    <td>{{ $totalNilai }}</td>
                    <td>{{ $mapelCount ? round($totalNilai/$mapelCount) : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
