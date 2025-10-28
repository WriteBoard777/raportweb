<section class="w-full">
    <header class="mb-5">
        <h1 class="text-xl font-semibold">Data Ekstrakurikuler</h1>
        <p class="text-gray-600 dark:text-gray-300">Kelola daftar kegiatan ekstrakurikuler yang tersedia.</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <flux:input wire:model.live="search" placeholder="Cari ekstrakurikuler..." class="w-sm" />
        <flux:button wire:click.stop="$dispatch('openEkstraForm')">
            + Tambah Ekstrakurikuler
        </flux:button>
    </div>

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nama Ekstrakurikuler</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($ekstras as $index => $e)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm">{{ $e->nama_ekstrakurikuler }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm"
                                    wire:click.stop="$dispatch('openEkstraForm', { id: '{{ $e->id }}' })">
                                    Edit
                                </flux:button>

                                <flux:button size="sm" variant="danger"
                                    wire:click.stop="$dispatch('confirmDeleteEkstra', { id: '{{ $e->id }}'})">
                                    Hapus
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada data ekstrakurikuler</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Komponen form modal --}}
    <livewire:ekstra.form />
</section>
