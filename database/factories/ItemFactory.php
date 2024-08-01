<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\{Category, Item};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
            'name'        => $this->faker->text(15),
            'description' => $this->faker->sentence(),
            'reference'   => $this->faker->word(),
            'quantity'    => $this->faker->numberBetween(10, 50),
            'signed_at'   => Carbon::now(),
            'category_id' => Category::factory(),
            'price'       => $this->faker->numberBetween(500, 5000) / 100,
        ];
    }

    public function disabled(): self
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    public function signed(?Carbon $carbon): self
    {
        return $this->state(fn () => [
            'signed_at' => $carbon ?? $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
