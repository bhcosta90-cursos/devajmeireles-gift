@props([
    'title' => null,
    'lg' => false
])

@php
    $size = match(true) {
        $lg => '3xl',
        default => null,
    }
@endphp

<x-ts-modal
    wire
    :$size
    {{ $attributes }}
>
    @if($title)
        <x-slot:title>
            {{ __($title) }}
        </x-slot:title>
    @endif
    {{ $slot }}
</x-ts-modal>
