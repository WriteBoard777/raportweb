<x-layouts.auth>
    <div class="w-3xl flex flex-col gap-6">
        <x-auth-header 
            :title="__('Create an account')" 
            :description="__('Masukkan detail di bawah untuk membuat akun Anda')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-row gap-6 justify-center">
                {{-- LEFT SIDE --}}
                <div class="w-full flex flex-col gap-6">

                    <!-- Name -->
                    <flux:input
                        name="name"
                        :label="__('Nama Lengkap')"
                        type="text"
                        required
                        autocomplete="name"
                        :placeholder="__('Nama lengkap anda')"
                    />

                    <!-- NIP -->
                    <flux:input
                        name="nip"
                        :label="__('NIP')"
                        type="text"
                        required
                        autocomplete="nip"
                        :placeholder="__('NIP anda')"
                    />

                    <!-- Email -->
                    <flux:input
                        name="email"
                        :label="__('Email')"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                    />

                    <!-- Password -->
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    <!-- Confirm Password -->
                    <flux:input
                        name="password_confirmation"
                        :label="__('Konfirmasi Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Konfirmasi password')"
                        viewable
                    />

                    <!-- Kelas -->
                    <flux:input
                        name="kelas"
                        :label="__('Kelas (Rombel)')"
                        type="text"
                        required
                        autocomplete="kelas"
                        :placeholder="__('Nama rombel yang diampu')"
                    />

                    <!-- Alamat -->
                    <flux:input
                        name="alamat"
                        :label="__('Alamat Sekolah')"
                        type="text"
                        autocomplete="alamat"
                        :placeholder="__('Alamat lengkap sekolah')"
                    />
                </div>

                {{-- RIGHT SIDE --}}
                <div class="w-full flex flex-col gap-6">
                    
                    <!-- Asal Sekolah -->
                    <flux:input
                        name="asal_sekolah"
                        :label="__('Asal Sekolah')"
                        type="text"
                        required
                        autocomplete="asal_sekolah"
                        :placeholder="__('Nama sekolah')"
                    />

                    <!-- Jenis Sekolah -->
                    <flux:select
                        name="jenis_sekolah"
                        :label="__('Jenis Sekolah')"
                        required>
                        <option value="">-- Pilih --</option>
                        <option value="Negeri">Negeri</option>
                        <option value="Swasta">Swasta</option>
                    </flux:select>

                    <!-- Nama Kepala Sekolah -->
                    <flux:input
                        name="nama_kepala_sekolah"
                        :label="__('Nama Kepala Sekolah')"
                        type="text"
                        autocomplete="nama_kepala_sekolah"
                        :placeholder="__('Nama lengkap kepala sekolah beserta gelar')"
                    />

                    <!-- NIP Kepala Sekolah -->
                    <flux:input
                        name="nip_kepala_sekolah"
                        :label="__('NIP Kepala Sekolah')"
                        type="text"
                        autocomplete="nip_kepala_sekolah"
                        :placeholder="__('NIP Kepala Sekolah')"
                    />

                    <!-- NPSN -->
                    <flux:input
                        name="npsn"
                        :label="__('NPSN')"
                        type="text"
                        autocomplete="npsn"
                        :placeholder="__('Nomor Pokok Sekolah Nasional')"
                    />

                    <!-- Tahun Ajaran -->
                    <flux:input
                        name="tahun_ajaran"
                        :label="__('Tahun Ajaran')"
                        type="text"
                        autocomplete="tahun_ajaran"
                        :placeholder="__('Contoh: 2024/2025')"
                    />

                    <!-- Semester -->
                    <flux:input
                        name="semester"
                        :label="__('Semester')"
                        type="text"
                        autocomplete="semester"
                        :placeholder="__('Contoh: Ganjil / Genap')"
                    />
                </div>
            </div>

            <div class="w-full flex items-center">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Buat Akun') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Sudah punya akun?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Masuk sekarang') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
