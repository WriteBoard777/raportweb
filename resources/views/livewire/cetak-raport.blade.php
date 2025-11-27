<section class="w-full">
    <header class="mb-5">
        <h1 class="text-xl font-bold">Preview Raport Siswa</h1>
        <p class="text-gray-600 dark:text-gray-400">Periksa data raport sebelum dicetak</p>
    </header>

    {{-- Tombol Aksi --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:button wire:navigate href="{{ route('raport.index') }}">
                ← Kembali
            </flux:button>
        </div>
        <div class="flex gap-3 items-end">
            {{-- Input Tanggal Cetak --}}
            <div>
                <label class="block text-xs font-semibold mb-1">Tanggal Cetak:</label>
                <input type="date" wire:model.defer="tanggalCetak" class="border rounded-md p-2 text-sm dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Pilihan Orang Tua --}}
            <div>
                <label class="block text-xs font-semibold mb-1">Nama Orang Tua:</label>
                <select wire:model.defer="namaOrtuTerpilih" class="border rounded-md p-2 text-sm dark:bg-gray-700 dark:text-white">
                    <option value="">-- Pilih Orang Tua --</option>
                    @php
                        $ortu = $siswa->nama_orang_tua;
                    @endphp
                    @if(isset($ortu[0]))
                        <option value="{{ $ortu[0] }}">{{ $ortu[0] }} (Ayah)</option>
                    @endif
                    @if(isset($ortu[1]))
                        <option value="{{ $ortu[1] }}">{{ $ortu[1] }} (Ibu)</option>
                    @endif
                </select>
            </div>

            {{-- Tombol Cetak --}}
            <div>
                <flux:button wire:click="exportPdf" variant="primary">
                    Cetak PDF
                </flux:button>
            </div>
        </div>
    </div>


    {{-- Info Siswa --}}
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p><strong>Nama:</strong> {{ $siswa->nama ?? '-' }}</p>
                <p><strong>NIS:</strong> {{ $siswa->nis ?? '-' }}</p>
                <p><strong>Kelas:</strong> {{ Auth::user()->detail->kelas ?? '-' }}</p>
            </div>
            <div>
                <p><strong>Wali Kelas:</strong> {{ Auth::user()->detail->name ?? '-' }}</p>
                <p><strong>Sekolah:</strong> {{ Auth::user()->detail->asal_sekolah ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Nilai Akademik --}}
    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900 mb-6">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Mata Pelajaran</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Nilai Harian</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">UTS</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">UAS</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach ($nilai as $i => $n)
                    @php
                        $nilaiAkhir = round((($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0)) / 3);
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                        <td class="px-4 py-2 text-sm">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-sm">{{ $n->nilai_harian ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-sm">{{ $n->nilai_uts ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-sm">{{ $n->nilai_uas ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-sm font-semibold">{{ $nilaiAkhir }}</td>
                    </tr>

                    {{-- Deskripsi TP --}}
                    <tr class="bg-gray-50 dark:bg-gray-800/40">
                        <td colspan="5" class="px-4 py-2">
                            <label class="block text-xs font-semibold mb-1">Deskripsi Atas:</label>
                            <select wire:model.defer="deskripsiAtas.{{ $n->mapel_id }}" class="w-full text-sm border rounded-md p-2 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Deskripsi --</option>
                                @foreach ($tps[$n->mapel_id] ?? [] as $tp)
                                    @foreach ($tp->deskripsi_list as $deskripsi)
                                        <option  value="{{ $deskripsi }}">{{ $deskripsi }}</option>
                                    @endforeach
                                @endforeach
                            </select>

                            <label class="block text-xs font-semibold mt-2 mb-1">Deskripsi Bawah:</label>
                            <select wire:model.defer="deskripsiBawah.{{ $n->mapel_id }}" class="w-full text-sm border rounded-md p-2 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Deskripsi --</option>
                                @foreach ($tps[$n->mapel_id] ?? [] as $tp)
                                    @foreach ($tp->deskripsi_list as $deskripsi)
                                        <option value="{{ $deskripsi }}">{{ $deskripsi }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Nilai Ekstrakurikuler --}}
    @if($nilaiEkstra->count())
    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900 mb-6">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Ekstrakurikuler</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nilaiEkstra as $e)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                        <td class="px-4 py-2 text-sm">{{ $e->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-sm">{{ $e->nilai ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Absensi --}}
    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900 mb-6">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Keterangan Absensi</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Jumlah Hari</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 text-sm">Sakit</td>
                    <td class="px-4 py-2 text-center text-sm">{{ $absen->sakit ?? 0 }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-sm">Izin</td>
                    <td class="px-4 py-2 text-center text-sm">{{ $absen->izin ?? 0 }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-sm">Alpa</td>
                    <td class="px-4 py-2 text-center text-sm">{{ $absen->alfa ?? 0 }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @php
        $semesterLower = strtolower(trim($semester));
        $isGenap = in_array($semesterLower, ['2', 'genap']);
    @endphp

    @if ($isGenap)
        <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-white w-2/5">
            <label class="block text-xs font-semibold mb-1">Keputusan:</label>

            @if ($romawi === 'VI')
                <select wire:model.defer="keputusanTerpilih" class="w-full text-sm border rounded-md p-2 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Pilih Keputusan --</option>
                    <option value="LULUS dari Satuan Pendidikan">LULUS dari Satuan Pendidikan</option>
                    <option value="TIDAK LULUS">TIDAK LULUS</option>
                </select>
            @else
                @php
                    $romawiMap = ['I','II','III','IV','V', 'VI'];
                    $nextIndex = array_search($romawi, $romawiMap);
                    $kelasNaik = $nextIndex !== false && $nextIndex < count($romawiMap) - 1
                        ? $romawiMap[$nextIndex + 1]
                        : null;
                @endphp

                <select wire:model.defer="keputusanTerpilih" class="w-full text-sm border rounded-md p-2 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Pilih Keputusan --</option>
                    @if($kelasNaik)
                        <option value="NAIK ke kelas {{ $kelasNaik }}">NAIK ke kelas {{ $kelasNaik }}</option>
                    @endif
                    <option value="TIDAK NAIK">TIDAK NAIK</option>
                </select>
            @endif
        </div>
    @else
        <div class="border rounded-lg p-4 bg-blue-50 text-gray-800 w-2/5">
            <p><strong>Keputusan :</strong></p>
            <p>Semester ini masih berlangsung. Keputusan naik/lulus akan ditentukan di akhir tahun.</p>
        </div>
    @endif
</section>
