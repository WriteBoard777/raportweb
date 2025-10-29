<section class="w-full">
    <header class="mb-5">
        <h1>Raport Siswa</h1>
        <p>Menampilkan nilai rata-rata siswa berdasarkan hasil belajar.</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <flux:input wire:model.live="search" placeholder="Cari siswa..." class="w-sm" />
    </div>

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nama Siswa</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">NIS</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Rata-rata Nilai</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($raport as $index => $siswa)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                        <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm">{{ $siswa['nama'] }}</td>
                        <td class="px-4 py-3 text-sm">{{ $siswa['nis'] }}</td>
                        <td class="px-4 py-3 text-center text-sm font-semibold">
                            {{ $siswa['rata_rata'] }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <flux:button 
                                wire:navigate
                                href="{{ route('raport.cetak', ['siswaId' => $siswa['id']]) }}">
                                Cetak Raport
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">
                            Tidak ada data siswa ditemukan atau belum memiliki nilai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
