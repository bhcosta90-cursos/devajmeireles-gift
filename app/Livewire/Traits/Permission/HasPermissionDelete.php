<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Permission;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Computed;

trait HasPermissionDelete
{
    use AuthorizesRequests;

    #[Computed]
    public function buttonDelete(): bool
    {
        return auth()->user()->can(
            $this->getDeletePermissionName(),
            ...$this->getDeletePermissionParams()
        );
    }

    private function getDeletePermissionName(): string
    {
        return 'delete';
    }

    abstract protected function getDeletePermissionParams(): array;
}
