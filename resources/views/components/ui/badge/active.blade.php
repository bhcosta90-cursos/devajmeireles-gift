@props([
    'value',
    'label' => null,
])

<x-ts-badge
    :text="__($label ?: ($value ? 'Yes' : ($value === null ? '-' : 'No')))"
    :color="$value ? 'green': ($value === null ? 'neutral' : 'red')"
    outline
/>

