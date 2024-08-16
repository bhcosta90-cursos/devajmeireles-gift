<form class="flex justify-end gap-1">
    <x-ui.modal title="New Signature">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="col-span-full">
                <x-ui.input label="Name"
                         placeholder="Enter your name here"
                         wire:model="name"
                         autocomplete="name"
                />
            </div>
            <div class="col-span-full">
                <x-ui.input label="Cell phone"
                   mask="(##) #####-####"
                   placeholder="Insert your cell phone here"
                    wire:model="phone"
                />
            </div>

            <x-ui.input
                label="Selected Item"
                value="{{ $modelItem?->name }}"
                disabled
            />

            <div class="col-span-1">
                <x-ui.select wire:model.live="delivery" :options="$this->getDelivery" label="Tipo de Entrega" />
                @if ($delivery)
                    <p class="text-sm font-semibold text-primary">{{ \App\Enums\DeliveryType::from($delivery)->tip() }}</p>
                @endif
            </div>

            @if($delivery && $this->isPresence && \App\Enums\DeliveryType::from($delivery) === \App\Enums\DeliveryType::InPerson)
                <div class="col-span-full">
                    <x-ui.input label="Number of people"
                        placeholder="Tell us how many people are going to our event"
                    />
                </div>
            @endif

            @if ($item && $modelItem->availableQuantity() > 1)
                <div class="col-span-full space-y-2">
                    <x-ui.input.number label="Quantity"
                                     wire:model.change="quantity"
                                     :min="1"
                                     :max="$modelItem->availableQuantity()"
                    />
                    <p class="text-sm font-semibold underline decoration-dotted text-primary">
                        {{ $modelItem->availableQuantity() }} @lang('available quotas')
                    </p>
                </div>
            @endif
            @if ($modelItem && $modelItem->is_quotable)
                @php($available = $modelItem->availableQuantity())
                <div class="col-span-full space-y-2">
                    <x-ui.alert outline justify>
                        @lang('frontend.quoted.alert', [
                            'quantity' => $quantity,
                            'price' => currency($modelItem->priceQuoted($quantity, false)),
                            'total' => $available,
                        ])
                    </x-ui.alert>
                    @if ($modelItem->reference)
                        <div class="flex justify-center items-center">
                            <a href="{{ $modelItem->reference }}" target="_blank" class="text-sm text-primary
                            font-semibold">
                                @lang('See a model of the desired item by clicking here')
                            </a>
                            <x-heroicon-s-arrow-up-right class="h-4 w-4 text-primary" />
                        </div>
                    @endif
                </div>
            @endif
            <div class="col-span-full">
                <x-ui.textarea label="Observação"
                    placeholder="Insira uma observação que ache ser necessária aqui"
                    wire:model="observation"
                />
            </div>
        </div>
        <slot:footer>
            <div class="flex justify-end gap-x-4 pt-4">
                <x-ui.button flat label="Cancel" x-on:click="$wire.set('modal', false)"/>
                <x-ui.button primary label="To sign" wire:click="create"/>
            </div>
        </slot:footer>
    </x-ui.modal>
</form>
