@props([
    'type',
])

@php
    $icon = match($type){
        'edit' => 'pencil',
        'delete' => 'trash',
        default => $icon
    };
@endphp

<x-ts-button.circle :$icon {{ $attributes }} />
