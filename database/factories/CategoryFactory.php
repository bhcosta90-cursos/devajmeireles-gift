<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name'        => substr($this->faker->text(15), 0, -1),
            'description' => $this->faker->text(),
        ];
    }

    public function disabled(): self
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
