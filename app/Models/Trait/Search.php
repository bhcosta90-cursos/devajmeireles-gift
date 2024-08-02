<?php

declare(strict_types = 1);

namespace App\Models\Trait;

trait Search
{
    public function scopeSearch($query, array $search): void
    {
        $keys = array_keys($search);

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
