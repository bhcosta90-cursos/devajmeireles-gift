<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Signature;

use App\Enums\DeliveryType;
use App\Livewire\Frontend\Signature;
use App\Models\{Item, Presence};
use App\Services\Facades\Settings;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;

trait SignatureCreate
{
    abstract protected function item(): ?Item;

    public function createSignature(
        Item $item,
        string $name,
        string $phone,
        int $delivery,
        int $quantity,
        string $observation,
        int $presence,
    ): array {
        $idPresence = null;

        if ($delivery === DeliveryType::InPerson->value && $presence > 0 && $this->isPresence()) {
            $idPresence = Presence::create([
                'name'         => $name,
                'quantity'     => $presence,
                'is_confirmed' => true,
            ])->id;
        }

        $response = $item->signatures()
            ->createMany(
                Collection::times(
                    $quantity,
                    fn () => [
                        'presence_id' => $idPresence,
                        'phone'       => $phone,
                        'observation' => $observation,
                        'name'        => $name,
                        'delivery'    => $delivery,
                    ]
                )
            )->toArray();

        $item->update([
            'is_active'      => $item->available(),
            'last_signed_at' => now(),
        ]);

        return $response;
    }

    protected function rulesSignature(): array
    {
        return [
            'name' => 'required|min:2',
            'item' => [
                'required',
                Rule::exists('items', 'id')->where('is_active', true),
            ],
            'quantity' => [
                'required',
                'numeric',
                'min:1',
                'max:' . ($this->item()?->availableQuantity() ?: '0'),
            ],
            'phone'       => Rule::when($this instanceof Signature, ['required'], ['nullable']),
            'observation' => 'nullable|max:200',
            'delivery'    => ['required', Rule::enum(DeliveryType::class)],
            'presence'    => [
                'nullable',
                Rule::requiredIf(
                    fn () => $this->isPresence && $this->delivery === DeliveryType::InPerson->value && blank($this->signature)
                ),
                'min:0',
                'max:20',
                'numeric',
            ],
        ];
    }

    #[Computed]
    public function isPresence(): bool
    {
        return (bool) Settings::get('covert_signature_to_presence');
    }
}
