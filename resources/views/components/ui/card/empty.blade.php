@props([
    'text'
])

<x-ts-card>
    <div class="p-4 flex justify-center items-center">
        <p class="text-lg sm:text-2xl font-semibold leading-6">
            {{ __($text) ?? $slot }}
        </p>
    </div>
</x-ts-card>
