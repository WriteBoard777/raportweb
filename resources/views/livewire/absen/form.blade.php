<div>
    {{-- Modal Form --}}
    <flux:modal wire:model="showForm">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>{{ $siswaId ? 'Edit Absensi' : 'Tambah Absensi' }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:input wire:model="sakit" label="Sakit" type="number" min="0" />
                <flux:input wire:model="izin" label="Izin" type="number" min="0" />
                <flux:input wire:model="alfa" label="Alfa" type="number" min="0" />
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Modal Delete --}}
    <flux:modal wire:model="showDelete">
        <flux:heading>Konfirmasi Hapus Absen</flux:heading>
        <p class="text-gray-600 dark:text-gray-300">Apakah kamu yakin ingin menghapus data absen siswa ini?</p>

        <div class="flex justify-end gap-3 mt-6">
            <flux:button wire:click="$set('showDelete', false)">Batal</flux:button>
            <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
        </div>
    </flux:modal>
</div>
