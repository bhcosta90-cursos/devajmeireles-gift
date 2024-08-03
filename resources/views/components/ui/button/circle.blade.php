@props([
    'icon' => null,
    'danger' => null,
])

@php
    $color = match(true) {
        $danger => 'red',
    }
@endphp

<x-ts-button.circle
    :$icon {{ $attributes }}
    :$color
/>
