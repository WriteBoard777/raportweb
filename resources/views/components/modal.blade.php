@props(['name' => null, 'focusable' => false])

<div
    x-data="{ open: @entangle($attributes->wire('model')) }"
    x-show="open"
    x-cloak
    x-transition.opacity.duration.200ms
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
>
    <div
        @click.away="open = false"
        x-transition.scale.origin.center.duration.200ms
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden transform transition-all"
    >
        {{-- HEADER --}}
        @if (isset($title))
            <div class="flex items-center justify-between border-b px-6 py-4 bg-gray-50 dark:bg-gray-800/40">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    {{ $title }}
                </h2>
                <button
                    type="button"
                    @click="open = false"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                >
                    ✕
                </button>
            </div>
        @endif

        {{-- BODY --}}
        <div class="p-6 text-gray-700 dark:text-gray-200">
            {{ $slot }}
        </div>

        {{-- FOOTER --}}
        @if (isset($footer))
            <div class="border-t px-6 py-4 bg-gray-50 dark:bg-gray-800/40 flex justify-end gap-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
