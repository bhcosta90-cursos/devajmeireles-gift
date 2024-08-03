@props(['first' => null, 'label' => null, 'column' => null, 'sortColumn' => null, 'sortDirection' => null])

<th scope="col" {{ $attributes->class([
        'py-3.5 text-left text-sm font-semibold text-gray-900',
        'px-3'              => ! $first,
        'pl-4 pr-3 sm:pl-6 w-0' => $first,
    ]) }}>

    <span
       @class([
            'group inline-flex truncate text-primary',
            'cursor-pointer' => $column,
        ])
        @if ($sortColumn && $column && $sortDirection)
           wire:click="sort('{{ $column }}')"
        @endif
    >

        {{ __($label) ?? $slot }}
        <span class="ml-2 flex-none rounded">

            @if ($sortColumn === $column && $sortDirection === 'asc')
                <x-heroicon-s-chevron-up class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @elseif ($sortColumn === $column && $sortDirection === 'desc')
                <x-heroicon-s-chevron-down class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @endif

            @if ($sortColumn !== $column)
                <x-heroicon-s-chevron-down class="inline-block w-4 h-4 ml-1 text-primary-700"/>
            @endif
        </span>
    </span>
</th>
