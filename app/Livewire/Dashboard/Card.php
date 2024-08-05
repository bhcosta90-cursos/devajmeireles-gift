<?php

declare(strict_types = 1);

namespace App\Livewire\Dashboard;

use App\Enums\CardType;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Card extends Component
{
    public CardType $card;

    public function render(): View
    {
        return view('livewire.dashboard.card');
    }

    public function load(): void
    {
        sleep(rand(0,5));
    }

    #[Computed]
    public function quantity(): int
    {
        return rand(1, 99);
    }
}
