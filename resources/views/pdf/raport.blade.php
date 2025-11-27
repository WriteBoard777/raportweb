<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Raport - {{ $siswa->nama }}</title>
        <style>
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }

            body {
                font-family: 'Times New Roman', serif;
                font-size: 11pt;
                color: #000;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                page-break-inside: auto; /* biar tabel bisa pecah */
            }

            th, td {
                padding: 6px 8px;
                vertical-align: top;
                border: 1px solid #000;
            }

            thead {
                display: table-header-group; /* ← ini penting */
            }

            tfoot {
                display: table-footer-group; /* opsional, kalau ingin footer ikut juga */
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            /* sisanya tetap */
            .table-sm th, .table-sm td { padding: 4px 6px; }
            .table-borderless td, .table-borderless th { border: none !important; }
            .table-bordered td, .table-bordered th { border: 1px solid #000 !important; }
            .text-center { text-align: center; }
            .text-dark { color: #000; }
            .fw-800 { font-weight: 800; }
            .text-decoration-underline { text-decoration: underline; }
            .wrap-text { word-wrap: break-word; white-space: normal; }
            .mb-3 { margin-bottom: 1rem; }
            .mb-5 { margin-bottom: 2rem; }
            .fs-4 { font-size: 18pt; }
            .bg-primary {
                background-color: #ABD9EB !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        </style>
    </head>

    <body>
        <div class="container">
            {{-- HEADER --}}
            <div class="text-center mb-5">
                <h3 class="fw-800">LAPORAN HASIL BELAJAR (RAPOR)</h3>
            </div>

            {{-- DATA SISWA --}}
            <table class="table-sm table-borderless" style="margin-bottom: 10px;">
                <tr>
                    <td>Nama Peserta Didik</td>
                    <td>:</td>
                    <td class="fw-800">{{ $siswa->nama }}</td>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $user->detail->kelas ?? '-' }}</td>
                </tr>

                @php
                    // Ambil kelas dari user
                    $kelas = strtoupper(trim($user->detail->kelas ?? '-'));

                    // Ambil hanya bagian romawinya (I, II, III, IV, V, VI)
                    preg_match('/^(I{1,3}|IV|V|VI)/', $kelas, $match);
                    $romawi = $match[0] ?? '';

                    // Tentukan fase berdasarkan romawi
                    $fase = match ($romawi) {
                        'I', 'II' => 'A',
                        'III', 'IV' => 'B',
                        'V', 'VI' => 'C',
                        default => '-',
                    };
                @endphp

                <tr>
                    <td>NISN / NIS</td>
                    <td>:</td>
                    <td>{{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</td>
                    <td>Fase</td>
                    <td>:</td>
                    <td>{{ $fase }}</td>
                </tr>

                <tr>
                    <td>Sekolah</td>
                    <td>:</td>
                    <td>{{ $user->detail->asal_sekolah ?? '-' }}</td>
                    <td>Semester</td>
                    <td>:</td>
                    <td>{{ $user->detail->semester ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $user->detail->alamat ?? '-' }}</td>
                    <td>Tahun Pelajaran</td>
                    <td>:</td>
                    <td>{{ $user->detail->tahun_ajaran ?? date('Y') }}</td>
                </tr>
            </table>

            {{-- NILAI AKADEMIK --}}
            <table class="table-sm mb-3" style="table-layout: fixed;">
                <thead class="text-center bg-primary text-dark">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%">Mata Pelajaran</th>
                        <th style="width: 10%">Nilai Akhir</th>
                        <th style="width: 60%;">Capaian Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nilai as $i => $n)
                        @php
                            $nilaiAkhir = round((($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0)) / 3);
                            $atas = $deskripsiAtas[$n->mapel_id] ?? '-';
                            $bawah = $deskripsiBawah[$n->mapel_id] ?? '-';
                        @endphp

                        <tr>
                            <td class="text-center" rowspan="2">{{ $i + 1 }}</td>
                            <td class="wrap-text" rowspan="2">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                            <td class="text-center" rowspan="2">{{ $nilaiAkhir }}</td>
                            <td class="wrap-text">{{ $siswa->nama_pgl ?? $siswa->nama }} tercapai dalam {{ $atas }}</td>
                        </tr>
                        <tr>
                            <td class="wrap-text">{{ $siswa->nama_pgl ?? $siswa->nama }} perlu pendampingan dalam {{ $bawah }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Tidak ada data nilai</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{-- NILAI EKSTRAKURIKULER --}}
            <table class="table-sm mb-3" style="table-layout: fixed;">
                <thead class="text-center bg-primary text-dark">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 35%">Ekstrakurikuler</th>
                        <th style="width: 60%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nilaiEkstra as $e => $item)
                        <tr>
                            <td class="text-center">{{ $e + 1 }}</td>
                            <td class="wrap-text">{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td class="wrap-text">{{ $item->nilai ?? '-' }} (Ananda {{ $siswa->nama_pgl }} {{ $item->deskripsi ?? '-' }})</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Tidak ada data ekstrakurikuler</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ABSENSI & KEPUTUSAN --}}
            <table class="table-borderless" style="width: 100%; margin-top: 10px; table-layout: fixed; padding: 0;">
                <tr>
                    {{-- Kolom 1: Ketidakhadiran --}}
                    <td style="width: 50%; vertical-align: top;">
                        <table class="table-sm table-bordered" style="width: 100%">
                            <thead>
                                <tr class="text-center bg-primary text-dark">
                                    <th colspan="3">Ketidakhadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Sakit</td><td>:</td><td>{{ $absen->sakit ?? 0 }} hari</td></tr>
                                <tr><td>Izin</td><td>:</td><td>{{ $absen->izin ?? 0 }} hari</td></tr>
                                <tr><td>Tanpa Keterangan</td><td>:</td><td>{{ $absen->alfa ?? 0 }} hari</td></tr>
                            </tbody>
                        </table>
                    </td>

                    {{-- Kolom 2: Keputusan --}}
                    @php
                        // Ambil semester
                        $semesterLower = strtolower(trim($user->detail->semester ?? '-'));
                        $isGenap = in_array($semesterLower, ['2', 'genap']);

                        // Ambil kelas romawi (I, II, III, IV, V, VI)
                        $kelas = strtoupper(trim($user->detail->kelas ?? '-'));
                        preg_match('/^(I{1,3}|IV|V|VI)/', $kelas, $match);
                        $romawi = $match[0] ?? '';

                        // Tentukan keputusan otomatis kalau belum diset
                        $keputusan = $keputusanText ?? null;

                        if (!$keputusan && $isGenap) {
                            if ($romawi === 'VI') {
                                $keputusan = 'LULUS dari Satuan Pendidikan';
                            } else {
                                $romawiMap = ['I','II','III','IV','V','VI'];
                                $nextIndex = array_search($romawi, $romawiMap);
                                $kelasNaik = $nextIndex !== false && $nextIndex < count($romawiMap) - 1
                                    ? $romawiMap[$nextIndex + 1]
                                    : null;
                                $keputusan = $kelasNaik ? "NAIK ke kelas $kelasNaik" : "TIDAK NAIK";
                            }
                        } elseif (!$keputusan && !$isGenap) {
                            $keputusan = 'Semester ini masih berlangsung. Keputusan naik/lulus akan ditentukan di akhir tahun.';
                        }
                    @endphp

                    <td style="width: 50%; vertical-align: top;">
                        @if ($isGenap)
                            <table class="table-sm table-bordered" style="width: 100%;">
                                <tbody class="text-dark">
                                    <tr>
                                        <td>
                                            <strong>Keputusan :</strong><br>
                                            <p style="margin: 4px 0;">
                                                Berdasarkan pencapaian seluruh kompetensi, peserta didik dinyatakan :
                                            </p>
                                            <strong>{{ $keputusan }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- TANDA TANGAN --}}
            <div style="margin-top: 50px;">
                <table class="table-borderless text-center">
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            {{ $user->detail->kabupaten }}, {{
                                \Carbon\Carbon::parse($tanggalCetak)
                                    ->locale('id') // ubah locale ke Indonesia
                                    ->timezone('Asia/Jakarta') // opsional, untuk zona waktu Indonesia
                                    ->translatedFormat('d F Y')
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td>Orang Tua / Wali</td>
                        <td></td>
                        <td>Wali Kelas {{ $user->detail->kelas }}</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br><u><strong>{{ $namaOrtu ?? '-' }}</u></strong></td>
                        <td></td>
                        <td><br><br><br><br><u><strong>{{ $user->detail->name }}</u><br>{{ $user->detail->nip ?? '-' }}</strong></td>
                    </tr>
                    <tr><td colspan="3" style="height: 40px;"></td></tr>
                    <tr>
                        <td></td>
                        <td>Mengetahui,</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Kepala {{ $user->detail->asal_sekolah }}</td>
                        <td></td>
                    </tr>
                    <tr><td colspan="3" style="height: 50px;"></td></tr>
                    <tr>
                        <td></td>
                        <td><u><strong>{{ $user->detail->nama_kepala_sekolah }}</u><br>{{ $user->detail->nip_kepala_sekolah }}</strong></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

    </body>
</html>
