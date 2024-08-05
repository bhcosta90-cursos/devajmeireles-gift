<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <livewire:dashboard.card :card="\App\Enums\CardType::AllItems" />
                <livewire:dashboard.card :card="\App\Enums\CardType::ItemSigned" />
                <livewire:dashboard.card :card="\App\Enums\CardType::ItemNotSigned" />
            </div>
            <livewire:dashboard.chart />
        </div>
    </div>
</x-app-layout>
