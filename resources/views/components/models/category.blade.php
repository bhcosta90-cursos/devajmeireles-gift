<x-ui.select
    wire:model="{{ $name }}"
    label="Category"
    :options="$this->listCategories()"
/>
