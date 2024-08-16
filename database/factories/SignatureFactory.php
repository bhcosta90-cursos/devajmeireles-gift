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
            'name'        => $this->faker->name(),
            'delivery'    => DeliveryType::Remotely,
            'phone'       => $this->faker->phoneNumber(),
            'observation' => $this->faker->word(),
        ];
    }

    public function withPresence(): self
    {
        return $this->state(fn ($state) => [
            'presence_id' => Presence::factory()->create(['name' => $state['name']]),
            'delivery'    => DeliveryType::InPerson,
        ]);
    }
}
