<section class="w-full">
    <div class="flex flex-col gap-6">
        <header class="mb-5">
            <h1>Selamat Datang Di Aplikasi Raport Akademik</h1>
            <p>~ WriteBoard</p>
        </header>

        {{-- Navigasi Card --}}
        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
            @php
                $menus = [
                    ['title' => 'Data Siswa', 'route' => route('siswa.index'), 'icon' => 'users'],
                    ['title' => 'Mata Pelajaran', 'route' => route('mapel.index'), 'icon' => 'book-open'],
                    ['title' => 'Ekstrakurikuler', 'route' => route('ekstra.index'), 'icon' => 'trophy'],
                    ['title' => 'Nilai Akademik', 'route' => route('nilai.index'), 'icon' => 'academic-cap'],
                    ['title' => 'Nilai Ekstra', 'route' => route('nilai-ekstra.index'), 'icon' => 'gift'],
                    ['title' => 'Absensi', 'route' => route('absen.index'), 'icon' => 'presentation-chart-bar'],
                ];
            @endphp

            @foreach ($menus as $menu)
                <a href="{{ $menu['route'] }}"
                class="group flex flex-col items-center justify-center rounded-xl border border-neutral-200 bg-white p-5 text-center shadow-sm transition hover:bg-[#37208B] hover:shadow-md dark:border-neutral-700 dark:bg-neutral-800">
                    <div class="mb-2 rounded-full bg-indigo-100 p-3 text-[#37208B] dark:bg-neutral-700 dark:text-[#6c44ff]">
                        <flux:icon :icon="$menu['icon']" class="h-6 w-6" />
                        {{-- <x-lucide-{{ $menu['icon'] }} class="h-6 w-6" /> --}}
                    </div>
                    <span class="text-sm font-medium text-neutral-800 dark:text-neutral-200">{{ $menu['title'] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Ringkasan Peringkat --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-800 dark:text-neutral-100">Top 10 Siswa (Rata-rata Nilai)</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-neutral-100 dark:bg-neutral-700">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Siswa</th>
                            <th class="px-4 py-2 text-left">NIS</th>
                            <th class="px-4 py-2 text-center">Rata-rata</th>
                            <th class="px-4 py-2 text-center">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peringkat as $index => $siswa)
                            <tr class="border-t hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-700/30">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $siswa['nama'] }}</td>
                                <td class="px-4 py-2">{{ $siswa['nis'] }}</td>
                                <td class="px-4 py-2 text-center font-semibold">{{ $siswa['rata_rata'] }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $index === 0 ? 'bg-yellow-400 text-black' :
                                        ($index === 1 ? 'bg-gray-300 text-black' :
                                        ($index === 2 ? 'bg-amber-600 text-white' : 'bg-blue-500 text-white')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                    Tidak ada data siswa ditemukan atau belum memiliki nilai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>