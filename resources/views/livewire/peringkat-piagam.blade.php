<section class="w-full">
    <header class="mb-5">
        <h1 class="text-xl font-bold">Preview Piagam Penghargaan</h1>
        <p class="text-gray-600 dark:text-gray-400">Isi data piagam sebelum dicetak</p>
    </header>

    {{-- Tombol Aksi --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:button wire:navigate href="{{ route('peringkat.index') }}">
                ← Kembali
            </flux:button>
        </div>
        <div class="flex gap-3">
            <flux:button wire:click="exportPdf" variant="primary">
                Cetak PDF
            </flux:button>
        </div>
    </div>

    {{-- Form Input --}}
    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold mb-1">Nomor Surat</label>
            <flux:input wire:model.defer="nomorSurat" placeholder="Contoh: 421.2/012/SDIT.AM/2025" />
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Tanggal Piagam</label>
            <flux:input type="date" wire:model.defer="tanggalPiagam" />
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Lokasi Kab</label>
            <flux:input placeholder="Contoh: Cirebon" type="text" wire:model.defer="lokasi"/>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Lokasi Kecamatan</label>
            <flux:input placeholder="Contoh: Plered" type="text" wire:model.defer="kecamatan"/>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">No Telp Sekolah</label>
            <flux:input placeholder="Contoh: +6281-8899-9025" type="text" wire:model.defer="telpSekolah"/>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Email Sekolah</label>
            <flux:input placeholder="Contoh: goldensunshinekids@writeboardedu.com" type="email" wire:model.defer="emailSekolah"/>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Website Sekolah</label>
            <flux:input placeholder="Contoh: writeboardedu.com" type="text" wire:model.defer="websiteSekolah"/>
        </div>
    </div>

    {{-- Preview Piagam --}}
    <div class="relative mx-auto bg-white dark:bg-gray-900 rounded-lg overflow-hidden shadow-lg border max-w-4xl">
        <div class="bg-white"
            style="
                background-image: url('{{ asset('img/bg_piagam.png') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                padding: 3cm 2.5cm;
                font-family: 'Times New Roman', serif;
                color: #000;
                min-height: 1000px;
            ">
            
            {{-- HEADER --}}
            <div class="text-center">
                <img src="{{ asset('img/logo_tutwuri.png') }}" class="mx-auto w-24" alt="Logo Tut Wuri Handayani">
                <div class="mt-2">
                    <h1 class="font-extrabold text-base">PEMERINTAH KABUPATEN CIREBON</h1>
                    <h1 class="font-extrabold text-base">DINAS PENDIDIKAN</h1>
                    <h2 class="font-semibold text-lg">SDIT ALIEF MARDHIYAH</h2>
                    <h3 class="text-sm">KECAMATAN PLERED</h3>
                    <p class="text-xs">Jl. Otto Iskandardinata Blok Asinan | Telp. 081546876646</p>
                    <p class="text-xs">Email: sditaliefmardhiyah@gmail.com | Website: aliefmardhiyah.org</p>
                </div>
            </div>

            {{-- MAIN TITLE --}}
            <div class="text-center mt-10">
                <h1 class="text-3xl font-extrabold tracking-wide">PIAGAM PENGHARGAAN</h1>
                <p class="mt-2 text-sm">
                    Nomor: {{ $nomorSurat ?: '421.2/___/SDIT.AM/' . date('Y') }}
                </p>
            </div>

            {{-- RECIPIENT --}}
            <div class="text-center mt-12">
                <h3 class="text-lg mb-2">Diberikan Kepada</h3>
                <h1 class="text-2xl font-extrabold mb-2">{{ $siswa->nama ?? 'Nama Siswa' }}</h1>
                <h3 class="text-lg mb-1">Sebagai</h3>
                <h1 class="text-2xl font-extrabold text-blue-700">
                    Peringkat Ke - {{ $peringkat ?? '-' }}
                </h1>
            </div>

            {{-- DESCRIPTION --}}
            <div class="text-center mt-8 leading-relaxed text-[15px]">
                <p>Atas prestasi belajar dengan jumlah total nilai <b>{{ $totalNilai ?? '-' }}</b>.</p>
                <p>Pada kelas {{ Auth::user()->kelas ?? '-' }} Tahun Pelajaran {{ Auth::user()->tahun_ajaran ?? date('Y') }}.</p>
                <p>Semoga prestasi ini menjadi motivasi untuk meraih kesuksesan di masa depan.</p>
            </div>

            {{-- FOOTER --}}
            <div class="mt-16 px-6">
                <div class="grid grid-cols-2 text-center text-sm">
                    <div>
                        Mengetahui, <br>
                        Kepala Sekolah {{ Auth::user()->asal_sekolah ?? 'Nama Sekolah' }}
                        <div class="mt-20 font-bold underline">{{ Auth::user()->nama_kepala_sekolah ?? 'Nama Kepala Sekolah' }}</div>
                        <div>{{ Auth::user()->nip_kepala_sekolah ?? '-' }}</div>
                    </div>

                    <div>
                        Cirebon, {{ \Carbon\Carbon::parse($tanggalPiagam)->translatedFormat('d F Y') }} <br>
                        Guru Kelas
                        <div class="mt-20 font-bold underline">{{ Auth::user()->name ?? 'Nama Guru' }}</div>
                        <div>{{ Auth::user()->nip ?? '-' }}</div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <img src="{{ asset('img/trophy.png') }}" class="mx-auto w-20" alt="Trophy">
                </div>
            </div>
        </div>
    </div>
</section>
