<?php

declare(strict_types = 1);

use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Categories\Manage;
use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\{assertSoftDeleted, get};
use function Pest\Livewire\livewire;

describe('has livewire - admin - categories -> page', function () {
    beforeEach(fn () => mockAuthentication());

    it('can render component', function () {
        get(route('admin.categories'))
            ->assertSuccessful()
            ->assertSeeLivewire(Manage::class);
    });

    it('can list register with filters', function () {
        Category::insert(Category::factory()
            ->count(30)
            ->sequence(fn (Sequence $sequence) => ['name' => "Category {$sequence->index}"])
            ->make()
            ->toArray());

        Category::insert(Category::factory()
            ->count(5)
            ->sequence(fn (Sequence $sequence) => ['name' => "Category Category {$sequence->index}"])
            ->make()
            ->toArray());

        livewire(Categories::class)
            ->set('sortColumn', 'categories.id')
            ->assertSee('Category 0')
            ->assertSee('Category 9')
            ->assertDontSee('Category 10')
            ->set('search', ['name' => ['Category 1']])
            ->assertSee('Category 1')
            ->assertSee('Category 10')
            ->assertSee('Category 11')
            ->assertDontSee('Category 21')
            ->assertDontSee('Category 0')
            ->assertSuccessful();
    });

    it('can paginate registers correctly', function () {
        Category::insert(Category::factory()
            ->count(13)
            ->sequence(fn (Sequence $sequence) => ['name' => "Category {$sequence->index}"])
            ->make()
            ->toArray());

        livewire(Categories::class)
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
        livewire(Categories::class)
            ->assertDelete(($item = Category::factory()->create())->id)
            ->assertDispatched('manage::list');

        assertSoftDeleted($item);
    });
});
