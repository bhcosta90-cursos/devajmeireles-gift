@props([
    'icon' => null,
    'primary' => null,
    'danger' => null,
    'secondary' => null,
])

@php
    $color = match(true) {
        $danger => 'red',
        default => 'secondary'
    }
@endphp

<x-ts-button.circle
    {{ $attributes }}
    :$icon
    :$color
>
    {{ $slot }}
</x-ts-button.circle>
