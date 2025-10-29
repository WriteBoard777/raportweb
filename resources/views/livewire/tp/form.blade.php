<div>
    {{-- 🌿 Modal Tambah / Edit TP --}}
    <flux:modal wire:model="showForm" class="max-w-3xl w-full">
        <form wire:submit.prevent="save" class="space-y-6 p-1">
            <flux:heading class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
                {{ $tpId ? 'Edit Tujuan Pembelajaran' : 'Tambah Tujuan Pembelajaran' }}
            </flux:heading>

            {{-- Pilihan Mapel --}}
            <div class="space-y-2">
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Pilih Mapel
                </label>

                <flux:select
                    id="mapel_id"
                    wire:model="mapel_id"
                    required
                    class="w-full border-gray-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                    <option value="">-- Pilih --</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </flux:select>

                @error('mapel_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi TP --}}
            <div class="space-y-3 mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Deskripsi Tujuan Pembelajaran
                </label>

                <div class="space-y-3">
                    @forelse ($deskripsis as $i => $desc)
                        <div class="flex items-start gap-3 p-3 border border-gray-200 dark:border-neutral-700 rounded-lg bg-gray-50 dark:bg-neutral-800">
                            <input
                                type="text"
                                wire:model="deskripsis.{{ $i }}"
                                placeholder="Tuliskan deskripsi..."
                                class="flex-1 border-none bg-transparent focus:ring-0 focus:outline-none text-gray-800 dark:text-gray-100 placeholder-gray-400"
                            />
                            <button
                                type="button"
                                wire:click="removeDeskripsi({{ $i }})"
                                class="px-2.5 py-1.5 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg transition"
                            >
                                Hapus
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada deskripsi ditambahkan.</p>
                    @endforelse
                </div>

                <button
                    type="button"
                    wire:click="addDeskripsi"
                    class="flex items-center gap-2 px-3 py-2 text-sm bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-sm transition"
                >
                    <flux:icon.squares-plus class="w-4 h-4" />
                    Tambah Deskripsi
                </button>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-2 mt-6">
                <flux:button type="button" variant="ghost" wire:click="$set('showForm', false)">
                    Batal
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Simpan
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
