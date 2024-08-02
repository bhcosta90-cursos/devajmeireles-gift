<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\Table;
use App\Models\Item;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Items extends Component
{
    use Table;

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

    #[Computed]
    public function records(): Paginator
    {
        return Item::query()
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate();
    }
}
