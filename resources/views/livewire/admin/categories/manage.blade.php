<div>
    <x-ui.slide :label="$title">
        <div class="space-y-4">
            <x-ui.toggle wire:model="active" />
            <x-ui.input label="Name" wire:model="name" />
        </div>
    </x-ui.slide>
</div>
