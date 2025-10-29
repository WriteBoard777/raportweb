<div>
    {{-- 🔹 Modal Create / Edit --}}
    <flux:modal wire:model="showForm" class="max-w-4xl w-full">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>{{ $siswaId ? 'Edit Nilai' : 'Tambah Nilai' }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:input wire:model="nilaiHarian" label="Nilai Harian" type="number" min="0" max="100"/>
                <flux:input wire:model="nilaiUTS" label="Nilai UTS" type="number" min="0" max="100"/>
                <flux:input wire:model="nilaiUAS" label="Nilai UAS" type="number" min="0" max="100"/>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- 🔹 Modal Konfirmasi Delete --}}
    <flux:modal wire:model="showDelete">
        <flux:heading>Konfirmasi Hapus Nilai</flux:heading>
        <p class="text-gray-600 dark:text-gray-300">
            Apakah kamu yakin ingin menghapus nilai siswa ini untuk mapel yang dipilih?
        </p>

        <div class="flex justify-end gap-3 mt-6">
            <flux:button wire:click="$set('showDelete', false)">Batal</flux:button>
            <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
        </div>
    </flux:modal>
</div>
