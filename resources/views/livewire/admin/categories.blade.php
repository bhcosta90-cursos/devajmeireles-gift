<div>
    <x-slot name="header">
        {{ __('Categories') }}
    </x-slot>

    <div class="space-y-4">
        <div class="flex justify-between items-end gap-8">
            <div class="flex-grow">
                <x-ui.tag wire:model.live="search.name" label="Category Name"  />
            </div>
            <livewire:admin.categories.manage />
        </div>

        <x-ui.table :records="$this->records">
            <x-ui.table.thead>
                <x-ui.table.tr>
                    <x-ui.table.th column="categories.id" :$sortDirection :$sortColumn first label="#" />
                    <x-ui.table.th column="categories.name" :$sortDirection :$sortColumn label="Category" />
                    <x-ui.table.th class="w-0" label="Active" />
                    <x-ui.table.th class="w-0 text-right" label="Actions" />
                </x-ui.table.tr>
            </x-ui.table.thead>

            <x-ui.table.tbody>
                @foreach($this->records as $record)
                    <x-ui.table.tr>
                        <x-ui.table.td first>{{ $record->id }}</x-ui.table.td>
                        <x-ui.table.td>{{ $record->name }}</x-ui.table.td>
                        <x-ui.table.td><x-ui.badge.active :value="$record->is_active" /></x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.action.edit
                                @click="$dispatch('manager::edit', {category: {{ $record->id }}})"
                                type="edit"
                            />
                            <x-ui.action.danger
                                type="delete"
                                wire:click="delete({{ $record->id }})"
                            />
                        </x-ui.table.td>
                    </x-ui.table.tr>
                @endforeach
            </x-ui.table.tbody>
        </x-ui.table>
    </div>
</div>
