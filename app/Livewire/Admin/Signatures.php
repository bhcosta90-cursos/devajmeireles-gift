<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\{Dialog, Table};
use App\Models\Signature;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Signatures extends Component
{
    use Dialog;
    use Table;

    public array $search = [
        'name'       => [],
        'categories' => [],
        'items'      => [],
    ];

    public function render(): View
    {
        return view('livewire.admin.signatures');
    }

    public function mount(): void
    {
        $this->sortColumn    = 'signatures.created_at';
        $this->sortDirection = 'desc';
        $this->quantity      = 12;
    }

    #[Computed]
    #[On('manage::list')]
    public function records(): Paginator
    {
        return Signature::query()
            ->select([
                'signatures.*',
                'items.name as item_name',
            ])
            ->join('items', 'signatures.item_id', '=', 'items.id')
            ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
            ->search([
                'signatures.name' => $this->search['name'] ?? [],
                'items.name'      => $this->search['items'] ?? [],
                'categories.name' => $this->search['categories'] ?? [],
                'created_at'      => $this->search['created_at'] ?? [],
            ])
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate($this->quantity);
    }

    public function delete(Signature $item): void
    {
        $this->deleteItem($item->id);
    }

    public function canDelete(Signature $item): void
    {
        $item->delete();
        $this->dispatch('manage::list');
        $this->notifyDeleted();
    }

    #[On('filter::advanced')]
    public function listenerSearch(array $search): void
    {
        $this->setPage(1);

        foreach ($search as $key => $value) {
            $this->search[$key] = $value;
        }
    }
}
