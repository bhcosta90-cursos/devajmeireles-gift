<?php

declare(strict_types = 1);

use App\Livewire\Admin\Signatures;
use App\Models\{Item, Signature};
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\{assertSoftDeleted, get};
use function Pest\Livewire\livewire;

describe('has livewire - admin - signatures -> page', function () {
    beforeEach(fn () => mockAuthentication());

    it('can render component', function () {
        get(route('admin.signatures'))
            ->assertSuccessful();
    });

    it('can list register with filters', function () {

        Signature::insert(Signature::factory()
            ->count(5)
            ->sequence(fn (Sequence $sequence) => [
                'name'       => "Signature Signature {$sequence->index}",
                'item_id'    => Item::factory()->create(['name' => "Signature Item {$sequence->index}"])->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ])
            ->make()
            ->toArray());

        Signature::insert(Signature::factory()
            ->count(30)
            ->sequence(fn (Sequence $sequence) => [
                'name'       => "Signature {$sequence->index}",
                'item_id'    => Item::factory()->create(['name' => "Item {$sequence->index}"])->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ])
            ->make()
            ->toArray());

        livewire(Signatures::class)
            ->assertSee('Signature 29')
            ->assertSee('Signature 18')
            ->assertDontSee('Signature 17')
            ->set('search', ['name' => ['Signature Signature 1']])
            ->assertSee('Signature Signature 1')
            ->assertDontSee('Signature Signature 2')
            ->assertSuccessful();
    });

    it('can delete a register and dispatch the correct event', function () {
        livewire(Signatures::class)
            ->assertDelete(($item = Signature::factory()->create())->id)
            ->assertDispatched('manage::list');

        assertSoftDeleted($item);
    });
});
