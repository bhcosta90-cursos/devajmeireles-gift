<?php

declare(strict_types = 1);

use App\Livewire\Admin\Items\Manage;
use App\Models\{Category, Item};

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};

use function Pest\Livewire\livewire;

use Tests\Support\ValidateData;

describe('has livewire - admin - items - manage -> component', function () {
    beforeEach(fn () => mockAuthentication());

    it('validates item fields correctly', function () {
        $item = Item::factory()->create();

        $data = [
            ValidateData::make()
                ->field('name', '', 'required')
                ->field('quantity', '', 'required')
                ->run(),
            ValidateData::make()
                ->field('category', '100', 'exists')
                ->run(),
            ValidateData::make()
                ->field('name', 1, 'min:2')
                ->field('quantity', -1, 'min:0')
                ->run(),
            ValidateData::make()
                ->field('name', str_repeat('a', 256), 'max:255')
                ->field('description', str_repeat('a', 256), 'max:255')
                ->run(),
            ValidateData::make()
                ->field('name', $item->name, 'unique')
                ->run(),
        ];

        livewire(Manage::class)
            ->toBeValidateErrors($data);
    });

    it('can create an item and dispatch the correct event', function () {
        $category = Category::factory()->create();
        $item     = Item::factory()->make();

        livewire(Manage::class, ['slide' => true])
            ->set('category', $category->id)
            ->set('name', $item->name)
            ->set('description', $item->description)
            ->set('reference', $item->reference)
            ->set('quantity', $item->quantity)
            ->set('price', $item->price)
            ->set('active', $item->active)
            ->set('quotable', $item->quotable)
            ->assertSave()
            ->assertSet('slide', false)
            ->assertDispatched('manage::list');

        $item->price *= 100;
        assertDatabaseCount(Item::class, 1);
        assertDatabaseHas(Item::class, $item->toArray());
    });

    it('can load and update an item and dispatch the correct event', function () {
        $category = Category::factory()->create();
        $item     = Item::factory()->create();

        livewire(Manage::class)
            ->call('load', $item->id)
            ->assertSet('item.id', $item->id)
            ->assertSet('slide', true)
            ->set('category', $category->id)
            ->set('name', $item->name)
            ->set('description', $item->description)
            ->set('reference', $item->reference)
            ->set('quantity', $item->quantity)
            ->set('price', $item->price)
            ->set('active', $item->active)
            ->assertSave()
            ->assertSet('slide', false)
            ->assertDispatched('manage::list');

        $item->price *= 100;
        assertDatabaseCount(Item::class, 1);
        assertDatabaseHas(Item::class, collect($item->toArray())->except([
            'created_at',
            'updated_at',
        ])->toArray());
    });
});
