<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\{Category, Item};
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all()->pluck('id')->toArray();

        $items = Item::factory(100)
            ->make()
            ->each(function (Item $item) use ($categories) {
                $item->price *= 100;
                $item->category_id = fake()->randomElement($categories);
            });

        Item::upsert($items->toArray(), uniqueBy: ['name']);
    }
}
