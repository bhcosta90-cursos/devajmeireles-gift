<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Items;

use App\Livewire\Traits\Dialog;
use App\Livewire\Traits\Model\SelectCategory;
use App\Models\{Category, Item};
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Manage extends Component
{
    use Dialog;
    use SelectCategory;

    public bool $slide = false;

    public string $title = 'Create Item';

    public ?Item $item = null;

    public ?int $category = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $reference = null;

    public ?int $quantity = null;

    public ?float $price = null;

    public ?bool $active = true;

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
        $this->active      = $item->is_active;

        $this->slide = true;
        $this->title = 'Edit Item';
    }

    public function save(): Item | bool
    {
        $data = $this->validate() + [
            'category_id' => $this->category,
            'is_active'   => $this->active,
        ];

        $response = $this->item
            ? $this->item->update($data)
            : Item::create($data);

        $this->reset();
        $this->dispatch('manage::list');

        $this->notifySuccess();

        return $response;
    }

    protected function rules(): array
    {
        return [
            'category'    => ['required', Rule::exists('categories', 'id')],
            'name'        => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'reference'   => ['nullable', 'url', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'price'       => ['required', 'numeric', 'min:0'],
            'active'      => ['required', 'boolean'],
        ];
    }
}
