<section class="w-full">
    <header class="mb-5">
        <h1>Data Pengguna</h1>
        <p>Kelola Data Pengguna dan Sekolah di Sistem Raport</p>
    </header>

    <form wire:submit="updateDetailInformation" class="flex flex-col gap-2 my-6 w-full space-y-6">
        <div class="flex gap-6 justify-between">
            {{-- Left side --}}
            <div class="flex flex-col gap-4 w-full">
                <flux:input
                    wire:model="name"
                    :label="__('Nama Lengkap Anda')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama Lengkap Anda"
                />

                {{-- Label dinamis berdasarkan jenis sekolah (NIP / NIY) --}}
                <flux:input
                    wire:model="nip"
                    :label="$this->nipLabel"
                    type="text"
                    required
                    autocomplete="nip"
                    placeholder="NIP / NIY"
                />

                <flux:input
                    wire:model="semester"
                    :label="__('Semester')"
                    type="text"
                    required
                    autocomplete="semester"
                    placeholder="Contoh: Ganjil / Genap"
                />

                <flux:input
                    wire:model="tahun_ajaran"
                    :label="__('Tahun Ajaran')"
                    type="text"
                    required
                    autocomplete="tahun_ajaran"
                    placeholder="Contoh: 2025 / 2026"
                />

                <flux:input
                    wire:model="alamat"
                    :label="__('Alamat')"
                    type="text"
                    required
                    autocomplete="alamat"
                    placeholder="Contoh: Jl. Merdeka No. 123"
                    />

                <flux:input
                    wire:model="kabupaten"
                    :label="__('Kabupaten')"
                    type="text"
                    required
                    autocomplete="kabupaten"
                    placeholder="Contoh: Jakarta"
                    />

                <flux:input
                    wire:model="kecamatan"
                    :label="__('Kecamatan')"
                    type="text"
                    required
                    autocomplete="kecamatan"
                    placeholder="Contoh: Pondok Aren"
                    />
                    
                <flux:input
                    wire:model="kelas"
                    :label="__('Kelas')"
                    type="text"
                    required
                    autocomplete="kelas"
                    placeholder="Contoh: V B"
                />
            </div>

            {{-- Right side --}}
            <div class="flex flex-col gap-4 w-full">
                {{-- Pilihan jenis sekolah --}}
                <flux:select
                    wire:model="jenis_sekolah"
                    :label="__('Jenis Sekolah')"
                    required
                >
                    <option value="">-- Pilih --</option>
                    <option value="Negeri">Negeri</option>
                    <option value="Swasta">Swasta</option>
                </flux:select>
                
                <flux:input
                    wire:model="npsn"
                    :label="__('NPSN')"
                    type="text"
                    required
                    autocomplete="npsn"
                    placeholder="Nomor Pokok Sekolah Nasional"
                />

                <flux:input
                    wire:model="asal_sekolah"
                    :label="__('Asal Sekolah')"
                    type="text"
                    required
                    autocomplete="asal_sekolah"
                    placeholder="Contoh: Golden Sunshine Kids"
                />

                <flux:input
                    wire:model="nama_kepala_sekolah"
                    :label="__('Nama Kepala Sekolah')"
                    type="text"
                    required
                    autocomplete="nama_kepala_sekolah"
                    placeholder="Nama Lengkap Kepala Sekolah"
                />

                {{-- Label dinamis untuk Kepala Sekolah --}}
                <flux:input
                    wire:model="nip_kepala_sekolah"
                    :label="$this->nipKepsekLabel"
                    type="text"
                    autocomplete="nip_kepala_sekolah"
                    placeholder="NIP / NIY Kepala Sekolah"
                />
                
                <flux:input
                    wire:model="email_sekolah"
                    :label="__('Email Sekolah')"
                    type="text"
                    required
                    autocomplete="email_sekolah"
                    placeholder="Email Sekolah"
                />
                
                <flux:input
                    wire:model="telp_sekolah"
                    :label="__('Nomor Telp Sekolah')"
                    type="text"
                    required
                    autocomplete="telp_sekolah"
                    placeholder="Nomor Telp Sekolah"
                />
                
                <flux:input
                    wire:model="web_sekolah"
                    :label="__('Website Sekolah')"
                    type="text"
                    required
                    autocomplete="web_sekolah"
                    placeholder="Website Sekolah"
                />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Save') }}
            </flux:button>

            <x-action-message class="me-3" on="detail-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>