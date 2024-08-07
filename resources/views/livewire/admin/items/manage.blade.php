<div>
    <x-ui.slide
        label="Create Item"
        :permission="auth()->user()->can('create', \App\Models\Item::class)"
        :title="$item ? 'Edit Item' : 'Create Item'"
    >
        <div class="space-y-4">
            <div class="grid grid-cols-2">
                <x-ui.toggle wire:model="active" />
                <x-ui.toggle wire:model.change="quotable" label="Quota" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-filter.category wire:model="category" />
                <x-ui.input type="url" label="Reference" wire:model="reference" />
            </div>
            <x-ui.input label="Name" wire:model="name" />
            <x-ui.textarea max="200" label="Description" wire:model="description" />
            <div @class(['grid gap-4', 'grid-cols-2' => $this->quotable])>
                <x-ui.input.number label="Quantity" wire:model="quantity" />
                @if($this->quotable)
                    <x-ui.input.currency label="Price" wire:model="price" />
                @endif
            </div>
        </div>
    </x-ui.slide>
</div>
