<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Piagam Penghargaan</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', serif;
            color: #000;
            background-image: url('{{ public_path('img/bg_piagam.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 3cm 2.5cm;
        }

        .text-center { text-align: center; }
        .mt-2 { margin-top: 8px; }
        .mt-8 { margin-top: 24px; }
        .mt-10 { margin-top: 40px; }
        .mt-12 { margin-top: 60px; }
        .mt-16 { margin-top: 80px; }
        .underline { text-decoration: underline; }

        h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        table { width: 100%; border-collapse: collapse; }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div class="text-center">
        <img src="{{ public_path('img/logo_tutwuri.png') }}" width="90" alt="Logo Tut Wuri">
        <div class="mt-2">
            <h3 style="text-transform: uppercase;">PEMERINTAH KABUPATEN {{ $user->detail->kabupaten }}</h3>
            <h3 style="text-transform: uppercase;">DINAS PENDIDIKAN</h3>
            <h2 style="font-size:20px; text-transform: uppercase;">{{ $user->detail->asal_sekolah }}</h2>
            <h3 style="font-size:14px; text-transform: uppercase;">KECAMATAN {{ $user->detail->kecamatan }}</h3>
            <p style="font-size:12px;">{{ $user->detail->alamat }} | Telp. {{ $user->detail->telp_sekolah }}</p>
            <p style="font-size:11px;">Email: {{ $user->detail->email_sekolah }} | Website: {{ $user->detail->web_sekolah }}</p>
        </div>
    </div>

    {{-- TITLE --}}
    <div class="text-center mt-10">
        <h1 style="font-size:28px; font-weight:bold;">PIAGAM PENGHARGAAN</h1>
        <p style="margin-top:8px; font-size:14px;">
            Nomor: {{ $nomorSurat ?: '421.2/___/SDIT.AM/' . date('Y') }}
        </p>
    </div>

    {{-- RECIPIENT --}}
    <div class="text-center mt-10">
        <h3 style="font-size:16px; margin-bottom:10px;">Diberikan Kepada</h3>
        <h1 style="font-size:22px; font-weight:bold; margin-bottom:10px;">{{ $siswa->nama ?? 'Nama Siswa' }}</h1>
        <h3 style="font-size:16px; margin-bottom:5px;">Sebagai</h3>
        <h1 style="font-size:22px; font-weight:bold;">Peringkat Ke - {{ $peringkat ?? '-' }}</h1>
    </div>

    {{-- DESCRIPTION --}}
    <div class="text-center mt-8" style="line-height:1.6; font-size:15px;">
        <p>
            Atas prestasi belajar dengan jumlah total nilai <b>{{ $totalNilai ?? '-' }}</b>. <br>
            Pada kelas {{ $user->detail->kelas ?? '-' }} Tahun Pelajaran {{ $user->detail->tahun_ajaran ?? date('Y') }}. <br>
            Semoga prestasi ini menjadi motivasi untuk meraih kesuksesan di masa depan.
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="mt-12">
        <table>
            <tr>
                <td class="text-center" style="font-size:14px;">
                    Mengetahui, <br>
                    Kepala Sekolah {{ $user->detail->asal_sekolah ?? 'Nama Sekolah' }}<br><br><br><br>
                    <b><u>{{ $user->detail->nama_kepala_sekolah ?? 'Nama Kepala Sekolah' }}</u></b><br>
                    {{ $user->detail->nip_kepala_sekolah ?? '-' }}
                </td>

                <td class="text-center" style="font-size:14px;">
                    @php
                        // Pastikan tanggal dalam format Indonesia
                        \Carbon\Carbon::setLocale('id');
                        $bulanIndonesia = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $tanggal = \Carbon\Carbon::parse($tanggalPiagam);
                        $formattedTanggal = $tanggal->day . ' ' . $bulanIndonesia[$tanggal->month] . ' ' . $tanggal->year;
                    @endphp

                    {{ $user->detail->kabupaten }}, {{ $formattedTanggal }} <br>
                    Guru Kelas<br><br><br><br>
                    <b><u>{{ $user->detail->name ?? 'Nama Guru' }}</u></b><br>
                    {{ $user->detail->nip ?? '-' }}
                </td>
            </tr>
        </table>

        <div class="text-center mt-10">
            <img src="{{ public_path('img/trophy.png') }}" width="80" alt="Trophy">
        </div>
    </div>
</body>
</html>
