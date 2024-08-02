<div>
    <x-ui.slide.button label="Create Item">
        <div class="space-y-4">
            <x-ui.select
                wire:model="category"
                label="Category"
                :options="$this->categories"
            />
            <x-ui.input label="Name" wire:model="name" />
            <x-ui.input type="url" label="Reference" wire:model="reference" />
            <x-ui.input label="Description" wire:model="description" />
            <x-ui.input.currency label="Quantity" wire:model="quantity" />
            <x-ui.input.number label="Price" wire:model="price" />
        </div>
    </x-ui.slide.button>
</div>
