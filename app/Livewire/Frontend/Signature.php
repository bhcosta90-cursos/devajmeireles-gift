<?php

declare(strict_types = 1);

namespace App\Livewire\Frontend;

use App\Enums\DeliveryType;
use App\Models\Item;
use App\Services\Facades\Settings;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Signature extends Component
{
    public bool $modal = false;

    public ?Item $item = null;

    public ?int $delivery = null;

    public ?string $name = null;

    public ?string $observation = null;

    public int $quantity = 1;

    public function render(): View
    {
        return view('livewire.frontend.signature');
    }

    #[On('frontend::signature')]
    public function load(Item $item): void
    {
        $this->item  = $item;
        $this->modal = true;
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
}
