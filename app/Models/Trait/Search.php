<?php

declare(strict_types = 1);

namespace App\Models\Trait;

trait Search
{
    public function scopeSearch($query, array $search, string | array | null $field = null): void
    {
        $query->where(function ($query) use ($search) {
            foreach ($search as $key => $value) {
                $query->where(function ($query) use ($key, $value) {
                    foreach ($value as $v) {
                        $query->orWhere($key, 'like', "%{$v}%");
                    }
                });
            }
        });
    }
}
