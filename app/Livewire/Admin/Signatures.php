<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\{Dialog, Table};
use App\Models\Signature;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Signatures extends Component
{
    use Dialog;
    use Table;

    public array $search = [
        'name' => [],
    ];

    public function render(): View
    {
        return view('livewire.admin.signatures');
    }

    public function mount(): void
    {
        $this->sortColumn    = 'id';
        $this->sortDirection = 'desc';
        $this->quantity      = 12;
    }

    #[Computed]
    public function records(): Paginator
    {
        return Signature::query()
            ->with('item:id,name')
            ->search($this->search)
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
}
