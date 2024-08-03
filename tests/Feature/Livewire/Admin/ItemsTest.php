<?php

declare(strict_types = 1);

use App\Livewire\Admin\Items;
use App\Livewire\Admin\Items\Manage;
use App\Models\{Category, Item};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\{assertSoftDeleted, get};
use function Pest\Livewire\livewire;

describe('has livewire - admin - items -> page', function () {
    beforeEach(fn () => mockAuthentication());

    it('can render component', function () {
        get(route('items'))
            ->assertSuccessful()
            ->assertSeeLivewire(Manage::class);
    });

    it('can list register with filters', function () {
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

    it('can paginate registers correctly', function () {
        Item::insert(Item::factory()
            ->count(13)
            ->sequence(fn (Sequence $sequence) => ['name' => "Item {$sequence->index}"])
            ->withCategory(Category::factory()->create())
            ->make()
            ->toArray());

        livewire(Items::class)
            ->assertSet('records', function ($data) {
                expect($data)
                    ->toBeInstanceOf(Paginator::class)
                    ->toHaveCount(10);

                return true;
            })
            ->call('setPage', 2)
            ->assertSet('records', function ($data) {
                expect($data)
                    ->toBeInstanceOf(Paginator::class)
                    ->toHaveCount(3);

                return true;
            });
    });

    it('can delete a register and dispatch the correct event', function () {
        livewire(Items::class)
            ->assertDelete(($item = Item::factory()->create())->id)
            ->assertDispatched('manage::list');

        assertSoftDeleted($item);
    });
});
