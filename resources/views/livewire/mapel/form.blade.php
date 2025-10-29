<div>
    <flux:modal wire:model="showForm" class="max-w-lg">
        <flux:heading class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            Pilih Mapel Aktif
        </flux:heading>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach ($mapels as $mapel)
                @php
                    $isActive = in_array($mapel->id, $activeMapels);
                @endphp

                <label 
                    for="mapel_{{ $mapel->id }}"
                    class="relative flex flex-col justify-center items-start p-4 rounded-xl border cursor-pointer transition-all duration-200 ease-in-out
                    {{ $isActive 
                        ? 'bg-indigo-50 dark:bg-indigo-900/40 border-indigo-400 dark:border-indigo-500 shadow-md' 
                        : 'bg-gray-50 dark:bg-zinc-800/40 border-transparent hover:border-indigo-300 dark:hover:border-indigo-500 hover:bg-indigo-50/50' }}"
                >
                    <div class="flex w-full items-center justify-between">
                        <div class="flex items-center gap-3">
                            {{-- Checkbox yang terlihat --}}
                            <input 
                                type="checkbox"
                                wire:model="activeMapels"
                                value="{{ $mapel->id }}"
                                id="mapel_{{ $mapel->id }}"
                                class="h-5 w-5 rounded-md border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">
                                {{ $mapel->nama_mapel }}
                            </span>
                        </div>

                        @if ($isActive)
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                fill="none" viewBox="0 0 24 24" 
                                stroke-width="2" stroke="currentColor" 
                                class="w-5 h-5 text-indigo-600 dark:text-indigo-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex justify-end gap-2 mt-6">
            <flux:button wire:click="$set('showForm', false)">Batal</flux:button>
            <flux:button variant="primary" wire:click="save">Simpan</flux:button>
        </div>
    </flux:modal>
</div>
