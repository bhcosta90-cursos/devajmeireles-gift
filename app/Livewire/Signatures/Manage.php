<?php

declare(strict_types = 1);

namespace App\Livewire\Signatures;

use App\Livewire\Traits\Dialog;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Manage extends Component
{
    use Dialog;

    public bool $slide = false;

    public string $title = 'Create Signature';

    public ?Item $modelItem;

    public ?int $item;

    public int $quantity = 1;

    public function render(): View
    {
        return view('livewire.signatures.manage');
    }

    public function updatedItem(): void
    {
        $this->modelItem = Item::find($this->item);
    }
}
