<div>
    <x-ui.slide :label="$title">
        <x-slot:button>
            <x-ui.button.circle primary icon="plus" label="12" wire:click="$toggle('slide')" md />
        </x-slot:button>
        <div class="space-y-4">
            <x-ui.input label="Name" wire:model="name" />
            <x-filter.item wire:model.live="item" />
            <div class="grid grid-cols-2 gap-4">
                <x-ui.input label="Cell phone" x-mask="(99) 99999-9999" wire:model="name" />
                <x-ui.input.number label="Quantity" min="1" wire:model.change="quantity" />
            </div>
            <x-ui.textarea max="200" wire:model="observation" label="Observation" />

            @if ($modelItem && $modelItem->is_quotable && $modelItem->price && $quantity > 0)
                <div class="col-span-full">
                    <x-ts-alert outline center>
                        {!! trans_choice('signatures.quote', $this->quantity, [
                            'price' => currency($modelItem->price),
                            'quantity' => $this->quantity,
                            'price_quote' => currency($modelItem->priceQuoted($quantity, false))
                        ]) !!}
                    </x-ts-alert>
                </div>
            @endif
        </div>
    </x-ui.slide>
</div>
