<section class="w-full">
    <header class="mb-5">
        <h1>Data Mapel</h1>
        <p>Pilih Mapel Aktif untuk Digunakan di TP dan Nilai</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <flux:input wire:model.live="search" placeholder="Cari Mapel..." class="w-sm" />
        <flux:button wire:click.stop="$dispatch('openMapelForm')">
            Pilih Mapel Aktif
        </flux:button>
    </div>

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nama Mapel</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Kode Mapel</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($mapels as $mapel)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm">{{ $mapel->nama_mapel }}</td>
                        <td class="px-4 py-3 text-sm">{{ $mapel->kode_mapel }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if ($mapel->is_active)
                                <span class="text-green-600 font-semibold">Aktif</span>
                            @else
                                <span class="text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada data mapel</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <livewire:mapel.form />
</section>
