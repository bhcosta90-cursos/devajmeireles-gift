@props([
    'outline' => false,
    'primary' => false,
])

<x-ts-badge
    :outline="$outline"
    :primary="$primary"
>
    {{ $slot }}
</x-ts-badge>

