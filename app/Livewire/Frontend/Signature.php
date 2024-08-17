<?php

declare(strict_types = 1);

namespace App\Livewire\Frontend;

use App\Enums\DeliveryType;
use App\Livewire\Traits\HasDialog;
use App\Livewire\Traits\Signature\SignatureCreate;
use App\Models\Item;
use App\Services\Facades\Settings;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Signature extends Component
{
    use HasDialog;

    use SignatureCreate {
        createSignature as createSignature;
        rulesSignature as rules;
    }

    public bool $modal = false;

    public ?int $item = null;

    public ?Item $modelItem = null;

    public ?int $delivery = null;

    public ?string $name = null;

    public ?string $observation = null;

    public ?string $phone = null;

    public ?int $presence = null;

    public int $quantity = 1;

    public function render(): View
    {
        return view('livewire.frontend.signature');
    }

    #[On('frontend::signature')]
    public function load(Item $item): void
    {
        $this->modelItem = $item;
        $this->item      = $item->id;
        $this->modal     = true;
    }

    public function create(): void
    {
        $data = $this->validate() + [
            'item_id'  => $this->item,
            'delivery' => $this->delivery,
        ];

        $this->createSignature(
            item: $this->modelItem,
            name: $data['name'],
            phone: $data['phone'],
            quantity: $data['quantity'],
            observation: $data['observation'],
        );

        $this->reset();
        $this->dispatch('manage::list');

        $this->notifySuccess(message: 'Thanks! we appreciate your gift with all our hearts');

        $this->modal = false;
    }

    #[Computed]
    public function getDelivery(): array
    {
        return DeliveryType::toSelect();
    }

    #[Computed]
    public function isPresence(): bool
    {
        return (bool) Settings::get('covert_signature_to_presence');
    }

    protected function item(): ?Item
    {
        return $this->modelItem;
    }
}
