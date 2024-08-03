<?php

declare(strict_types = 1);

namespace App\Models\Trait;

trait Search
{
    public function scopeSearch($query, array $search, string | array | null $field = null): void
    {
        $searchFiltered = collect($search)
            ->filter(fn ($v, $k) => $k === $field || $field === null)
            ->except(['created_at'])
            ->toArray();

        $query->where(function ($query) use ($searchFiltered) {
            foreach ($searchFiltered as $key => $value) {
                $query->where(function ($query) use ($key, $value) {
                    foreach ($value as $v) {
                        $query->orWhere($key, 'like', "%{$v}%");
                    }
                });
            }
        });

        $table = (new self())->getTable();

        if (($search['created_at'] ?? null) && is_array($search['created_at'])) {
            $query->when(
                $search['created_at'][0],
                fn ($query) => $query->where($table . '.created_at', '>=', $search['created_at'][0])
            )
                ->when(
                    $search['created_at'][1] ?? null,
                    fn ($query) => $query->where($table . '.created_at', '<=', $search['created_at'][1])
                );
        }
    }
}
