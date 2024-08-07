<div>
    <div class="space-x-2">
        <x-ui.button.circle wire:click="$toggle('modal')">
            <x-heroicon-s-funnel class="w-4 h-4" />
        </x-ui.button.circle>

        <x-ui.button.circle
            info
            :disabled="collect($search)->except('created_at')->filter(fn($item) => count($item))->isEmpty()"
            wire:click="removeFilters"
        >
            <x-heroicon-s-minus class="w-4 h-4" />
        </x-ui.button.circle>
    </div>

    <x-ui.modal title="Advanced filter for subscriptions" lg>
        <div class="space-y-4">
            <x-ui.tag wire:model.live="search.categories" placeholder="Search by category"  />
            <x-ui.tag wire:model.live="search.items" placeholder="Search by item"  />
            <x-ui.input.date.range wire:model.live="search.created_at" label="Created At" />
        </div>
    </x-ui.modal>
</div>
