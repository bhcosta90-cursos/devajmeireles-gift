<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Signature;

use App\Livewire\Frontend\Signature;
use App\Models\{Item, Signature as SignatureModel};
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @property SignatureModel|null $signature
 * @property-read bool $isPresence
 */
trait SignatureCreate
{
    abstract protected function item(): ?Item;

    public function createSignature(
        Item $item,
        string $name,
        string $phone,
        int $quantity,
        string $observation,
    ): array {
        $response = $item->signatures()
            ->createMany(
                Collection::times(
                    $quantity,
                    fn () => [
                        'phone'       => $phone,
                        'observation' => $observation,
                        'name'        => $name,
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
        ];
    }
}
