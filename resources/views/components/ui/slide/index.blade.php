@props([
    'label',
    'title' => null,
])
<div>
    <x-ui.button.secondary :$label wire:click="$toggle('slide')" />

    <x-ui.slide.slide :title="$title ?: $label">
        {{ $slot }}
    </x-ui.slide.slide>
</div>
