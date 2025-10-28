<section class="w-full">
    <header class="mb-5">
        <h1>Absensi Siswa</h1>
        <p>Kelola data kehadiran siswa (sakit, izin, alfa)</p>
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
                    <th class="px-4 py-2 text-center text-sm font-semibold">Sakit</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Izin</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Alfa</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($siswas as $index => $siswa)
                    @php
                        $nomor = ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1;
                        $absen = $absenData[$siswa->id] ?? null;
                    @endphp

                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $nomor }}</td>
                        <td class="px-4 py-3 text-sm">{{ $siswa->nama }}</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $absen?->sakit ?? 0 }}</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $absen?->izin ?? 0 }}</td>
                        <td class="px-4 py-3 text-center text-sm">{{ $absen?->alfa ?? 0 }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <flux:button size="sm"
                                    wire:click.stop="$dispatch('openAbsenForm', { siswaId: '{{ $siswa->id }}' })">
                                    Edit
                                </flux:button>
                                <flux:button size="sm" variant="danger"
                                    wire:click.stop="$dispatch('confirmDeleteAbsen', { siswaId: '{{ $siswa->id }}' })">
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

    {{-- Komponen Form --}}
    <livewire:absen.form />
</section>
