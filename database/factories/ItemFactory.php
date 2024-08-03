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
            'name'     => substr($this->faker->text(15), 0, -1),
            'quantity' => $this->faker->numberBetween(10, 50),
            'price'    => $this->faker->numberBetween(500, 5000) / 100,
        ];
    }

    public function disabled(): self
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    public function quotable(): self
    {
        return $this->state(fn () => [
            'is_quotable' => true,
        ]);
    }

    public function signed(?Carbon $carbon): self
    {
        return $this->state(fn () => [
            'signed_at' => $carbon ?? $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function withCategory(?Category $category = null): self
    {
        return $this->state(fn () => [
            'category_id' => $category ?: Category::factory()->create()->id,
        ]);
    }
}
