<?php

declare(strict_types = 1);

namespace App\Livewire\Traits;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

trait HasTable
{
    use WithPagination;

    protected $queryString = ['sortColumn', 'sortDirection', 'quantity', 'search'];

    public int $quantity = 10;

    public function updatedSearch(): void
    {
        $this->setPage(1);
    }

    #[Url]
    public string $sortColumn = 'id';

    #[Url]
    public string $sortDirection = 'desc';

    public function sort($column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn    = $column;
            $this->sortDirection = 'asc';
        }
    }
}
