@props([
    'type' => 'button',
    'primary' => false,
    'secondary' => false,
    'label' => null,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
])
<div>
    <x-ts-button
        {{ $attributes->merge($sm ? ['sm' => true] : []) }}
        :xs="$xs"
        :sm="$sm"
        :md="$md"
        :lg="$lg"
        :color="$primary ? 'primary' : 'secondary'"
    >
        {{ __($label) ?? $slot}}
    </x-ts-button>
</div>
