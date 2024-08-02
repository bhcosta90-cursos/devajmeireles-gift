@props([
    'max' => null,
    'label' => null,
])
<x-ts-textarea
    :label="__($label)"
    {{ $attributes }}
    :maxlength="$max"
    :count="$max"
    resize-auto
/>
