<div>
    <x-ui.slide
        label="Create Signature"
        :permission="$this->buttonCreate"
        :title="$signature ? 'Edit Signature' : 'Create Signature'"
    >
        <x-slot:button>
            <x-ui.button.circle primary icon="plus" label="12" wire:click="createItem" md />
        </x-slot:button>
        <div class="space-y-4">
            <x-ui.input label="Name" wire:model="name" />
            <x-filter.item wire:model.live="item" />
            <div @class(['grid gap-4', 'grid-cols-2' => blank($signature)])>
                <x-ui.input label="Cell phone" x-mask="(99) 99999-9999" wire:model="phone" />
                @empty($signature)
                    <x-ui.input.number label="Quantity" min="1" wire:model.change="quantity" />
                @endif
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div @class(['col-span-full'=> !($delivery && $this->isPresence && \App\Enums\DeliveryType::from($delivery) === \App\Enums\DeliveryType::InPerson && blank($signature))])>
                    <x-ui.select wire:model.live="delivery" :options="$this->getDelivery" label="Tipo de Entrega" />
                </div>
                @if($delivery && $this->isPresence && \App\Enums\DeliveryType::from($delivery) === \App\Enums\DeliveryType::InPerson && blank($signature))
                    <div>
                        <x-ui.input label="Number of people"
                                    wire:model="presence"
                                    placeholder="Number of people going to the event"
                        />
                    </div>
                @endif
            </div>

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
