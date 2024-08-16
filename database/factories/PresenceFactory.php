<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Presence;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresenceFactory extends Factory
{
    protected $model = Presence::class;

    public function definition(): array
    {
        return [
            'name'         => $this->faker->name(),
            'quantity'     => $this->faker->numberBetween(1, 5),
            'is_confirmed' => $this->faker->boolean(),
        ];
    }
}
