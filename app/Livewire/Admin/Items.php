<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\{HasDialog,
    HasTable,
    Permission\HasPermissionDelete,
    Permission\HasPermissionEdit,
    Permission\HasPermissionIndex};
use App\Models\Item;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Items extends Component
{
    use HasDialog;
    use HasTable;
    use HasPermissionIndex;
    use HasPermissionEdit;
    use HasPermissionDelete;

    public array $search = [
        'name'     => [],
        'category' => [],
    ];

    public function mount(): void
    {
        $this->sortColumn    = 'items.name';
        $this->sortDirection = 'asc';
        $this->verifyPermission();
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
                'items.is_quotable',
                'categories.name as category_name',
                'categories.is_active as category_active',
            ])
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->search([
                'items.name'      => $this->search['name'] ?? [],
                'categories.name' => $this->search['category'] ?? [],
            ])
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->simplePaginate(perPage: $this->quantity);
    }

    protected function getPermissionParams(): array
    {
        return $this->getDeletePermissionParams();
    }

    protected function getEditPermissionParams(): array
    {
        return $this->getDeletePermissionParams();
    }

    protected function getDeletePermissionParams(): array
    {
        return [
            Item::class,
        ];
    }
}
