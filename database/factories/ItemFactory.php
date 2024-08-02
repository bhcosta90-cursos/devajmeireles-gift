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
            'category_id' => Category::factory(),
            'name'        => $this->faker->text(15),
            'quantity'    => $this->faker->numberBetween(10, 50),
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
