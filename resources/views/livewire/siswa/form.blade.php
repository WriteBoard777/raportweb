<div>
    <flux:modal wire:model="showForm">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>{{ $siswaId ? 'Edit Siswa' : 'Tambah Siswa' }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input wire:model="nisn" label="NISN" required />
                <flux:input wire:model="nis" label="NIS" required />
                <flux:input wire:model="nama" label="Nama" required />
                <flux:select wire:model="jenis_kelamin" label="Jenis Kelamin" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </flux:select>
                <flux:input wire:model="nama_orang_tua.0" label="Nama Ayah" />
                <flux:input wire:model="nama_orang_tua.1" label="Nama Ibu" />
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- 🔹 Modal Konfirmasi Hapus --}}
    <flux:modal wire:model="showDelete">
        <flux:heading>Konfirmasi Hapus</flux:heading>
        <p class="text-gray-600 dark:text-gray-300">
            Apakah kamu yakin ingin menghapus siswa ini?
        </p>

        <div class="flex justify-end gap-3 mt-6">
            <flux:button wire:click="$set('showDelete', false)">
                Batal
            </flux:button>

            <flux:button variant="danger" wire:click="delete">
                Hapus
            </flux:button>
        </div>
    </flux:modal>
</div>