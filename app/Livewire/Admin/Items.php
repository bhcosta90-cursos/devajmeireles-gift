<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\{Dialog, Table};
use App\Models\Item;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Items extends Component
{
    use Dialog;
    use Table;

    public array $search = [
        'name'     => [],
        'category' => [],
    ];

    public function mount(): void
    {
        $this->sortColumn    = 'items.name';
        $this->sortDirection = 'asc';
    }

    public function render(): View
    {
        return view('livewire.admin.items');
    }

    public function delete(Item $item): void
    {
        $this->deleteItem($item->id);
    }

    public function canDelete(Item $item): void
    {
        $item->delete();
        $this->dispatch('manage::list');
        $this->notifyDeleted();
    }

    #[Computed]
    #[On('manage::list')]
    public function records(): Paginator
    {
        return Item::query()
            ->select([
                'items.id',
                'items.name',
                'items.price',
                'items.quantity',
                'items.is_active',
                'categories.name as category_name',
            ])
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->search([
                'items.name'      => $this->search['name'] ?? [],
                'categories.name' => $this->search['category'] ?? [],
            ])
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate(perPage: $this->quantity);
    }
}
