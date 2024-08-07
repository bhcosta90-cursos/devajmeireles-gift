<?php

declare(strict_types = 1);

namespace App\Livewire\Traits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait HasPermission
{
    use AuthorizesRequests;

    abstract protected function getPermission(): string;

    public function mount(): void
    {
        $this->verifyPermission();
    }

    protected function verifyPermission(): void
    {
        $this->authorize($this->getPermission(), ...$this->getPermissionParams());
    }

    protected function getPermissionParams(): array
    {
        return [];
    }
}
