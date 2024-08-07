<x-ui.slide.slide label="Edit key">
    <div class="space-y-2">
        <x-ui.input disabled label="Key" :value="$setting?->key" disabled />

        @switch($setting?->type)
            @case('date')
                <x-ui.input.date :type="$setting?->type"
                                 label="Value"
                                 wire:model="value"
                />
                @break
            @case('textarea')
                <x-ui.textarea :type="$setting?->type"
                               label="Value"
                               wire:model="value"
                />
                @break
            @case('phone')
                <x-ui.textarea :type="$setting?->type"
                               x-mask="(99) 99999-9999"
                               label="Value"
                               wire:model="value"
                />
                @break
            @case('boolean')
                <div class="pt-2">
                    <x-ui.toggle :type="$setting?->type"
                         label="Value"
                         wire:model="value"
                    />
                </div>
                @break
            @default
                <x-ui.input :type="$setting?->type"
                            label="Value"
                            wire:model="value"
                />
        @endswitch
    </div>
</x-ui.slide.slide>
