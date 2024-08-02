<?php

declare(strict_types = 1);

namespace App\Models\Trait;

use JetBrains\PhpStorm\NoReturn;

trait Search
{
    #[NoReturn]
    public function scopeSearch($query, array $search, string|array|null $field = null): void
    {
        if($field !== null && !is_array($field)) {
                $field = [$field];
        }

        $table = with(new static)->getTable();

        $keys = collect(array_keys($search))
            ->filter(fn($key) => ($field && in_array($key, $field, true)) || $field === null)
            ->map(fn($key) => "{$table}.{$key}")
            ->toArray();

        $newValues = [];

        foreach ($search as $value) {
            foreach ($value as $v) {
                $newValues[] = $v;
            }
        }

        if ($newValues) {
            $query->where(function ($query) use ($keys, $newValues) {
                foreach ($newValues as $value) {
                    $query->orWhereAny($keys, 'like', "%{$value}%");
                }
            });
        }
    }
}
