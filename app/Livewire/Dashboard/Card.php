<?php

declare(strict_types = 1);

namespace App\Livewire\Dashboard;

use App\Enums\{CardType, SecondsType};
use App\Models\Item;
use Cache;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Isolate;
use Livewire\Component;

#[Isolate]
class Card extends Component
{
    public CardType $card;

    public int $quantity = 0;

    public function render(): View
    {
        return view('livewire.dashboard.card');
    }

    public function load(): void
    {
        $this->quantity = Cache::remember(
            key: 'card::' . $this->card->value,
            ttl: SecondsType::Minute->value * 5,
            callback: fn () => match ($this->card) {
                CardType::AllItems      => Item::count(),
                CardType::ItemSigned    => Item::whereHas('signatures')->count(),
                CardType::ItemNotSigned => Item::whereDoesntHave('signatures')->count(),
            }
        );
    }
}
