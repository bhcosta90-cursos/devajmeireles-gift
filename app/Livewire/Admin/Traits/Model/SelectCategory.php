<?php

declare(strict_types = 1);

namespace App\Livewire\Traits\Model;

use App\Models\Category as ModelCategory;

trait SelectCategory
{
    public function listCategories(): array
    {
        return ModelCategory::query()
            ->active()
            ->get()
            ->map(function (ModelCategory $category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })
            ->toArray();
    }
}
