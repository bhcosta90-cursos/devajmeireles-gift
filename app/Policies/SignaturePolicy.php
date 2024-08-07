<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SignaturePolicy
{
    use HandlesAuthorization;

    public function manage(User $user): bool
    {
        return !$user->isGuest();
    }
}