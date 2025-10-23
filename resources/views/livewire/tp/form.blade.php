<div>
    <flux:modal wire:model="showForm">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>{{ $tpId ? 'Edit TP' : 'Tambah TP' }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:select wire:model="mapel_id" label="Pilih Mapel" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </flux:select>

                <div class="col-span-1 md:col-span-2">
                    <label class="block font-medium mb-1">Deskripsi</label>
                    @foreach ($deskripsis as $i => $desc)
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" wire:model="deskripsis.{{ $i }}" class="flex-1 border rounded px-2 py-1" />
                            <button type="button" wire:click="removeDeskripsi({{ $i }})"
                                class="px-2 py-1 bg-red-500 text-white rounded">Hapus</button>
                        </div>
                    @endforeach
                    <button type="button" wire:click="addDeskripsi"
                        class="px-3 py-1 bg-green-500 text-white rounded mt-2">Tambah Deskripsi</button>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
