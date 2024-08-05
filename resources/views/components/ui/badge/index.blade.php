@props([
    'outline' => false,
    'primary' => false,
])

<x-ts-badge
    :outline="$outline"
    :primary="$primary"
    {{ $attributes }}
>
    {{ $slot }}
</x-ts-badge>

