@props([
    'label' => null,
])

<x-ts-tag :label="__($label)" {{ $attributes }} />
