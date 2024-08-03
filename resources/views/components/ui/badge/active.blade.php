@props([
    'value'
])

<x-ts-badge
    :text="__($value ? 'Yes' : 'No')"
    :color="$value ? 'green': 'red'"
    outline
/>

