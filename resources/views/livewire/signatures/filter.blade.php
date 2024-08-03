<div>
    <x-ui.button.circle wire:click="$toggle('modal')">
        <x-heroicon-s-funnel class="w-4 h-4" />
    </x-ui.button.circle>

    <x-ui.modal title="Advanced filter for subscriptions" lg>
        <div class="space-y-4">
            <x-ui.tag wire:model.live="search.categories" placeholder="Search by category"  />
            <x-ui.input.date.range wire:model.live="search.created_at" label="Created At" />
        </div>
    </x-ui.modal>
</div>
