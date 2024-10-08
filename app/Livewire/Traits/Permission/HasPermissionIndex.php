<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Permission;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait HasPermissionIndex
{
    use AuthorizesRequests;

    public function mount(): void
    {
        $this->verifyPermission();
    }

    protected function verifyPermission(): void
    {
        $this->authorize($this->getPermissionName(), ...$this->getPermissionParams());
    }

    protected function getPermissionName(): string
    {
        return 'viewAny';
    }

    abstract protected function getPermissionParams(): array;
}
