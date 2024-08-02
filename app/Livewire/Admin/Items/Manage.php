<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Items;

use App\Livewire\Traits\Dialog;
use App\Models\{Category, Item};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On, Rule};
use Livewire\Component;

class Manage extends Component
{
    use Dialog;

    public bool $slide = false;

    public string $title = 'Create Item';

    public ?Item $item = null;

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
        return view('livewire.admin.items.manage');
    }

    #[Computed]
    public function categories(): array
    {
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

    public function updatedSlide(): void
    {
        $this->resetExcept('slide');
        $this->resetValidation();
    }

    #[On('manager::edit')]
    public function load(Item $item): void
    {
        $this->item = $item;

        $this->name        = $item->name;
        $this->category    = $item->category_id;
        $this->description = $item->description;
        $this->reference   = $item->reference;
        $this->quantity    = $item->quantity;
        $this->price       = $item->price;

        $this->slide = true;
        $this->title = 'Edit Item';
    }

    public function save(): Item | bool
    {
        $data = $this->validate() + [
            'category_id' => $this->category,
        ];

        $response = $this->item
            ? $this->item->update($data)
            : Item::create($data);

        $this->reset();
        $this->dispatch('manage::list');

        $this->notifySuccess();

        return $response;
    }
}
