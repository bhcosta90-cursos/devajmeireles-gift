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
        $category  = Category::factory()->create(['name' => 'Category 1']);
        $category2 = Category::factory()->create(['name' => 'Category 2']);

        Item::factory()
            ->count(30)
            ->for($category)
            ->sequence(fn (Sequence $sequence) => ['name' => "Item {$sequence->index}"])
            ->create();

        Item::factory()
            ->count(5)
            ->for($category2)
            ->sequence(fn (Sequence $sequence) => ['name' => "Item Category {$sequence->index}"])
            ->create();

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
            ->set('search', ['category' => ['Category 2']])
            ->assertSee('Item Category 0')
            ->assertDontSee('Item 0');
    });
});
