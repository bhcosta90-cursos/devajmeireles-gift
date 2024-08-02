@props([
    'options',
])

<x-ts-select.styled
    {{ $attributes }}
    :$options
    select="label:label|value:value"
    searchable
/>
