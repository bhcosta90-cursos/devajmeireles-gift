<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\{Item, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Bruno Costa',
            'email'    => 'bhcosta90@gmail.com',
            'password' => '$2y$12$.Kzvtisda9P7qO/E7OX1/ebQPESPjYw9omBcmsjWlE7Oa63PeVJJS',
        ]);

        $items = Item::factory(100)
            ->forCategory()
            ->make()
            ->each(fn (Item $item) => $item->price *= 100);

        Item::insert($items->toArray());
    }
}
