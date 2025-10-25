<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your account information')">
        <form wire:submit="updateProfileInformation" class="flex flex-col gap-2 my-6 w-full space-y-6">
            <div class="flex gap-6 justify-between">
                {{-- Left side --}}
                <div class="flex flex-col gap-4 w-full">
                    <flux:input
                        wire:model="name"
                        :label="__('Name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    {{-- Label dinamis berdasarkan jenis sekolah (NIP / NIY) --}}
                    <flux:input
                        wire:model="nip"
                        :label="$this->nipLabel"
                        type="text"
                        required
                        autocomplete="nip"
                    />

                    <flux:input
                        wire:model="email"
                        :label="__('Email')"
                        type="email"
                        required
                        autocomplete="email"
                    />

                    <flux:input
                        wire:model="semester"
                        :label="__('Semester')"
                        type="text"
                        required
                        autocomplete="semester"
                    />

                    <flux:input
                        wire:model="tahun_ajaran"
                        :label="__('Tahun Ajaran')"
                        type="text"
                        required
                        autocomplete="tahun_ajaran"
                    />

                    <flux:input
                        wire:model="alamat"
                        :label="__('Alamat')"
                        type="text"
                        required
                        autocomplete="alamat"
                        />
                </div>

                {{-- Right side --}}
                <div class="flex flex-col gap-4 w-full">
                    <flux:input
                        wire:model="asal_sekolah"
                        :label="__('Asal Sekolah')"
                        type="text"
                        required
                        autocomplete="asal_sekolah"
                    />

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
                        wire:model="nama_kepala_sekolah"
                        :label="__('Nama Kepala Sekolah')"
                        type="text"
                        required
                        autocomplete="nama_kepala_sekolah"
                    />

                    {{-- Label dinamis untuk Kepala Sekolah --}}
                    <flux:input
                        wire:model="nip_kepala_sekolah"
                        :label="$this->nipKepsekLabel"
                        type="text"
                        autocomplete="nip_kepala_sekolah"
                    />

                    <flux:input
                        wire:model="npsn"
                        :label="__('NPSN')"
                        type="text"
                        required
                        autocomplete="npsn"
                    />

                    <flux:input
                        wire:model="kelas"
                        :label="__('Kelas')"
                        type="text"
                        required
                        autocomplete="kelas"
                    />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Save') }}
                </flux:button>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
