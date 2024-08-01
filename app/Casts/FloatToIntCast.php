<?php

declare(strict_types = 1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class FloatToIntCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): float
    {
        return (float) bcdiv((string) $value, '100', 2);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        return (int) bcmul((string) $value, '100', 2);
    }
}
