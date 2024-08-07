@props([
    'label',
    'title',
    'permission' => true,
])
<div>
    @if($permission)
        @isset($button)
            {{ $button }}
        @else
            <x-ui.button.secondary :$label wire:click="$toggle('slide')" />
        @endif
    @endif

    <x-ui.slide.slide :title="__($title ?: $label)">
        {{ $slot }}
    </x-ui.slide.slide>
</div>
