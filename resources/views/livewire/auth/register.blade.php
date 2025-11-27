<x-layouts.auth>
    <div class="w-3xl flex flex-col gap-6">
        <x-auth-header 
            :title="__('Create an account')" 
            :description="__('Masukkan detail di bawah untuk membuat akun Anda')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-6 justify-center">
                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Username')"
                    type="text"
                    required
                    autocomplete="name"
                    :placeholder="__('Username')"
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
