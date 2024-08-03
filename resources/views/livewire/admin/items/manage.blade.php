<div>
    <x-ui.slide :label="$title">
        <div class="space-y-4">
            <x-ui.toggle wire:model="active" />
            <div class="grid grid-cols-2 gap-4">
                <x-models.category />
                <x-ui.input type="url" label="Reference" wire:model="reference" />
            </div>
            <x-ui.input label="Name" wire:model="name" />
            <x-ui.textarea max="200" label="Description" wire:model="description" />
            <div class="grid grid-cols-2 gap-4">
                <x-ui.input.number label="Quantity" wire:model="quantity" />
                <x-ui.input.currency label="Price" wire:model="price" />
            </div>
        </div>
    </x-ui.slide>
</div>
