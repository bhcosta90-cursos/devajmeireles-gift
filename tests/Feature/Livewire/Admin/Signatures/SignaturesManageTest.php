<?php

declare(strict_types = 1);

use App\Livewire\Admin\Signatures\Manage;
use App\Models\{Item, Signature};
use Tests\Support\ValidateData;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

describe('has livewire - admin - signatures - signatures - manage -> component', function () {
    beforeEach(function () {
        mockAuthentication();
        $this->item = Item::factory()->create(['quantity' => 6]);
    });

    it('validates signature fields correctly', function () {
        $data = [
            ValidateData::make()
                ->field('name', '', 'required')
                ->field('item', '', 'required')
                ->field('phone', '', 'required')
                ->field('delivery', '', 'required')
                ->run(),

            ValidateData::make()
                ->field('name', 'a', 'min:2')
                ->run(),

            ValidateData::make()
                ->field('item', '0', 'exists:items,id')
                ->run(),

            ValidateData::make()
                ->field('quantity', '0', 'min:1')
                ->run(),

            ValidateData::make()
                ->field('observation', str_repeat('a', 201), 'max:200')
                ->run(),
        ];

        livewire(Manage::class)
            ->toBeValidateErrors($data);
    });

    it('creates a new signature and saves it correctly', function () {
        $signature = Signature::factory()->make();

        livewire(Manage::class)
            ->call('createItem')
            ->assertSet('slide', true)
            ->set([
                'item'        => $this->item->id,
                'delivery'    => $signature->delivery->value,
                'quantity'    => $quantity = 2,
                'name'        => $signature->name,
                'phone'       => $signature->phone,
                'observation' => $signature->observation,
            ])
            ->assertSet('modelItem.id', $this->item->id)
            ->assertSave()
            ->assertReturned(function ($data) use ($quantity) {
                assertDatabaseCount(Signature::class, $quantity);

                foreach ($data as $rs) {
                    assertDatabaseHas(
                        Signature::class,
                        Arr::except($rs, ['created_at', 'updated_at', 'deleted_at'])
                    );
                }

                return true;
            });
    });

    it('loads and updates a signature correctly', function () {
        $newSignature = Signature::factory()->make();
        $signature    = Signature::factory()->create([
            'item_id' => $this->item,
        ]);

        livewire(Manage::class)
            ->call('load', $signature->id)
            ->assertSet('slide', true)
            ->set([
                'item'        => $this->item->id,
                'delivery'    => $newSignature->delivery->value,
                'name'        => $newSignature->name,
                'phone'       => $newSignature->phone,
                'observation' => $newSignature->observation,
            ])
            ->assertSet('modelItem.id', $this->item->id)
            ->assertSave()
            ->assertReturned(function () use ($newSignature) {
                assertDatabaseCount(Signature::class, 1);

                assertDatabaseHas(
                    Signature::class,
                    Arr::except(
                        ['item_id' => $this->item->id] + $newSignature->toArray(),
                        ['created_at', 'updated_at', 'deleted_at']
                    )
                );

                return true;
            });
    });

    it('loads and updates a signature with a new signature correctly', function () {
        $newSignature = Signature::factory()->make();
        $signature    = Signature::factory()->create([
            'item_id' => $this->item,
        ]);

        livewire(Manage::class)
            ->call('load', $signature->id)
            ->assertSet('slide', true)
            ->set([
                'item'        => $newSignature->item->id,
                'delivery'    => $newSignature->delivery->value,
                'name'        => $newSignature->name,
                'phone'       => $newSignature->phone,
                'observation' => $newSignature->observation,
            ])
            ->assertSet('modelItem.id', $newSignature->item->id)
            ->assertSave()
            ->assertReturned(function () use ($newSignature) {
                assertDatabaseCount(Signature::class, 1);

                assertDatabaseHas(
                    Signature::class,
                    Arr::except(
                        $newSignature->toArray(),
                        ['created_at', 'updated_at', 'deleted_at', 'item']
                    )
                );

                return true;
            });
    });

    it('loads and updates a signature with a new item and checks for errors', function () {
        $item = Item::factory()->create([
            'quantity' => 1,
        ]);

        Signature::factory()->create([
            'item_id' => $item->id,
        ]);

        $signature = Signature::factory()->create([
            'item_id' => $this->item,
        ]);

        $newSignature = Signature::factory()->make();

        livewire(Manage::class)
            ->call('load', $signature->id)
            ->assertSet('slide', true)
            ->set([
                'item'        => $item->id,
                'delivery'    => $newSignature->delivery->value,
                'name'        => $newSignature->name,
                'phone'       => $newSignature->phone,
                'observation' => $newSignature->observation,
            ])
            ->assertSet('modelItem.id', $item->id)
            ->assertSave(errors: ['item']);
    });
});
