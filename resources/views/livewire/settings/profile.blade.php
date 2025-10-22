<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="flex flex-col gap-2 my-6 w-full space-y-6">
            <div class="flex gap-6 justify-between">
                {{-- left side --}}
                <div class="flex flex-col gap-4 w-full">
                    <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                    <div>
                        <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                            <div>
                                <flux:text class="mt-4">
                                    {{ __('Your email address is unverified.') }}

                                    <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </flux:link>
                                </flux:text>

                                @if (session('status') === 'verification-link-sent')
                                    <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </flux:text>
                                @endif
                            </div>
                        @endif
                    </div>

                    <flux:input wire:model="semester" :label="__('Semester')" type="text" required autocomplete="semester" />
                    <flux:input wire:model="tahun_ajaran" :label="__('Tahun Ajaran')" type="text" required autocomplete="tahun_ajaran" />
                </div>

                {{-- right side --}}
                <div class="flex flex-col gap-4 w-full">
                    <flux:input wire:model="asal_sekolah" :label="__('Asal Sekolah')" type="text" required autocomplete="asal_sekolah" />
                    <flux:input wire:model="nama_kepala_sekolah" :label="__('Nama Kepala Sekolah')" type="text" required autocomplete="nama_kepala_sekolah" />
                    <flux:input wire:model="npsn" :label="__('NPSN')" type="text" required autocomplete="npsn" />
                    <flux:input wire:model="kelas" :label="__('Kelas')" type="text" required autocomplete="kelas" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
