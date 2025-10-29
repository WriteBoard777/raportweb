<div>
    {{-- 🔹 Modal Tambah / Edit --}}
    <flux:modal wire:model="showForm" class="max-w-3xl w-full">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>{{ $ekstraId ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler' }}</flux:heading>

            <flux:input
                wire:model="nama_ekstrakurikuler"
                placeholder="Contoh: Pramuka, Hadrah, Paskibra"
                required
            />

            @error('nama_ekstrakurikuler')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-2 mt-6">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- 🔹 Modal Konfirmasi Hapus --}}
    <flux:modal wire:model="showDelete">
        <flux:heading class="mb-5">Konfirmasi Hapus</flux:heading>
        <p class="text-gray-600 dark:text-gray-300">
            Apakah kamu yakin ingin menghapus ekstrakurikuler ini?
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
