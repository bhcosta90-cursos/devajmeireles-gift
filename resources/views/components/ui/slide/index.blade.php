@props([
    'label' => null,
    'title' => null,
    'action' => 'save'
])
<form wire:submit.prevent="{{ $action }}">
    <x-ts-slide
        wire
        persistent
    >
        <div>
            <x-slot:title>
                {{ $title ?: $label }}
            </x-slot:title>

            <div>
                {{ $slot }}
            </div>

            <x-slot:footer start>
                <div class="flex justify-between w-full">
                    <x-ui.button secondary outline label="Cancel" />
                    <x-ui.button type="submit" label="Save" />
                </div>
            </x-slot:footer>
        </div>
    </x-ts-slide>
</form>
