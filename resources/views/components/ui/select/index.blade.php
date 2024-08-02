@props([
    'options',
    'label' => null,
])

<x-ts-select.styled
    {{ $attributes }}
    :label="__($label)"
    :$options
    select="label:label|value:value"
    searchable
/>
