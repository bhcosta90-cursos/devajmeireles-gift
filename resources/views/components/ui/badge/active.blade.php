@props([
    'value',
    'label' => null,
])

<x-ts-badge
    :text="__($label ?: ($value ? 'Yes' : 'No'))"
    :color="$value ? 'green': 'red'"
    outline
/>

