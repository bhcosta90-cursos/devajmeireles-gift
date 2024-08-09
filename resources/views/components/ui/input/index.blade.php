@props([
    'label' => null,
    'placeholder' => null,
])

<x-ts-input :label="__($label)" :placeholder="__($placeholder)" {{ $attributes }} />
