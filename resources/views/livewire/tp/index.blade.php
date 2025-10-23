<section class="w-full">
    <header class="mb-5">
        <h1>Data TP</h1>
        <p>Kelola TP berdasarkan Mapel yang aktif</p>
    </header>

    <div class="flex justify-between items-center mb-6">
        <flux:input wire:model.live="search" placeholder="Cari TP..." class="w-sm" />
        <flux:button wire:click.stop="$dispatch('openTpForm')">
            + Tambah TP
        </flux:button>
    </div>

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Mapel</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Deskripsi</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($tps as $tp)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm">{{ $tp->mapel->nama_mapel }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($tp->deskripsi)
                                <ol class="list-decimal list-inside">
                                    @foreach(json_decode($tp->deskripsi) as $desc)
                                        <li>{{ $desc }}</li>
                                    @endforeach
                                </ol>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-right">
                            <flux:button size="sm" wire:click.stop="$dispatch('openTpForm', { id: '{{ $tp->id }}' })">
                                Edit
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada TP</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tps->links() }}
    </div>

    <livewire:tp.form />
</section>
