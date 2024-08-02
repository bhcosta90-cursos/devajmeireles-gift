@props([
    'max' => null,
])
<x-ts-textarea
    :maxlength="$max"
    :count="$max"
    resize-auto
/>

