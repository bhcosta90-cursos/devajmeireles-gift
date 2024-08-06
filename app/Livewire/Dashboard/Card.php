<?php

declare(strict_types = 1);

namespace App\Livewire\Dashboard;

use App\Enums\CardType;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Isolate;
use Livewire\Component;

#[Isolate]
class Card extends Component
{
    public CardType $card;

    public $quantity = 0;

    public function render(): View
    {
        return view('livewire.dashboard.card');
    }

    public function load(): void
    {
        $this->quantity = (match ($this->card) {
            CardType::AllItems      => Item::count(),
            CardType::ItemSigned    => Item::whereHas('signatures')->count(),
            CardType::ItemNotSigned => Item::whereDoesntHave('signatures')->count(),
        });
    }
}
