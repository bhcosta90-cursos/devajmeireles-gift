<x-ui.select
    wire:model="{{ $name }}"
    label="Category"
    :options="$listCategories()"
/>
