<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
            'name'        => $this->faker->text(15),
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
