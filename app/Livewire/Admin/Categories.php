<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\{HasDialog,
    HasTable,
    Permission\HasPermissionDelete,
    Permission\HasPermissionEdit,
    Permission\HasPermissionIndex};
use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Categories extends Component
{
    use HasDialog;
    use HasTable;
    use HasPermissionIndex;
    use HasPermissionDelete;
    use HasPermissionEdit;

    public function render(): View
    {
        return view('livewire.admin.categories');
    }

    public array $search = [
        'name' => [],
    ];

    public function mount(): void
    {
        $this->sortColumn    = 'categories.name';
        $this->sortDirection = 'asc';
    }

    public function delete(Category $category): void
    {
        $this->deleteItem($category->id);
    }

    public function canDelete(Category $category): void
    {
        $category->delete();
        $this->dispatch('manage::list');
        $this->notifyDeleted();
    }

    #[Computed]
    #[On('manage::list')]
    public function records(): Paginator
    {
        return Category::query()
            ->select([
                'categories.id',
                'categories.name',
                'categories.is_active',
            ])
            ->search($this->search)
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
            Category::class,
        ];
    }
}
