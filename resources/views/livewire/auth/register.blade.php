<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <div class="flex flex-row gap-6 justify-center">
                {{-- left side --}}
                <div class="flex flex-col gap-6">
                    <!-- Name -->
                    <flux:input
                        name="name"
                        :label="__('Name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        :placeholder="__('Full name')"
                    />

                    <!-- Email Address -->
                    <flux:input
                        name="email"
                        :label="__('Email address')"
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
                        :label="__('Confirm password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Confirm password')"
                        viewable
                    />

                    <!-- Kelas -->
                    <flux:input
                        name="kelas"
                        :label="__('Kelas')"
                        type="text"
                        required
                        autocomplete="kelas"
                        :placeholder="__('Nama Rombel')"
                    />
                </div>

                {{-- right side --}}
                <div class="flex flex-col gap-6">
                    <!-- Asal Sekolah -->
                    <flux:input
                        name="asal_sekolah"
                        :label="__('Asal Sekolah')"
                        type="text"
                        required
                        autocomplete="asal_sekolah"
                        :placeholder="__('Asal Sekolah')"
                    />

                    <!-- Nama Kepala Sekolah -->
                    <flux:input
                        name="nama_kepala_sekolah"
                        :label="__('Nama Kepala Sekolah')"
                        type="text"
                        required
                        autocomplete="nama_kepala_sekolah"
                        :placeholder="__('Nama Kepsek beserta gelar')"
                    />

                    <!-- NPSN -->
                    <flux:input
                        name="npsn"
                        :label="__('NPSN')"
                        type="text"
                        required
                        autocomplete="npsn"
                        :placeholder="__('NPSN')"
                    />

                    <!-- Tahun Ajaran -->
                    <flux:input
                        name="tahun_ajaran"
                        :label="__('Tahun Ajaran')"
                        type="text"
                        required
                        autocomplete="tahun_ajaran"
                        :placeholder="__('Tahun Ajaran')"
                    />

                    <!-- Semester -->
                    <flux:input
                        name="semester"
                        :label="__('Semester')"
                        type="text"
                        required
                        autocomplete="semester"
                        :placeholder="__('Semester')"
                    />
                </div>
            </div>
        
            <div class="flex items-center px-6">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
