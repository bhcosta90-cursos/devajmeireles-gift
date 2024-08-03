<?php

declare(strict_types = 1);

use function Pest\Laravel\get;

describe('has livewire - admin - items page', function () {
    it('can render component', function () {
        mockAuthentication();

        get(route('items'))
            ->assertSuccessful()
            ->assertSeeLivewire('admin.items.manage');
    });
});
