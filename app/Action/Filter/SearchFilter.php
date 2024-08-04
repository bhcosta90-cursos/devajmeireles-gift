<?php

declare(strict_types = 1);

namespace App\Action\Filter;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Http\Request;

class SearchFilter
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $query, string $id = 'id', string $name = 'name'): array
    {
        return $query->search([
            'name' => [$this->request->get('search')],
        ])
            ->when($selected = $this->request->get('selected'), fn ($query) => $query->whereIn('id', json_decode($selected)))
            ->limit(30)
            ->get()
            ->map(fn (Model $item) => [
                'id'   => $item->{$id},
                'name' => $item->{$name},
            ])
            ->toArray();
    }
}
