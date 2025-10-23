<div>
    <flux:modal wire:model="showForm">
        <flux:heading>Pilih Mapel Aktif</flux:heading>

        <div class="space-y-2 mt-4">
            @foreach ($mapels as $mapel)
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="activeMapels" value="{{ $mapel->id }}" id="mapel_{{ $mapel->id }}">
                    <label for="mapel_{{ $mapel->id }}">{{ $mapel->nama_mapel }}</label>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end gap-2 mt-6">
            <flux:button wire:click="$set('showForm', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save">Simpan</flux:button>
        </div>
    </flux:modal>
</div>
