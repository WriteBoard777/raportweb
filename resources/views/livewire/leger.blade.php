<section class="w-full">
    <header class="mb-5">
        <h1>Leger Nilai</h1>
        <p>Menampilkan Nilai Siswa per Mapel Aktif</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <flux:input wire:model.live="search" placeholder="Cari siswa..." class="w-sm" />
        <flux:button wire:click.stop="exportPdf">
            Cetak PDF
        </flux:button>
    </div>

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nama Siswa</th>
                    @foreach($activeMapels as $mapel)
                        <th class="px-4 py-2 text-center text-sm font-semibold">{{ $mapel->kode_mapel }}</th>
                    @endforeach
                    <th class="px-4 py-2 text-center text-sm font-semibold">Jumlah Nilai</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Rata-rata</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach($siswas as $loopIndex => $siswa)
                    @php
                        $totalNilai = 0;
                        $mapelCount = count($activeMapels);
                    @endphp
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm">{{ $siswa->nama }}</td>

                        @foreach($activeMapels as $mapel)
                            @php
                                $nilai = $nilaiData[$siswa->id]->firstWhere('mapel_id', $mapel->id) ?? null;
                                $nilaiAkhir = $nilai ? round(($nilai->nilai_harian + $nilai->nilai_uts + $nilai->nilai_uas)/3) : null;
                                $totalNilai += $nilaiAkhir ?? 0;
                            @endphp
                            <td class="px-4 py-3 text-center">{{ $nilaiAkhir ?? '-' }}</td>
                        @endforeach

                        <td class="px-4 py-3 text-center">{{ $totalNilai }}</td>
                        <td class="px-4 py-3 text-center">{{ $mapelCount ? round($totalNilai/$mapelCount) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $siswas->links() }}
    </div>
</section>
