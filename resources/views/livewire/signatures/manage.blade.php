<div>
    <x-ui.slide :label="$title">
        <x-slot:button>
            <x-ui.button.circle primary icon="plus" label="12" wire:click="createItem" md />
        </x-slot:button>
        <div class="space-y-4">
            <x-ui.input label="Name" wire:model="name" />
            <x-filter.item wire:model.live="item" />
            <div @class(['grid gap-4', 'grid-cols-2' => blank($modelItem)])>
                <x-ui.input label="Cell phone" x-mask="(99) 99999-9999" wire:model="phone" />
                @empty($modelItem)
                    <x-ui.input.number label="Quantity" min="1" wire:model.change="quantity" />
                @endif
            </div>
            <x-ui.select wire:model="delivery" :options="$this->getDelivery" label="Tipo de Entrega" />
            <x-ui.textarea max="200" wire:model="observation" label="Observation" />

            @if ($modelItem && $modelItem->is_quotable && $modelItem->price && (blank($signature) ? $quantity > 0 : $modelItem->availableQuantity() > 1))
                <div class="col-span-full">
                    <x-ui.alert outline center>
                        {!! trans_choice('signatures.quote', $this->quantity, [
                            'price' => currency($modelItem->price),
                            'quantity' => $this->quantity,
                            'price_quote' => currency($modelItem->priceQuoted($quantity, false))
                        ]) !!}
                    </x-ui.alert>
                </div>
            @endif
        </div>
    </x-ui.slide>
</div>
