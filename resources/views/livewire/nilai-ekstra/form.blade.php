<div>
    {{-- 🔹 Modal Create / Edit --}}
    <flux:modal wire:model="showForm">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>{{ $siswaId ? 'Edit Nilai Ekstrakurikuler' : 'Tambah Nilai Ekstrakurikuler' }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:select wire:model="nilai" label="Nilai">
                    <option value="">-- Pilih Nilai --</option>
                    <option value="A">A - Sangat Baik</option>
                    <option value="B">B - Baik</option>
                    <option value="C">C - Cukup</option>
                    <option value="D">D - Kurang</option>
                </flux:select>

                <flux:input wire:model="deskripsi" label="Deskripsi" placeholder="Deskripsi otomatis diisi..." readonly />
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- 🔹 Modal Konfirmasi Delete --}}
    <flux:modal wire:model="showDelete">
        <flux:heading>Konfirmasi Hapus Nilai Ekstrakurikuler</flux:heading>
        <p class="text-gray-600 dark:text-gray-300">
            Apakah kamu yakin ingin menghapus nilai ekstrakurikuler siswa ini?
        </p>

        <div class="flex justify-end gap-3 mt-6">
            <flux:button wire:click="$set('showDelete', false)">Batal</flux:button>
            <flux:button variant="danger" wire:click="delete">Hapus</flux:button>
        </div>
    </flux:modal>
</div>
