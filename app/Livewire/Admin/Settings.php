<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\Table;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Settings extends Component
{
    use Table;

    public function mount(): void
    {
        $this->sortColumn    = 'key';
        $this->sortDirection = 'asc';
    }

    public function render(): View
    {
        return view('livewire.admin.settings');
    }

    #[Computed]
    #[On('manage::list')]
    public function records(): Collection
    {
        return Setting::query()
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->get();
    }
}
