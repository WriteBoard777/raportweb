<section class="w-full">
    <header class="mb-5">
        <h1>Nilai Siswa</h1>
        <p>Kelola Nilai Harian, UTS, dan UAS</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <div class="flex gap-4">
            <flux:input wire:model.live="search" placeholder="Cari siswa..." class="w-sm" />

            <flux:button variant="primary" wire:click="$dispatch('openNilaiMassal', { mapelId: '{{ $mapelId }}' })">
                Masukkan Nilai
            </flux:button>
        </div>
        <flux:select wire:model.live="mapelId" label="Pilih Mapel">
            <option value="">-- Pilih Mapel --</option>
            @foreach ($activeMapels as $mapel)
                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
            @endforeach
        </flux:select>

    </div>


    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nama Siswa</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nilai Akhir</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Progress</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($siswas as $index => $siswa)
                    @php
                        $nomor = ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1;
                    
                        $nilai = $nilaiData[$siswa->id] ?? null;
                    
                        // Ambil nilai dan ubah null/kosong menjadi 0 untuk perhitungan
                        $nilaiHarian = is_numeric($nilai?->nilai_harian) ? $nilai->nilai_harian : 0;
                        $nilaiUTS    = is_numeric($nilai?->nilai_uts) ? $nilai->nilai_uts : 0;
                        $nilaiUAS    = is_numeric($nilai?->nilai_uas) ? $nilai->nilai_uas : 0;
                    
                        // Hitung nilai akhir (selalu dihitung, meskipun ada nilai kosong)
                        $nilaiAkhir = round(($nilaiHarian + $nilaiUTS + $nilaiUAS) / 3);
                    
                        // Deteksi mana yang belum diisi (null atau kosong)
                        $belumDiisi = [];
                        if ($nilai?->nilai_harian === null || $nilai?->nilai_harian === '') $belumDiisi[] = 'Harian';
                        if ($nilai?->nilai_uts === null || $nilai?->nilai_uts === '') $belumDiisi[] = 'UTS';
                        if ($nilai?->nilai_uas === null || $nilai?->nilai_uas === '') $belumDiisi[] = 'UAS';
                    
                        $progress = empty($belumDiisi) ? 'lengkap' : 'belum';
                    @endphp


                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $nomor }}</td>
                        <td class="px-4 py-3 text-sm">{{ $siswa->nama }}</td>
                        <td class="px-4 py-3 text-sm">{{ $nilaiAkhir ?? '0' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($progress == 'lengkap')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-500 text-white">
                                    Lengkap
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-500 text-black"
                                      title="Belum diisi: {{ implode(', ', $belumDiisi) }}">
                                    Belum Lengkap ({{ implode(', ', $belumDiisi) }})
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm"
                                    wire:click.stop="$dispatch('openNilaiForm', { siswaId: '{{ $siswa->id }}', mapelId: '{{ $mapelId }}' })">
                                    Edit
                                </flux:button>

                                <flux:button size="sm" variant="danger"
                                    wire:click.stop="$dispatch('confirmDeleteNilai', { siswaId: '{{ $siswa->id }}',  mapelId: '{{ $mapelId }}'})">
                                    Hapus
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data siswa</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $siswas->links() }}
    </div>

    {{-- Komponen Form Nilai --}}
    <livewire:nilai.form />
    <livewire:nilai.form-massal />

</section>
