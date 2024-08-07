@props([
    'label' => null,
])
<x-ui.input.date :label="__($label)" range helpers {{ $attributes }} />
