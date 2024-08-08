<?php

declare(strict_types = 1);

use App\Livewire\Admin\Categories\Manage;
use App\Models\{Category};
use Tests\Support\ValidateData;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

describe('has livewire - admin - categories - manage -> component', function () {
    beforeEach(fn () => mockAuthentication());

    it('validates category fields correctly', function () {
        $category = Category::factory()->create();

        $data = [
            ValidateData::make()
                ->field('name', '', 'required')
                ->run(),
            ValidateData::make()
                ->field('name', 1, 'min:2')
                ->run(),
            ValidateData::make()
                ->field('name', str_repeat('a', 256), 'max:255')
                ->field('description', str_repeat('a', 256), 'max:255')
                ->run(),
            ValidateData::make()
                ->field('name', $category->name, 'unique')
                ->run(),
        ];

        livewire(Manage::class)
            ->toBeValidateErrors($data);
    });

    it('can create an category and dispatch the correct event', function () {
        $category = Category::factory()->make();

        livewire(Manage::class, ['slide' => true])
            ->set('name', $category->name)
            ->set('description', $category->description)
            ->set('active', $category->active)
            ->assertSave()
            ->assertSet('slide', false)
            ->assertDispatched('manage::list');

        assertDatabaseCount(Category::class, 1);
        assertDatabaseHas(Category::class, $category->toArray());
    });

    it('can load and update an category and dispatch the correct event', function () {
        $category = Category::factory()->create();

        livewire(Manage::class)
            ->call('load', $category->id)
            ->assertSet('category.id', $category->id)
            ->assertSet('slide', true)
            ->set('name', $category->name)
            ->set('description', $category->description)
            ->set('active', $category->active)
            ->assertSave()
            ->assertSet('slide', false)
            ->assertDispatched('manage::list');

        assertDatabaseCount(Category::class, 1);
        assertDatabaseHas(Category::class, collect($category->toArray())->except([
            'created_at',
            'updated_at',
        ])->toArray());
    });
});
