<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\DeliveryType;
use App\Models\{Item, Presence, Signature};
use Illuminate\Database\Eloquent\Factories\Factory;

class SignatureFactory extends Factory
{
    protected $model = Signature::class;

    public function definition(): array
    {
        return [
            'item_id'     => Item::factory(),
            'name'        => $name = $this->faker->name(),
            'phone'       => $this->faker->phoneNumber(),
            'delivery'    => $delivery = $this->faker->randomElement(DeliveryType::cases()),
            'observation' => $this->faker->word(),
            'presence_id' => $delivery === DeliveryType::InPerson
                ? Presence::factory()->create(['name' => $name])
                : null,
        ];
    }
}
