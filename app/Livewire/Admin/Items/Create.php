<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Items;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public bool $slide = false;

    #[Rule(['required'])]
    public ?int $category = null;

    #[Rule(['required', 'string', 'min:2', 'max:255'])]
    public ?string $name = null;

    #[Rule(['nullable', 'string', 'max:255'])]
    public ?string $description = null;

    #[Rule(['nullable', 'url', 'max:255'])]
    public ?string $reference = null;

    #[Rule(['required', 'integer', 'min:0'])]
    public ?int $quantity = null;

    #[Rule(['required', 'numeric', 'min:0'])]
    public ?float $price = null;

    public function render(): View
    {
        return view('livewire.admin.items.create');
    }

    #[Computed]
    public function categories(): array {
        return Category::query()
            ->get()
            ->map(function (Category $category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })
            ->toArray();
    }

    public function save(): Item {
        $data = $this->validate();

        $response = Item::create($data);

        $this->slide = false;
        $this->reset();
        $this->resetValidation();

        $this->dispatch('table::updated');

        return $response;
    }
}
