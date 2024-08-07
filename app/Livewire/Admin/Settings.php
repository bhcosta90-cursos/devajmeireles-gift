<?php

declare(strict_types = 1);

namespace App\Livewire\Admin;

use App\Livewire\Traits\{HasDialog, HasTable, Permission\HasPermissionIndex};
use App\Models\Setting;
use App\Services\Facades\Settings as SettingsFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Settings extends Component
{
    use HasTable;
    use HasDialog;
    use HasPermissionIndex;

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

    public function delete(Setting $setting): void
    {
        $this->deleteItem($setting->id);
    }

    public function canDelete(Setting $setting): void
    {
        $setting->delete();
        SettingsFacade::forgot($setting->key);
        $this->notifyDeleted();
    }

    #[Computed]
    public function buttonDeleted(): bool
    {
        return auth()->user()->can('delete', Setting::class);
    }

    protected function getPermissionName(): string
    {
        return 'viewAny';
    }

    protected function getPermissionParams(): array
    {
        return [
            Setting::class,
        ];
    }
}
