<?php

declare(strict_types = 1);

namespace App\Enums;

enum UserRole: int
{
    case Admin = 1;
    case User  = 2;
    case Guest = 3;
}
