<?php

declare(strict_types = 1);

namespace App\Action\Category;

use App\Models\Category;

class SelectCategoryAction
{
    protected static $response = [];

    public function __construct(protected Category $category)
    {
    }

    public function handle(): array
    {
        if (self::$response) {
            return self::$response;
        }

        return self::$response = $this->category
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
