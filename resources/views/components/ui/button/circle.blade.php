@props([
    'icon' => null,
    'primary' => null,
    'danger' => null,
    'secondary' => null,
    'info' => null,
])

@php
    $color = match(true) {
        $danger => 'red',
        $info => 'neutral',
        $primary => 'primary',
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
