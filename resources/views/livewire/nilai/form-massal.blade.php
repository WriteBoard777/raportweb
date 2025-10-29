<div>
    <flux:modal wire:model="showForm" size="xl">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>Input Nilai Massal</flux:heading>

            <div class="overflow-x-auto border rounded-lg max-h-[70vh]">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-semibold">Nama Siswa</th>
                            <th class="px-3 py-2 text-center text-sm font-semibold">Harian</th>
                            <th class="px-3 py-2 text-center text-sm font-semibold">UTS</th>
                            <th class="px-3 py-2 text-center text-sm font-semibold">UAS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td class="px-3 py-2 text-sm">{{ $siswa->nama }}</td>
                                <td class="px-3 py-2 text-center">
                                    <flux:input type="number" min="0" max="100"
                                        wire:model="nilaiData.{{ $siswa->id }}.nilai_harian"
                                        placeholder="-" class="w-20 text-center" />
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <flux:input type="number" min="0" max="100"
                                        wire:model="nilaiData.{{ $siswa->id }}.nilai_uts"
                                        placeholder="-" class="w-20 text-center" />
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <flux:input type="number" min="0" max="100"
                                        wire:model="nilaiData.{{ $siswa->id }}.nilai_uas"
                                        placeholder="-" class="w-20 text-center" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" wire:click="$set('showForm', false)">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan Semua</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
