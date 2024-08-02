@props([
    'label' => null,
])

<x-ts-input :label="__($label)" {{ $attributes }} />
