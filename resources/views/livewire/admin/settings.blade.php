<div>
    <x-slot name="header">
        {{ __('Categories') }}
    </x-slot>

    <div class="space-y-4">
        <div class="flex justify-end">
            @can('create', \App\Models\Setting::class)
                <livewire:admin.settings.create />
            @endif
            <livewire:admin.settings.update />
        </div>
        <x-ui.table :records="$this->records">
            <x-ui.table.thead>
                <x-ui.table.tr>
                    <x-ui.table.th column="key" :$sortDirection :$sortColumn label="Key" />
                    <x-ui.table.th column="value" label="Value" />
                    <x-ui.table.th class="w-0 text-right" label="Actions" />
                </x-ui.table.tr>
            </x-ui.table.thead>

            <x-ui.table.tbody>
                @foreach($this->records as $record)
                    <x-ui.table.tr>
                        <x-ui.table.td>{{ $record->key }}</x-ui.table.td>
                        <x-ui.table.td>{{ str($record->value)->limit(30) }}</x-ui.table.td>
                        <x-ui.table.td>
                            <x-ui.action.edit
                                @click="$dispatch('manager::edit', {setting: {{ $record->id }}})"
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
