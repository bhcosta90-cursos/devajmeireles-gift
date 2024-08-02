<div>
    <x-slot name="header">
        {{ __('Items') }}
    </x-slot>
    <x-ts-tag wire:model.live="search.name" />
    <x-ui.table :records="$this->records">
        <x-ui.table.thead>
            <x-ui.table.tr>
                <x-ui.table.th column="id" :$sortDirection :$sortColumn first label="#" />
                <x-ui.table.th column="name" :$sortDirection :$sortColumn>Item Name</x-ui.table.th>
                <x-ui.table.th column="price" :$sortDirection :$sortColumn>Item Price</x-ui.table.th>
                <x-ui.table.th>Item Quantity</x-ui.table.th>
                <x-ui.table.th>Actions</x-ui.table.th>
            </x-ui.table.tr>
        </x-ui.table.thead>

        <x-ui.table.tbody>
            @foreach($this->records as $record)
                <x-ui.table.tr>
                    <x-ui.table.td first>{{ $record->id }}</x-ui.table.td>
                    <x-ui.table.td>{{ $record->name }}</x-ui.table.td>
                    <x-ui.table.td>{{ currency($record->price) }}</x-ui.table.td>
                    <x-ui.table.td>{{ $record->quantity }}</x-ui.table.td>
                    <x-ui.table.td>

                    </x-ui.table.td>
                </x-ui.table.tr>
            @endforeach
        </x-ui.table.tbody>
    </x-ui.table>
</div>
