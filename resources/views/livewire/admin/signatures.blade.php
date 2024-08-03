<div>
    <x-slot name="header">
        {{ __('Signatures') }}
    </x-slot>

    <div class="space-y-4">
        <div class="space-y-2">
            <div class="flex justify-end">
                <livewire:signatures.filter />
            </div>
            <x-ui.tag wire:model.live="search.name" placeholder="Search by subscription name"  />
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($records = $this->records as $signature)
                <div class="col-span-full sm:col-span-1">
                    <x-ui.card>
                        <div class="ml-4 p-2">
                            <div class="flex items-center justify-start">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full"
                                         src="{{ $signature->avatar() }}"
                                         title="{{ $signature->name }}"
                                    >
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" title="{{ $signature->name }}">
                                        (#{{ $signature->id }}) {{ str($signature->name)->limit(24) }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        <a href="#">{{ $signature->item_name }}</a>
                                    </p>
                                    <x-ui.badge outline primary>
                                        {{ $signature->created_at->format('d/m/Y H:i') }}
                                    </x-ui.badge>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-1">
                            <x-ui.button.circle
                                danger
                                icon="trash"
                                wire:click="delete({{ $signature->id }})"
                            />
                        </div>
                    </x-ui.card>
                </div>
            @empty
                <div class="col-span-full">
                    <x-ui.card.empty text="No signature found" />
                </div>
            @endforelse
        </div>

        @if($records->isNotEmpty())
            <x-ui.pagination :$records/>
        @endif
    </div>
</div>
