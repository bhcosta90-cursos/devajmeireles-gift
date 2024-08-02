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
    use Table;
    use Dialog;

    public array $search = [
        'name' => [],
    ];

    public function mount(): void
    {
        $this->sortColumn    = 'name';
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
        $this->notify();
    }

    #[Computed]
    #[On('manage::list')]
    public function records(): Paginator
    {
        return Item::query()
            ->search($this->search)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate(perPage: $this->quantity);
    }
}
