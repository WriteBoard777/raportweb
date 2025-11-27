<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your account information')">
        <form wire:submit="updateProfileInformation" class="flex flex-col gap-2 my-6 w-full space-y-6">
            <div class="flex flex-col gap-6 justify-between">
                <flux:input
                    wire:model="name"
                    :label="__('Name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                />

                <flux:input
                    wire:model="email"
                    :label="__('Email')"
                    type="email"
                    required
                    autocomplete="email"
                />
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
