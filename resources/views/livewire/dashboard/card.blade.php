<div class="col-span-full sm:col-span-1" wire:init="load">
    <x-ui.card>
        <div class="ml-4 p-2">
            <div class="flex items-center justify-start">
                <div class="flex-shrink-0 rounded p-2 bg-primary-100">
                    <p class="text-3xl font-bold text-primary-600">
                        <span wire:loading>...</span>
                        <span wire:loading.remove>{{ $this->quantity }}</span>
                    </p>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold leading-6 text-md text-primary">
                        {{ $this->card->label() }}
                    </h3>
                </div>
            </div>
        </div>
    </x-ui.card>
</div>
