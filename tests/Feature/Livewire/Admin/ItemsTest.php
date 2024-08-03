<?php

declare(strict_types = 1);

use App\Livewire\Admin\Items;
use App\Livewire\Admin\Items\Manage;
use App\Models\{Category, Item};
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

describe('has livewire - admin - items page', function () {
    beforeEach(fn () => mockAuthentication());

    it('can render component', function () {
        get(route('items'))
            ->assertSuccessful()
            ->assertSeeLivewire(Manage::class);
    });

    it('can list items with correct names and categories', function () {
        Category::insert(Category::factory(2)
            ->sequence(fn (Sequence $sequence) => ['name' => "Category {$sequence->index}"])
            ->make()
            ->toArray());

        Item::insert(Item::factory()
            ->count(30)
            ->sequence(fn (Sequence $sequence) => ['name' => "Item {$sequence->index}"])
            ->make([
                'category_id' => 1,
            ])
            ->toArray());

        Item::insert(Item::factory()
            ->count(5)
            ->sequence(fn (Sequence $sequence) => ['name' => "Item Category {$sequence->index}"])
            ->make([
                'category_id' => 2,
            ])
            ->toArray());

        livewire(Items::class)
            ->set('sortColumn', 'items.id')
            ->assertSee('Item 0')
            ->assertSee('Item 9')
            ->assertDontSee('Item 10')
            ->set('search', ['name' => ['Item 1']])
            ->assertSee('Item 1')
            ->assertSee('Item 10')
            ->assertSee('Item 11')
            ->assertDontSee('Item 21')
            ->assertDontSee('Item 0')
            ->set('search', ['category' => ['Category 1']])
            ->assertSee('Item Category 0')
            ->assertDontSee('Item 0')
            ->assertSuccessful();
    });
});
