<div>
    <x-slot name="header">
        {{ __('Items') }}
    </x-slot>

    <div class="space-y-4">
        <div class="flex justify-between items-end gap-8">
            <div class="flex-grow">
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.tag wire:model.live="search.category" label="Category"  />
                    <x-ui.tag wire:model.live="search.name" label="Item Name"  />
                </div>
            </div>
            <livewire:admin.items.manage />
        </div>

        <x-ui.table :records="$this->records">
            <x-ui.table.thead>
                <x-ui.table.tr>
                    <x-ui.table.th column="items.id" :$sortDirection :$sortColumn first label="#" />
                    <x-ui.table.th column="categories.name" :$sortDirection :$sortColumn label="Category" />
                    <x-ui.table.th column="items.name" :$sortDirection :$sortColumn label="Item Name" />
                    <x-ui.table.th class="w-0" column="price" :$sortDirection :$sortColumn label="Item Price" />
                    <x-ui.table.th class="w-0" label="Item Quantity" />
                    <x-ui.table.th class="w-0" label="Quota" />
                    <x-ui.table.th class="w-0" label="Active" />
                    <x-ui.table.th class="w-0 text-right" label="Actions" />
                </x-ui.table.tr>
            </x-ui.table.thead>

            <x-ui.table.tbody>
                @foreach($this->records as $record)
                    <x-ui.table.tr>
                        <x-ui.table.td first>{{ $record->id }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.badge.active :value="$record->category_active" :label="$record->category_name" />
                        </x-ui.table.td>
                        <x-ui.table.td>{{ $record->name }}</x-ui.table.td>
                        <x-ui.table.td class="text-right">{{ currency($record->price) }}</x-ui.table.td>
                        <x-ui.table.td class="text-right">{{ $record->quantity }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.badge.active :value="$record->is_quotable" />
                        </x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.badge.active :value="$record->is_active" />
                        </x-ui.table.td>
                        <x-ui.table.td>
                            @if($this->buttonEdit)
                                <x-ui.action.edit
                                    @click="$dispatch('manager::edit', {item: {{ $record->id }}})"
                                    type="edit"
                                />
                            @endif
                            @if($this->buttonDelete)
                                <x-ui.action.danger
                                    type="delete"
                                    wire:click="delete({{ $record->id }})"
                                />
                            @endif
                        </x-ui.table.td>
                    </x-ui.table.tr>
                @endforeach
            </x-ui.table.tbody>
        </x-ui.table>
    </div>
</div>
