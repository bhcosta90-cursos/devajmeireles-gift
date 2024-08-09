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
        $name     = $this->faker->name();
        $delivery = $this->faker->randomElement(DeliveryType::cases());

        return [
            'item_id'     => Item::factory(),
            'presence_id' => $delivery === DeliveryType::InPerson
                ? Presence::factory()->create(['name' => $name])
                : null,
            'name'        => $name,
            'delivery'    => $delivery,
            'phone'       => $this->faker->phoneNumber(),
            'observation' => $this->faker->word(),
        ];
    }
}
