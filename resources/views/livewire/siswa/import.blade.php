<div>
    <flux:modal wire:model="showImport" class="max-w-lg w-full">
        <form wire:submit.prevent="import" class="space-y-4">
            <flux:heading>Import Data Siswa</flux:heading>

            <p class="text-sm text-gray-600">
                Unggah file Excel atau CSV dengan format kolom berikut:
                <strong>nisn, nis, nama, nama_pgl, jenis_kelamin, nama_ayah, nama_ibu</strong>
            </p>

            <flux:input type="file" wire:model="file" label="File Excel/CSV" accept=".xlsx,.xls,.csv" />

            <div class="flex justify-end gap-2">
                <flux:button type="button" wire:click="$set('showImport', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Import</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
