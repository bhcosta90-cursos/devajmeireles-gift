<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\{Category, Item, Signature};
use DB;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SignatureSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->pluck('id')->toArray();

        DB::transaction(fn () => Signature::factory(30)
            ->sequence(fn (Sequence $sequence) => [
                'item_id' => Item::factory()->create([
                    'name'        => "Signature: " . $sequence->index,
                    'category_id' => fake()->randomElement($categories),
                ]),
                'created_at' => fake()->dateTimeBetween('-5 days')->format('Y-m-d H:i:s'),
            ])
            ->create());
    }
}
