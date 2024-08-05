<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="col-span-full sm:col-span-1">
                    <x-ui.card>
                        <div class="ml-4 p-2">
                            <div class="flex items-center justify-start">
                                <div class="flex-shrink-0">
                                    <p class="text-3xl font-semibold text-primary">123</p>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" title="TEST">
                                        @lang('Registered items')
                                    </h3>
                                    <x-ui.badge outline primary>
                                        80% em fraldas
                                    </x-ui.badge>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>

                <div class="col-span-full sm:col-span-1">
                    <x-ui.card>
                        <div class="ml-4 p-2">
                            <div class="flex items-center justify-start">
                                <div class="flex-shrink-0">
                                    <p class="text-3xl font-semibold text-primary">123</p>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" title="TEST">
                                        @lang('Signed items')
                                    </h3>
                                    <x-ui.badge outline primary>
                                        22% em utensílios
                                    </x-ui.badge>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>

                <div class="col-span-full sm:col-span-1">
                    <x-ui.card>
                        <div class="ml-4 p-2">
                            <div class="flex items-center justify-start">
                                <div class="flex-shrink-0">
                                    <p class="text-3xl font-semibold text-primary">123</p>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" title="TEST">
                                        @lang('Remaining items')
                                    </h3>
                                    <x-ui.badge outline primary>
                                        20% em roupas
                                    </x-ui.badge>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            </div>
            <x-ui.card>
                <div id="chart"></div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
