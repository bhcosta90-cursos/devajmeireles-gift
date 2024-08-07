<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Permission;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Computed;

trait HasPermissionEdit
{
    use AuthorizesRequests;

    #[Computed]
    public function buttonEdit(): bool
    {
        return auth()->user()->can(
            $this->getEditPermissionName(),
            ...$this->getEditPermissionParams()
        );
    }

    private function getEditPermissionName(): string
    {
        return 'delete';
    }

    abstract protected function getEditPermissionParams(): array;
}
