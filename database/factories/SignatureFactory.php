<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\{Item, Signature};
use Illuminate\Database\Eloquent\Factories\Factory;

class SignatureFactory extends Factory
{
    protected $model = Signature::class;

    public function definition(): array
    {
        return [
            'item_id'     => Item::factory(),
            'name'        => $this->faker->name(),
            'phone'       => $this->faker->phoneNumber(),
            'delivery'    => $this->faker->numberBetween(0, 50),
            'observation' => $this->faker->word(),
        ];
    }
}
