<?php

declare(strict_types = 1);

namespace App\Action\Category;

use App\Models\Category;

class SelectCategoryAction
{
    public function __construct(protected Category $category)
    {
    }

    public function handle(): array
    {
        return $this->category
            ->active()
            ->get()
            ->map(function (Category $category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })
            ->toArray();
    }
}
