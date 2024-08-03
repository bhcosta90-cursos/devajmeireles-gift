@props([
    'label' => 'Active',
    'primary' => null,
    'secondary' => null,
])
<x-ts-toggle
    :color="$primary ? 'primary' : 'secondary'"
    :label="__($label)"
    {{$attributes}}
/>
