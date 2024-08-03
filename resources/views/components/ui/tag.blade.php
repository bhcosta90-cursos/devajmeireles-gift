@props([
    'label' => null,
    'placeholder' => null,
])

<x-ts-tag :label="__($label)" :placeholder="__($placeholder)" {{ $attributes }} />
