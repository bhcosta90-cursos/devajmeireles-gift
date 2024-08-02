@props([
    'label' => null,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'outline' => false,
])
<div>
    <x-ts-button
        {{ $attributes }}
        :xs="$xs"
        :sm="$sm"
        :md="$md"
        :lg="$lg"
        :outline="$outline"
        color="primary"
    >
        {{ __($label) ?? $slot}}
    </x-ts-button>
</div>
