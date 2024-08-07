<div>
    <x-ui.slide
        label="Create Category"
        :permission="auth()->user()->can('create', \App\Models\Category::class)"
        :title="$category ? 'Edit Category' : 'Create Category'"
    >
        <div class="space-y-4">
            <x-ui.toggle wire:model="active" />
            <x-ui.input label="Name" wire:model="name" />
        </div>
    </x-ui.slide>
</div>
