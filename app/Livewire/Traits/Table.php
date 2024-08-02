<?php

declare(strict_types = 1);

namespace App\Livewire\Traits;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

trait Table
{
    use WithPagination;

    protected $queryString = ['sortColumn', 'sortDirection', 'quantity', 'search'];

    public int $quantity = 10;

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

    protected function deleteItem($params, $action = 'canDelete'): void
    {
        $this->dialog()
            ->question(__('Warning!'), __('Are you sure?'))
            ->confirm(__('Confirm'), $action, $params)
            ->cancel(__('Cancel'))
            ->send();
    }

    protected function notifyDelete(): void
    {
        $this->toast()->success(__('Register deleted successfully'))->send();
    }
}
