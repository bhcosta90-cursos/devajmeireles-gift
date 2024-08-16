<div wire:init="category">
    <div class="justify-center" wire:loading.flex wire:target="category">
        <x-ui.loading.preloader/>
    </div>
    <div class="justify-center" wire:loading.flex wire:target="item">
        <x-ui.loading.preloader/>
    </div>
    <div class="justify-center" wire:loading.flex wire:target="more">
        <x-ui.loading.preloader overlay/>
    </div>

    <livewire:frontend.signature />

    @if (!$filtered && $categories)
        <div wire:key="category"
             wire:loading.remove
             wire:target="item"
             class="grid grid-cols-2 gap-4 sm:grid-cols-3"
        >
            @php /** @var \App\Models\Category $category */ @endphp
            @forelse ($categories as $category)
                <div class="col-span-full sm:col-span-1" id="{{ str()->uuid() }}">
                    <x-ui.card>
                        <div
                            @class(['p-4', 'cursor-pointer' => $category->items_count > 0]) @if ($category->items_count > 0) wire:click="item({{ $category->id }})" @endif>
                            <p class="text-2xl font-semibold uppercase text-primary">
                                {{ $category->name }}
                            </p>
                            <p class="text-sm leading-6 text-gray-600">
                                {{ trans_choice(
                                    'frontend.categories',
                                    $category->items_count ?? 0, [
                                        'count' => $category->items_count ?? 0
                                ]) }}
                            </p>
                        </div>
                    </x-ui.card>
                </div>
            @empty
                <div class="col-span-full">
                    <x-ui.card.empty text="Ainda não há nenhuma categoria de presente. Volte daqui a pouco! 😉"/>
                </div>
            @endforelse
        </div>
    @endif

    @if ($filtered && $items)
        <div class="flex items-center gap-2">
            <p class="text-4xl font-bold uppercase text-primary">
                {{ $filterCategory->name }}
            </p>
            @if ($filterCategory->description)
                <p class="text-gray-600 text-md">{{ $filterCategory->description }}</p>
            @endif
        </div>
        <div class="mt-2">
            <x-ui.tag wire:model.live="search.name" label="Item Name"  />
        </div>
        <div wire:key="item"
             wire:loading.remove
             wire:target="category"
             class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3"
        >
            @php /** @var \App\Models\Item $item */ @endphp
            @forelse ($items as $item)
                <div class="col-span-1" id="{{ str()->uuid() }}">
                    <x-ui.card>
                        <div class="p-4">
                            <p class="text-2xl font-semibold uppercase text-primary">
                                {{ $item->name }}
                                @if ($item->description)
                                    <x-ui.tooltip :text="$item->description"/>
                                @endif
                            </p>
                            <p class="text-sm leading-6 text-gray-600">
                                {!! trans_choice(
                                    '{1} 1 unidade disponível :quota|[2,*] :count unidades disponíveis :quota',
                                    $item->availableQuantity(), [
                                        'count' => $item->availableQuantity(),
                                        'quota' => $item->is_quotable ? __('<b class="text-primary">(quotes)</b>') : '',
                                ]) !!}
                            </p>
                        </div>
                        <x-ui.button
                            xs
                            primary
                            class="w-full"
                            label="ASSINAR"
                            x-on:click="$dispatch('frontend::signature', {item: '{{ $item->id }}'})"
                        />
                    </x-ui.card>
                </div>
            @empty
                <div class="col-span-full">
                    <x-ui.card.empty text="Ops! Não encontramos o item que você está procurando. 😢"/>
                </div>
            @endforelse
        </div>
        <div class="mt-4 flex justify-start gap-2">
            <div class="space-x-2">
                <x-frontend.float-button
                    primary
                    wire:loading.remove
                    wire:target="category"
                    wire:click="category"
                />
                @if ($items->isNotEmpty())
                    <x-frontend.float-button
                        green
                        wire:loading.remove
                        wire:target="category"
                        wire:click="more"
                    />
                @endif
            </div>
        </div>
    @endif
</div>
