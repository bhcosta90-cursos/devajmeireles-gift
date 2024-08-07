@props([
    'label',
    'title',
])
<div>
    @isset($button)
        {{ $button }}
    @else
        <x-ui.button.secondary :$label wire:click="$toggle('slide')" />
    @endif

    <x-ui.slide.slide :title="__($title ?: $label)">
        {{ $slot }}
    </x-ui.slide.slide>
</div>
