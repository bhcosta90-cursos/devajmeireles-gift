<div>
    <x-ui.slide :label="$title">
        <x-slot:button>
            <x-ui.button.circle primary icon="plus" label="12" wire:click="$toggle('slide')" md />
        </x-slot:button>
        <div class="space-y-4">
            <x-ui.toggle wire:model="active" />
            <x-ui.input label="Name" wire:model="name" />
        </div>
    </x-ui.slide>
</div>
