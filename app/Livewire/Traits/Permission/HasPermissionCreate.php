<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Permission;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Computed;

trait HasPermissionCreate
{
    use AuthorizesRequests;

    #[Computed]
    public function buttonCreate(): bool
    {
        return auth()->user()->can(
            $this->getCreatePermissionName(),
            ...$this->getCreatePermissionParams()
        );
    }

    private function getCreatePermissionName(): string
    {
        return 'create';
    }

    abstract protected function getCreatePermissionParams(): array;
}
