@props([
    'label' => null,
])
<x-ts-date :label="__($label)" range helpers {{ $attributes }} />
