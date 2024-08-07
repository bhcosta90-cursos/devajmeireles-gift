@props([
    'label' => null,
])
<x-ui.date :label="__($label)" range helpers {{ $attributes }} />
