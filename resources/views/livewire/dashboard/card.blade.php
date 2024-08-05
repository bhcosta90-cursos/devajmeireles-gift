<div class="col-span-full sm:col-span-1" wire:init="load">
    <x-ui.card>
        <div class="ml-4 p-2">
            <div class="flex items-center justify-start">
                <div class="flex-shrink-0">
                    <p class="text-3xl font-semibold text-primary">
                        <span wire:loading>...</span>
                        <span wire:loading.remove>{{ $this->quantity }}</span>
                    </p>
                </div>
                <div class="ml-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-900" title="TEST">
                        {{ $this->card->label() }}
                    </h3>
                    <x-ui.badge outline primary>
                        <span wire:loading>...</span>
                        <span wire:loading.remove>80% em fraldas</span>
                    </x-ui.badge>
                </div>
            </div>
        </div>
    </x-ui.card>
</div>
