@props([
    'max' => null,
])
<x-ts-textarea
    {{ $attributes }}
    :maxlength="$max"
    :count="$max"
    resize-auto
/>
