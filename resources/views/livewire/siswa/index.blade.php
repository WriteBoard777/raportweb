<section class="w-full">
    <header class="mb-5">
        <h1>Data Siswa</h1>
        <p>Kelola Data Siswa di Sistem Raport</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <flux:input wire:model.live="search" placeholder="Cari siswa..." class="w-sm" />

        <div class="flex gap-2">
            <flux:button wire:click.stop="$dispatch('openForm')">+ Tambah Siswa</flux:button>
            <flux:button wire:click.stop="$dispatch('openImport')">Import Excel</flux:button>
        </div>
    </div>

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">NISN</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">NIS</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Jenis Kelamin</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Orang Tua</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($siswas as $index => $s)
                    @php
                        $nomor = ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1;
                    @endphp
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $nomor }}</td>
                        <td class="px-4 py-3 text-sm">{{ $s->nisn }}</td>
                        <td class="px-4 py-3 text-sm">{{ $s->nis }}</td>
                        <td class="px-4 py-3 text-sm">{{ $s->nama }}</td>
                        <td class="px-4 py-3 text-sm">{{ $s->jenis_kelamin }}</td>
                        <td class="px-4 py-3 text-sm">
                            {{ implode(', ', $s->nama_orang_tua) }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm" 
                                    wire:click.stop="$dispatch('openForm', { id: '{{ $s->id }}' })">
                                    Edit
                                </flux:button>

                                {{-- Tombol Hapus --}}
                                <flux:button size="sm" variant="danger"
                                    wire:click.stop="$dispatch('confirmDelete', { id: '{{ $s->id }}'})">
                                    Hapus
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data siswa</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $siswas->links() }}
    </div>



    {{-- Komponen form modal --}}
    <livewire:siswa.form />
    <livewire:siswa.import />
</section>
